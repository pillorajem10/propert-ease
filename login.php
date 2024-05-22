<?php
session_start();
require_once('connect.php');

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
$email = $password = "";
$emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    // Check for errors
    if (empty($emailErr) && empty($passwordErr)) {

        // Perform login using prepared statements to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_email = ?");
        $stmt->execute([$email]);
        $tenant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tenant) {
            $encryptionKey = $tenant['encryption_key'];
            $firstName = decryptData($tenant['tenant_fname'], $encryptionKey);
            $lastName = decryptData($tenant['tenant_lname'], $encryptionKey);
            $email = $tenant['tenant_email'];
            $role = decryptData($tenant['tenant_role'], $encryptionKey);
            // Decrypt the password and verify
            $decryptedPassword = decryptData($tenant['tenant_pass'], $encryptionKey);

            if ($password == $decryptedPassword || password_verify($password, $decryptedPassword)) {
                if ($tenant['tenant_verifiedAt'] === NULL) {
                    $response = array('verify' => 'Verify first before logging in.');
                    $_SESSION['registration_data'] = [
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'email' => $email,
                        'role' => $role
                    ];
                } else {
                    if ($role === 'banned') {
                        $response = array('banned' => 'Your Account has been Banned.');
                    } else {
                        $_SESSION['tenant_id'] = $tenant['tenant_id'];
                        $_SESSION['tenant_email'] = $email;
                        $response = array('success' => 'Login successfully!');
                    }
                }
            } else {
                $response = array('passwordErr' => 'Invalid password.');
            }
        } else {
            $response = array('error' => 'Tenant not found.');
        }
    } else {
        // Return validation errors
        $response = array(
            'emailErr' => $emailErr, 
            'passwordErr' => $passwordErr
        );
        
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>