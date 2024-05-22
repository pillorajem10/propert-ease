<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('connect.php');
require 'vendor/autoload.php';

// Function to generate a random AES-256 encryption key
function generateEncryptionKey()
{
    return openssl_random_pseudo_bytes(32); // 256 bits
}

// Function to encrypt data using AES-256
function encryptData($data, $key)
{
    $iv = openssl_random_pseudo_bytes(16); // Initialization vector
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

// Initialize variables
$email = "";
$emailErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Check for errors
    if (empty($emailErr)) {
        try {
            // Check if email verification exists in the database
            $stmt = $pdo->prepare("SELECT * FROM verification_tbl WHERE email = ?");
            $stmt->execute([$email]);
            $existingVerification = $stmt->fetch();

            if ($existingVerification) {
                // Check if the verification code has been used
                    // Email verification exists but not used yet, return error response
                    $response = array('exist' => 'Email verification already exists!');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
            } else{

                // Proceed with generating new verification code
                $verificationCode = mt_rand(100000, 999999);

                // Encrypt verification code
                $encryptionKey = generateEncryptionKey();
                $encryptedVerificationCode = encryptData($verificationCode, $encryptionKey);

                // Save encrypted verification code to database
                $stmt = $pdo->prepare("INSERT INTO verification_tbl (email, code, encryption_key) VALUES (?, ?, ?)");
                $stmt->execute([$email, $encryptedVerificationCode, $encryptionKey]);

                // Send verification email to the user
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';  // Specify SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'propertease20@gmail.com';  // SMTP username
                $mail->Password = 'elchzrklqbuefccw';  // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom($email);
                $mail->addAddress($email); // Send verification email to the user

                $mail->isHTML(true);
                $mail->Subject = 'Email Verification';
                $mail->Body = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Email Verification</title>
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
                            padding: 20px;
                            background-color: #ffffff;
                            border-radius: 10px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            background-color: #ffffff;
                            padding: 20px;
                            border-bottom: 1px solid #008489;
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
                        }
                        .verification-code {
                            background-color: #008489;
                            color: #ffffff;
                            padding: 15px 20px;
                            border-radius: 5px;
                            font-weight: bold;
                            font-size: 18px;
                            margin-top: 20px;
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
                            <p>Hello,</p>
                            <p>Thank you for signing up with Propert-Ease. Your verification code is:</p>
                            <p class="verification-code">' . $verificationCode . '</p>
                            <p>If you did not sign up for an Propert-Ease account, please disregard this email.</p>
                        </div>
                        <div class="footer">
                            <p>This email was sent to you because you registered on Propert-Ease. If you have any questions, please <a href="https://propert-ease.site/contact.php">Contact us</a>.</p>
                        </div>
                    </div>
                </body>
                </html>';

                // Load the image file content
                $logoContent = file_get_contents('img/app-logo.png');

                // Attach the image to the email
                $mail->AddEmbeddedImage('img/app-logo.png', 'logo', 'app-logo.png');

                // Set the email body
                $mail->Body = str_replace('src="img/app-logo.png"', 'src="cid:logo"', $mail->Body);

                if ($mail->send()) {
                    // Redirect to confirmation page
                    $_SESSION['email'] = $email; // Store email in session for confirmation page
                    $response = array('success' => 'Verification code sent successfully!');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                } else {
                    $response = array('error' => 'Failed to send verification code. Please try again later.');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                }
            }
        } catch (PDOException $e) {
            error_log("PDO Exception: " . $e->getMessage(), 0);
            $response = array('error' => 'Internal Server Error', 'message' => $e->getMessage());
            http_response_code(500);
            echo json_encode($response);
            exit;
        }
    } else {
        // Return validation errors
        $response = array('error' => $emailErr);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// Function to sanitize and validate input data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>