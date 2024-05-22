<?php
// Fetch tenant information from the database
$dsn = "mysql:host=127.0.0.1;dbname=properteasedb";
$username = "root";
$password = "";

$pdo_01 = new PDO($dsn, $username, $password);
$pdo_01->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.html");
    exit;
}

$stmt = $pdo_01->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
$stmt->execute([$_SESSION['tenant_id']]);
$tenant = $stmt->fetch(PDO::FETCH_ASSOC);

// Function to decrypt data using AES-256
function decryptedData($data, $key)
{
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encryptedData = substr($data, 16);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}

// Function for encrypting data using AES-256-CBC
function encryptData($data, $key)
{
    $iv = openssl_random_pseudo_bytes(16); // Initialization vector
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

// Decrypt the data with the defined IV
$fname = decryptedData($tenant['tenant_fname'], $tenant['encryption_key']);
$lname = decryptedData($tenant['tenant_lname'], $tenant['encryption_key']);
$temail = $tenant['tenant_email'];
$contact = $tenant['tenant_contact'];
$taddress = decryptedData($tenant['tenant_address'], $tenant['encryption_key']);
$profile = decryptedData($tenant['tenant_dp'], $tenant['encryption_key']);
$profilePictureDirectory = '../img/profile/';
$imagePath = $profilePictureDirectory . $profile;

// Initialize variables
$firstName = $lastName = $contactNumber = $address = $email = $profilePicture = "";
$firstNameErr = $lastNameErr = $contactNumberErr = $addressErr = $emailErr = $profilePictureErr = "";

// Handle form submission for updating profile information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if (empty($_POST['edit-fname'])) {
        $firstNameErr = "First name is required";
    } else {
        $firstName = test_input($_POST['edit-fname']);
    }

    // Validate last name
    if (empty($_POST['edit-lname'])) {
        $lastNameErr = "Last name is required";
    } else {
        $lastName = test_input($_POST['edit-lname']);
    }

    // Validate contact number
    if (empty($_POST['edit-contact'])) {
        $contactNumberErr = "Contact number is required";
    } else {
        $contactNumber = test_input($_POST['edit-contact']);
    }

    // Validate address
    if (empty($_POST['edit-address'])) {
        $addressErr = "Address is required";
    } else {
        $address = test_input($_POST['edit-address']);
    }

    // Validate email separately
    if (empty($_POST['edit-email'])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST['edit-email']);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate profile picture
    if (empty($_FILES['edit-profile-image']['name'])) {
        $profilePictureErr = "Profile picture is required";
    } else {
        // List of accepted file extensions
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'jfif');

        $profilePicture = $_FILES['edit-profile-image']['name'];
        $fileExt = strtolower(pathinfo($profilePicture, PATHINFO_EXTENSION));

        // Validate file extension
        if (!in_array($fileExt, $allowedExtensions)) {
            $profilePictureErr = "Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF, JFIF";
        }
    }

    // Proceed if no validation errors
    if (empty($firstNameErr) && empty($lastNameErr) && empty($addressErr) && empty($emailErr) && empty($profilePictureErr)) {
        // Encrypt the updated information before saving to database
        $encrypted_fname = encryptData($_POST['edit-fname'], $tenant['encryption_key']);
        $encrypted_lname = encryptData($_POST['edit-lname'], $tenant['encryption_key']);
        $encrypted_address = encryptData($_POST['edit-address'], $tenant['encryption_key']);
        $updated_contact = $_POST['edit-contact'];
        $updated_email = $_POST['edit-email'];
        $encryptedProfilePicture = encryptData($_FILES['edit-profile-image']['name'], $tenant['encryption_key']);


        // Handle image upload and update if a new image is uploaded
        if (isset($_FILES["edit-profile-image"]) && $_FILES["edit-profile-image"]["error"] === UPLOAD_ERR_OK) {
            $targetDir = "img/profile/";
            $targetFile = $targetDir . basename($_FILES["edit-profile-image"]["name"]);
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Move uploaded file
            if (move_uploaded_file($_FILES["edit-profile-image"]["tmp_name"], $targetFile)) {
                // Update tenant information in the database with image path and encrypted data
                $updateStmt = $pdo_01->prepare("UPDATE tenant_tbl SET tenant_fname = ?, tenant_lname = ?, tenant_email = ?, tenant_contact = ?, tenant_address = ?, tenant_dp = ? WHERE tenant_id = ?");
                if($updateStmt->execute([$encrypted_fname, $encrypted_lname, $updated_email, $updated_contact, $encrypted_address, $encryptedProfilePicture, $_SESSION['tenant_id']])) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => 'Profile updated successfully.']);
                    exit;
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['error' => 'Failed to update profile. Please try again.']);
                    exit;
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Error uploading file.']);
                exit;
            }
        } else {
            // Update tenant information in the database without changing the image path
            $updateStmt = $pdo_01->prepare("UPDATE tenant_tbl SET tenant_fname = ?, tenant_lname = ?, tenant_email = ?, tenant_contact = ?, tenant_address = ?, tenant_dp = ? WHERE tenant_id = ?");
            if($updateStmt->execute([$encrypted_fname, $encrypted_lname, $updated_email, $updated_contact, $encrypted_address,  $_SESSION['tenant_id']])) {
                $response = ['success' => 'Profile updated successfully.'];
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            } else {
                $response = ['error' => 'Failed to update profile. Please try again.'];
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
        }
    } else {
        // Return validation errors
        $response = array(
            'firstNameErr' => $firstNameErr,
            'lastNameErr' => $lastNameErr,
            'contactNumberErr' => $contactNumberErr,
            'addressErr' => $addressErr,
            'emailErr' => $emailErr,
            'profilePictureErr' => $profilePictureErr,
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>