<?php
session_start();
require_once('../../connect.php');

// Function to encrypt data using AES-256
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

// Initialize variables
$currentPassword = $newPassword = $confirmPassword = '';
$currentPasswordErr = $newPasswordErr = $confirmPasswordErr = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate current password
    if (empty($_POST['current-password'])) {
        $currentPasswordErr = "Current password is required";
    } else {
        $currentPassword = test_input1($_POST['current-password']);
    }

    // Validate new password
    if (empty($_POST['new-password'])) {
        $newPasswordErr = "New password is required";
    } else {
        $newPassword = test_input1($_POST['new-password']);
    }

    // Validate confirm password
    if (empty($_POST['confirm-password'])) {
        $confirmPasswordErr = "Confirm password is required";
    } else {
        $confirmPassword = test_input1($_POST['confirm-password']);
    }

    // Check if new password matches confirm password
    if ($newPassword !== $confirmPassword) {
        $confirmPasswordErr = "Passwords do not match";
    }

    // Check for any validation errors
    if (empty($currentPasswordErr) && empty($newPasswordErr) && empty($confirmPasswordErr)) {
        // Retrieve user data and perform password change logic
        if (isset($_SESSION['landlord_id'])) {
            $userId = $_SESSION['landlord_id'];

            // Fetch user data from database
            $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $encryptionKey = $user['encryption_key'];
            $decryptedPassword = decryptData($user['landlord_pass'], $encryptionKey);

            if ($currentPassword == $decryptedPassword || password_verify($currentPassword, $decryptedPassword)) {

                // Encrypt the new password
                $encryptedPassword = encryptData($newPassword, $encryptionKey);

                // Decrypt and retrieve previous passwords
                $encryptedPrevPasswords = $user['landlord_prevpass'];
                $decryptedPrevPasswords = decryptData($encryptedPrevPasswords, $encryptionKey);
                $previousPasswords = json_decode($decryptedPrevPasswords, true);

                // Check if the new password matches any of the previous passwords
                if (is_array($previousPasswords) && in_array($newPassword, $previousPasswords)) {
                    // New password matches a previous new password
                    http_response_code(400);
                    echo json_encode(['error' => 'You cannot change to a previously used new password']);
                    exit;
                }

                // Update the user's password and previous passwords in the database
                $previousPasswords[] = $newPassword;
                $previousPasswords = array_slice($previousPasswords, -5);

                // Encrypt the updated previous passwords
                $encryptedUpdatedPrevPasswords = encryptData(json_encode($previousPasswords), $encryptionKey);

                $updateStmt = $pdo->prepare("UPDATE landlord_tbl SET landlord_pass = ?, landlord_prevpass = ? WHERE landlord_id = ?");
                if ($updateStmt->execute([$encryptedPassword, $encryptedUpdatedPrevPasswords, $userId])) {
                    // Password change successful
                    http_response_code(200);
                    echo json_encode(['success' => 'Password changed successfully']);
                    exit;
                } else {
                    // Error updating password
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to update password']);
                    exit;
                }
            } else {
                // Incorrect current password
                http_response_code(401);
                echo json_encode(['error' => 'Incorrect current password']);
                exit;
            }
        } else {
            // User not logged in
            http_response_code(401);
            echo json_encode(['error' => 'User is not logged in']);
            exit;
        }
    } else {
        // Validation errors encountered
        http_response_code(400);
        $response = [
            'currentPasswordErr' => $currentPasswordErr,
            'newPasswordErr' => $newPasswordErr,
            'confirmPasswordErr' => $confirmPasswordErr
        ];
        echo json_encode($response);
        exit;
    }
}

// Function to sanitize and validate input data
function test_input1($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>