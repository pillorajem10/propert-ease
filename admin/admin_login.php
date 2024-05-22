<?php
session_start();
require_once('../connect.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables
    $username = $password = "";
    $usernameErr = $passwordErr = "";
    $adminID = '1';

    // Function to sanitize and validate input data
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
    }

    $stmt = $pdo->prepare("SELECT * FROM admin_tbl WHERE admin_id = ? AND admin_username = ?");
    $stmt->execute([$adminID, $username]);
    $adminData = $stmt->fetch();

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        $encryptionKey = $adminData['encryption_key'];
        $decryptedPassword = decryptData($adminData['admin_pass'], $encryptionKey);
    }

    // Check for errors
    if (empty($usernameErr) && empty($passwordErr)) {
        // Perform login
        if ($adminData) {
            if (password_verify($password, $decryptedPassword)) {
                $_SESSION['admin'] = $adminID;
                $_SESSION['username'] = $username;
                $response = array('success' => 'Login successfully!');
            } else {
                $response = array('error' => 'Invalid password.');
            }
        } else {
            $response = array('error' => 'Admin not found.');
        }
    } else {
        // Return validation errors
        $response = array('usernameErr' => $usernameErr, 'passwordErr' => $passwordErr);
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

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

// Function to decrypt data using AES-256
function decryptData($data, $key)
{
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encryptedData = substr($data, 16);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}
?>