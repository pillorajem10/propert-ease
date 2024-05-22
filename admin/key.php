<?php
require_once('../connect.php');

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

$username = 'Admin';
$rawPassword = 'Admin@1234';

// Hash the password
$hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

// Generate a random encryption key for storing sensitive data
$encryptionKey = generateEncryptionKey();

// Encrypt sensitive data before storing it in the database
$encryptedPassword = encryptData($hashedPassword, $encryptionKey);

try {
    // Insert the username, encrypted password, and encryption key into the database
    $stmt = $pdo->prepare("INSERT INTO admin_tbl (admin_username, admin_pass, encryption_key) VALUES (?, ?, ?)");
    $stmt->execute([$username, $encryptedPassword, $encryptionKey]);

    echo "Username, encrypted password, and encryption key inserted successfully!";
    header("Location: login.html");
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}
?>