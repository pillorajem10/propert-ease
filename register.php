<?php
session_start();
require_once('connect.php');

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

// Initialize variables
$firstName = $lastName = $contactNumber = $address = $email = $password = $confirmPassword = $role = $type = $serial = $valid = $selfie = $agree = "";
$firstNameErr = $lastNameErr = $contactNumberErr = $addressErr = $emailErr = $passwordErr = $confirmPasswordErr = $roleErr = $typeErr = $serialErr = $validErr = $selfieErr = $agreeErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if (empty($_POST['first-name'])) {
        $firstNameErr = "First name is required";
    } else {
        $firstName = test_input($_POST['first-name']);
    }

    // Validate last name
    if (empty($_POST['last-name'])) {
        $lastNameErr = "Last name is required";
    } else {
        $lastName = test_input($_POST['last-name']);
    }

    // Validate contact number
    if (empty($_POST['contact-number'])) {
        $contactNumberErr = "Contact number is required";
    } else {
        $contactNumber = test_input($_POST['contact-number']);
    }

    // Validate address
    if (empty($_POST['address'])) {
        $addressErr = "Address is required";
    } else {
        $address = test_input($_POST['address']);
    }

    // Validate email separately
    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST['email']);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate password
    if (empty($_POST['password'])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST['password']);
    }

    // Validate password confirmation
    if (empty($_POST['confirm-password'])) {
        $confirmPasswordErr = "Confirm Password is required";
    } else {
        $confirmPassword = test_input($_POST['confirm-password']);
    }

    // Check if password matches confirmation
    if ($password !== $confirmPassword) {
        $confirmPasswordErr = "Passwords do not match";
    }

    // Validate role
    if (empty($_POST['role'])) {
        $roleErr = "Role is required";
    } else {
        $role = test_input($_POST['role']);
    }

    // Validate type of valid id
    if (empty($_POST['id-type'])) {
        $typeErr = "Type of valid id is required";
    } else {
        $type = test_input($_POST['id-type']);
    }

    // Validate serial number
    if (empty($_POST['serial-id'])) {
        $serialErr = "For security purposes, you must type your serial number";
    } else {
        $serial = test_input($_POST['serial-id']);
    }

    // Validate valid id
    if (empty($_FILES['valid-id']['name'])) {
        $validErr = "For security purposes, you must upload your valid id";
    } else {
        // Listahan ng tinatanggap na file extensions
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'jfif');

        $valid = $_FILES['valid-id']['name'];
        $fileExt = strtolower(pathinfo($valid, PATHINFO_EXTENSION));

        // I-validate ang file extension
        if (!in_array($fileExt, $allowedExtensions)) {
            $validErr = "Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF, JFIF";
        }
    }

    // Validate selfie id
    if (empty($_FILES['selfie-id']['name'])) {
        $selfieErr = "For security purposes, you must upload your selfie picture with your valid id";
    } else {
        // Listahan ng tinatanggap na file extensions
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'jfif');

        $selfie = $_FILES['selfie-id']['name'];
        $fileExt = strtolower(pathinfo($selfie, PATHINFO_EXTENSION));

        // I-validate ang file extension
        if (!in_array($fileExt, $allowedExtensions)) {
            $selfieErr = "Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF, JFIF";
        }
    }

    // Validate checkbox
    if (empty($_POST['agree-checkbox'])) {
        $agreeErr = "Checkmark is required";
    } else {
        $agree = test_input($_POST['agree-checkbox']);
    }

    // Check for errors
    if (empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($roleErr) && empty($validErr) && empty($selfieErr) && empty($agreeErr)) {
        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Combine first name and last name
        $combinedName = $firstName . ' ' . $lastName;

        try {
            // Check if the account already exists
            $existingRecord = null;
            if ($role === 'tenant') {
                $stmtCheck = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_email = ?");
            } else {
                $stmtCheck = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_email = ?");
            }
            $stmtCheck->execute([$email]);
            $existingRecord = $stmtCheck->fetch();

            if ($existingRecord) {
                $response = array('error' => 'The account with your email already exists.');
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }

            // Generate a random encryption key for storing sensitive data
            $encryptionKey = generateEncryptionKey();

            // Encrypt sensitive data before storing it in the database
            $encryptedValidId = encryptData($_FILES['valid-id']['name'], $encryptionKey);
            $encryptedSelfieId = encryptData($_FILES['selfie-id']['name'], $encryptionKey);
            $encryptedFirstName = encryptData($firstName, $encryptionKey);
            $encryptedLastName = encryptData($lastName, $encryptionKey);
            $encryptedAddress = encryptData($address, $encryptionKey);
            $encryptedPassword = encryptData($passwordHash, $encryptionKey);
            $encryptedRole = encryptData($role, $encryptionKey);
            $encryptedType = encryptData($type, $encryptionKey);
            $encryptedSerial = encryptData($serial, $encryptionKey);

            if ($role === 'tenant') {
                $stmt = $pdo->prepare("INSERT INTO tenant_tbl (tenant_fname, tenant_lname, tenant_contact, tenant_address, tenant_email, tenant_pass, tenant_role, tenant_idType, tenant_serial, tenant_validId, tenant_selfieId, tenant_verifiedAt, encryption_key) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DEFAULT, ?)");
            } else {
                $stmt = $pdo->prepare("INSERT INTO landlord_tbl (landlord_fname, landlord_lname, landlord_contact, landlord_address, landlord_email, landlord_pass, landlord_role, landlord_idType, landlord_serial, landlord_validId, landlord_selfieId, landlord_verifiedAt, encryption_key) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DEFAULT, ?)");
            }            
            $stmt->bindParam(1, $encryptedValidId);
            $stmt->bindParam(2, $encryptedSelfieId);
            $stmt->bindParam(3, $encryptedFirstName);
            $stmt->bindParam(4, $encryptedLastName);
            $stmt->bindParam(5, $contactNumber);
            $stmt->bindParam(6, $encryptedAddress);
            $stmt->bindParam(7, $email);
            $stmt->bindParam(8, $encryptedPassword);
            $stmt->bindParam(9, $encryptedRole);
            $stmt->bindParam(9, $encryptedType);
            $stmt->bindParam(10, $encryptedSerial);
            $stmt->bindParam(11, $encryptionKey);
            $stmt->execute();

            // Move uploaded valid id to destination directory
            $validIdDirectory = 'img/valid-id/';
            move_uploaded_file($_FILES['valid-id']['tmp_name'],  $validIdDirectory .  $_FILES['valid-id']['name']);

            // Move uploaded selfie id to destination directory
            $selfieIdDirectory = 'img/selfie-id/';
            move_uploaded_file($_FILES['selfie-id']['tmp_name'],  $selfieIdDirectory .  $_FILES['selfie-id']['name']);

            // Store registration data in session for verification
            $_SESSION['registration_data'] = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'role' => $role
            ];

            // Registration success message
            $response = array('success' => 'Registered Successfully!!! Proceed to email verification.');
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            // Database error
            $response = array('error' => 'Internal Server Error');
            http_response_code(500);
            echo json_encode($response);
            exit;
        }
    } else {
        // Return validation errors
        $response = array(
            'firstNameErr' => $firstNameErr,
            'lastNameErr' => $lastNameErr,
            'contactNumberErr' => $contactNumberErr,
            'addressErr' => $addressErr,
            'emailErr' => $emailErr,
            'passwordErr' => $passwordErr,
            'confirmPasswordErr' => $confirmPasswordErr,
            'roleErr' => $roleErr,
            'typeErr' => $typeErr,
            'serialErr' => $serialErr,
            'validErr' => $validErr,
            'selfieErr' => $selfieErr,
            'agreeErr' => $agreeErr
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