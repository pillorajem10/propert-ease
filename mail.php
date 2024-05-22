<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include encryption functions
function generateEncryptionKey()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}

function encryptData($data, $key)
{
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($data, $key)
{
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encryptedData = substr($data, 16);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

require 'vendor/autoload.php';
require_once('connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yourName = isset($_POST['yourname']) ? $_POST['yourname'] : '';
    $yourEmail = isset($_POST['youremail']) ? $_POST['youremail'] : '';
    $bookingMessage = isset($_POST['booking_message']) ? $_POST['booking_message'] : '';
    $bookingDate = isset($_POST['booking_date']) ? $_POST['booking_date'] : '';
    $propertyId = isset($_SESSION['property_id']) ? $_SESSION['property_id'] : '';



    // Encrypt sensitive data
    $encryptedBookingDate = $bookingDate;
    $encryptedBookingMessage = $bookingMessage;

    // Fetch property details
    $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
    $stmt->execute([$propertyId]);
    $property = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch landlord details
    $landlordId = $property['landlord_id'];
    $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
    $stmt->execute([$landlordId]);
    $landlord = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch tenant details
    $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_email = ?");
    $stmt->execute([$yourEmail]);
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC);
    $tenantId = $tenant['tenant_id'];

    $stmt = $pdo->prepare("SELECT * FROM pending_tbl WHERE tenant_id = ?");
    $stmt->execute([$tenantId]);
    $pending = $stmt->fetch(PDO::FETCH_ASSOC);   

    $recipientEmail = $landlord['landlord_email'];

    // Instantiate PHPMailer
    $mail = new PHPMailer(true);
    if($pending){
        $response = array('error' => 'Booking email already exists.');
    } else{
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'propertease20@gmail.com';
            $mail->Password = 'elchzrklqbuefccw';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom($yourEmail, $yourName);
            $mail->addAddress($recipientEmail);

            // Format bookingDate to desired format
            $formattedBookingDate = date('F j, Y', strtotime($bookingDate));

            // Email Template
            $mail->isHTML(true);
            $mail->Subject = 'Tenant Application';
            $mail->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>New Tenant Application</title>
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
                        <h1>New Tenant Application</h1>
                        <p><strong>Name:</strong> ' . $yourName . '</p>
                        <p><strong>Email:</strong> ' . $yourEmail . '</p>
                        <p><strong>Booking Date:</strong> ' . $formattedBookingDate . '</p>
                        <p><strong>Message:</strong><br>' . nl2br($bookingMessage) . '</p>
                    </div>
                    <div class="footer">
                        <p>This email was sent to you because a tenant has submitted a new tenant application. If you have any questions, please <a href="https://propert-ease.site/contact">Contact us</a>.</p>
                    </div>
                </div>
            </body>
            </html>';


            // Load the image file content
            $logoContent = file_get_contents('img/app-logo.png');

            // Attach the image to the email
            $mail->AddEmbeddedImage('img/app-logo.png', 'logo', 'app-logo.png');

            // Send the email
            $mail->send();

            // Insert into pending_tbl with encrypted data
            $stmt = $pdo->prepare("INSERT INTO pending_tbl (tenant_id, property_id, landlord_id, pending_bookedDate, pending_message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$tenantId, $propertyId, $landlordId, $encryptedBookingDate, $encryptedBookingMessage]);

            $response = array('success' => 'Booking email sent successfully');
        } catch (Exception $e) {
            $response = array('error' => 'Email could not be sent. Please try again later.');
        }
    }
} else {
    http_response_code(405);
    $response = array('error' => 'Method Not Allowed.');
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>