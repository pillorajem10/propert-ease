<?php
session_start();
require_once('connect.php');

// Initialize variables
$verificationCode = "";
$verificationCodeErr = "";

function encryptData($data, $key)
{
    $iv = openssl_random_pseudo_bytes(16); // Initialization vector
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($data, $key)
{
  $data = base64_decode($data);
  $iv = substr($data, 0, 16);
  $encryptedData = substr($data, 16);
  return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_SESSION['email'])) {
            $response = array('error' => 'Session email not set.');
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }


        // Validate verification code
        if (empty($_POST["verification_code"])) {
            $verificationCodeErr = "Verification code is required";
            $response = array('error' => $verificationCodeErr);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            $verificationCode = test_input($_POST["verification_code"]);
        }

        $email = $_SESSION['email'];

        $stmt = $pdo->prepare("SELECT * FROM verifyemail_tbl WHERE email = ?");
        $stmt->execute([$email]);
        $verif = $stmt->fetch(PDO::FETCH_ASSOC); 

        $encryptionKey = $verif['encryption_key'];
        $encryptedCode = $verif['code'];
        $code = decryptData($encryptedCode, $encryptionKey);

        // Check if verification code matches the one stored in the database

        if ($verificationCode === $code) {
            if ($_SESSION['registration_data']['role'] === 'landlord') {
                $stmt = $pdo->prepare("UPDATE landlord_tbl SET landlord_verifiedAt = CURRENT_TIMESTAMP WHERE landlord_email = ?");
                $stmt->execute([$email]);
            } else {
                $stmt = $pdo->prepare("UPDATE tenant_tbl SET tenant_verifiedAt = CURRENT_TIMESTAMP WHERE tenant_email = ?");
                $stmt->execute([$email]);
            }

            unset($_SESSION['registration_data']);
            $stmt = $pdo->prepare("DELETE FROM verifyemail_tbl WHERE email = ?");
            $stmt->execute([$email]);

            $response = array('success' => 'Email successfully verified!');
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            $response = array('error' => 'Invalid verification code. Please try again.');
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    } catch (PDOException $e) {
        error_log("PDO Exception: " . $e->getMessage(), 0);
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        exit;
    }
} else {
    echo "Invalid request.";
}

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>