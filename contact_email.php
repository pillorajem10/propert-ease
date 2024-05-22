<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once('connect.php');
session_start();


// Function to generate a random AES-256 encryption key
function generateEncryptionKey()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}

// Function to encrypt data using AES-256
function encryptData($data, $key)
{
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted);
}

// Function to decrypt data using AES-256
function decryptData($data, $key)
{
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encryptedData = substr($data, 16);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

// Function to sanitize and validate input data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5);
    return $data;
}

// Initialize variables
$name = $email = $phone = $message = "";
$nameErr = $emailErr = $phoneErr = $messageErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Fullname is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Contact number is required";
    } else {
        $phone = test_input($_POST["phone"]);
    }

    // Validate message
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }

    // Check if there are any validation errors
    if (empty($nameErr) && empty($emailErr) && empty($messageErr) && empty($phoneErr)) {
            // Check if a similar entry already exists
            $stmtCheck = $pdo->prepare("SELECT COUNT(*) AS count FROM contact_tbl WHERE  name = ? AND email = ? AND phone = ? AND message = ?");
            $stmtCheck->execute([$name, $email, $phone, $message]);
            $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($resultCheck && $resultCheck['count'] > 0) {
                // Duplicate entry found
                http_response_code(400); // Bad Request
                echo json_encode(array('error' => 'Duplicate entry.'));
                exit;
            }

            // Generate encryption key
            $encryptionKey = generateEncryptionKey();

            // Encrypt data
            $encryptedName = encryptData($name, $encryptionKey);
            $encryptedEmail = encryptData($email, $encryptionKey);
            $encryptedPhone = $phone;
            $encryptedMessage = encryptData($message, $encryptionKey);

            // Decrypt encrypted fields for email template
            $decryptedName = decryptData($encryptedName, $encryptionKey);
            $decryptedEmail = decryptData($encryptedEmail, $encryptionKey);
            $decryptedPhone = $encryptedPhone;
            $decryptedMessage = decryptData($encryptedMessage, $encryptionKey);

            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'propertease20@gmail.com';
                $mail->Password = 'elchzrklqbuefccw';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom($decryptedEmail, $decryptedName);
                $mail->addAddress('propertease20@gmail.com');

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Contact from tenant: ' . $decryptedName;

                // Email Template with decrypted data
                $emailBody = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>New Contact Form Submission</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f7f7f7;
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 0;
                            background-color: #ffffff;
                            border-radius: 10px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            background-color: #ffffff;
                            padding: 20px;
                            border-bottom: 1px solid #008489;
                            text-align: center;
                        }
                        .header img {
                            width: 100px;
                            height: auto;
                        }
                        .content {
                            padding: 20px;
                        }
                        p {
                            color: #555;
                            font-size: 16px;
                            line-height: 1.5;
                            margin-bottom: 15px;
                        }
                        .footer {
                            background-color: #ffffff;
                            padding: 20px;
                            border-top: 1px solid #008489;
                            text-align: center;
                            font-size: 14px;
                            color: #999999;
                        }
                        .footer a {
                            color: #007BFF;
                            text-decoration: none;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="header">
                            <img src="cid:logo" alt="Logo">
                        </div>
                        <div class="content">
                            <h1>New Contact Form Submission</h1>
                            <p><strong>Name:</strong> ' . $decryptedName . '</p>
                            <p><strong>Email:</strong> ' . $decryptedEmail . '</p>
                            <p><strong>Phone:</strong> ' . $decryptedPhone . '</p>
                            <p><strong>Message:</strong><br>' . $decryptedMessage . '</p>
                        </div>
                        <div class="footer">
                            <p>This email was sent to you because of a new contact form submission. If you have any questions, please <a href="https://propert-ease.site/contact.php">Contact us</a>.</p>
                        </div>
                    </div>
                </body>
                </html>';

                // Load the image file content
                $logoContent = file_get_contents('img/app-logo.png');

                // Attach the image to the email
                $mail->addEmbeddedImage('img/app-logo.png', 'logo', 'app-logo.png');

                // Set the email body and replace image source
                $mail->Body = str_replace('src="img/app-logo.png"', 'src="cid:logo"', $emailBody);

                // Send the email
                $mail->send();

                // Insert into database with encrypted data
                $stmt = $pdo->prepare("INSERT INTO contact_tbl (name, email, phone, message, encryption_key) VALUES (?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $encryptedName);
                $stmt->bindParam(2, $encryptedEmail);
                $stmt->bindParam(3, $encryptedPhone);
                $stmt->bindParam(4, $encryptedMessage);
                $stmt->bindParam(5, $encryptionKey);

                // Execute the prepared statement
                $stmt->execute();

                // Success response
                http_response_code(200); // OK
                $response= array('success' => 'Message sent successfully!');
            } 
            catch (Exception $e) {
                // Error handling
                http_response_code(500); // Internal Server Error
                $response= array('error' => 'Failed to send message. Please try again later.');
            }
        
    } else {
        // Validation errors
        http_response_code(400); // Bad Request
        $response = array(
            'nameErr' => $nameErr,
            'emailErr' => $emailErr,
            'phoneErr' => $phoneErr,
            'messageErr' => $messageErr
        );
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    $response = array('error' => 'Invalid request method.');
}
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>