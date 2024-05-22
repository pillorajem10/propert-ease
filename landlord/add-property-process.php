<?php
session_start();

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

// Function to sanitize and validate input data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Include the database connection file
require_once('../connect.php');

// Initialize variables and error messages
$title = $description = $price = $rentalType = $occupancy = $address = $barangay = $city = $state = $zipCode = $propertyImage = $propertyVideo = $ownershipDocument = "";
$titleErr = $descriptionErr = $priceErr = $rentalTypeErr = $occupancyErr = $addressErr = $barangayErr = $cityErr = $stateErr = $zipCodeErr = $propertyImageErr = $propertyVideoErr = $ownershipDocumentErr = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate title
    if (empty($_POST['title'])) {
        $titleErr = "Title is required";
    } else {
        $title = test_input($_POST['title']);
    }

    // Validate description
    if (empty($_POST['description'])) {
        $descriptionErr = "Description is required";
    } else {
        $description = test_input($_POST['description']);
    }

    // Validate price
    if (empty($_POST['price'])) {
        $priceErr = "Price is required";
    } else {
        $price = test_input($_POST['price']);
    }

    // Validate rental type
    if (empty($_POST['rentalType'])) {
        $rentalTypeErr = "Rental Type is required";
    } else {
        $rentalType = test_input($_POST['rentalType']);
    }

    // Validate occupancy
    if (empty($_POST['occupancy'])) {
        $occupancyErr = "Occupancy is required";
    } else {
        $occupancy = test_input($_POST['occupancy']);
    }

    // Validate address
    if (empty($_POST['address'])) {
        $addressErr = "Address is required";
    } else {
        $address = test_input($_POST['address']);
    }

    // Validate barangay
    if (empty($_POST['barangay'])) {
        $barangayErr = "Barangay is required";
    } else {
        $barangay = test_input($_POST['barangay']);
    }

    // Validate city
    if (empty($_POST['city'])) {
        $cityErr = "City is required";
    } else {
        $city = test_input($_POST['city']);
    }

    // Validate state
    if (empty($_POST['state'])) {
        $stateErr = "State is required";
    } else {
        $state = test_input($_POST['state']);
    }

    // Validate ZIP code
    if (empty($_POST['zipCode'])) {
        $zipCodeErr = "ZIP Code is required";
    } else {
        $zipCode = test_input($_POST['zipCode']);
    }

    // Validate property image
    if (empty($_FILES['propertyImage']['name'])) {
        $propertyImageErr = "Property Image is required";
    } else {
        $propertyImage = $_FILES['propertyImage']['name'];
        $fileExt = strtolower(pathinfo($propertyImage, PATHINFO_EXTENSION));

        // List of accepted file extensions for image
        $allowedImageExtensions = array('jpg', 'jpeg', 'png', 'gif');

        // Validate file extension
        if (!in_array($fileExt, $allowedImageExtensions)) {
            $propertyImageErr = "Invalid image file format. Accepted formats: JPG, JPEG, PNG, GIF";
        }
    }

    // Validate property video
    if (empty($_FILES['propertyVideo']['name'])) {
        $propertyVideoErr = "Property Video is required";
    } else {
        $propertyVideo = $_FILES['propertyVideo']['name'];
        $fileExt = strtolower(pathinfo($propertyVideo, PATHINFO_EXTENSION));

        // List of accepted file extensions for video
        $allowedVideoExtensions = array('mp4', 'avi', 'mov', 'wmv');

        // Validate file extension
        if (!in_array($fileExt, $allowedVideoExtensions)) {
            $propertyVideoErr = "Invalid video file format. Accepted formats: MP4, AVI, MOV, WMV";
        }
    }

    // Validate ownership document
    if (empty($_FILES['ownershipDocument']['name'])) {
        $ownershipDocumentErr = "Ownership Document is required";
    } else {
        $ownershipDocument = $_FILES['ownershipDocument']['name'];
        // Check file extension
        $allowedExtensions = array('pdf', 'doc', 'docx');
        $fileExt = strtolower(pathinfo($ownershipDocument, PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowedExtensions)) {
            $ownershipDocumentErr = "Invalid file format. Accepted formats: PDF, DOC, DOCX";
        }
    }

    // Check if any validation errors occurred
    if (
        $titleErr || $descriptionErr || $priceErr || $rentalTypeErr || $occupancyErr ||
        $addressErr || $barangayErr || $cityErr || $stateErr || $zipCodeErr ||
        $propertyImageErr || $propertyVideoErr || $ownershipDocumentErr
    ) {
        // Return validation errors
        $response = array(
            'titleErr' => $titleErr,
            'descriptionErr' => $descriptionErr,
            'priceErr' => $priceErr,
            'rentalTypeErr' => $rentalTypeErr,
            'occupancyErr' => $occupancyErr,
            'addressErr' => $addressErr,
            'barangayErr' => $barangayErr,
            'cityErr' => $cityErr,
            'stateErr' => $stateErr,
            'zipCodeErr' => $zipCodeErr,
            'propertyImageErr' => $propertyImageErr,
            'propertyVideoErr' => $propertyVideoErr,
            'ownershipDocumentErr' => $ownershipDocumentErr
        );

        // Set the response header to JSON
        header('Content-Type: application/json');

        // Encode the response array into JSON format and output
        echo json_encode($response);

        // Exit to stop further execution
        exit;
    }

    // Generate a random encryption key for storing sensitive data
    $encryptionKey = generateEncryptionKey();

    // Get form data
    $landlordId = $_SESSION['landlord_id'];
    $propertyName = test_input($_POST['title']);
    $propertyDescription = test_input($_POST['description']);
    $propertyPrice = $_POST['price'];
    $propertyDue = $_POST['dueDate'];
    $propertyType = test_input($_POST['rentalType']);
    $propertyOccupancy = $_POST['occupancy'];
    $propertyAddress = test_input($_POST['address']);
    $propertyBrgy = test_input($_POST['barangay']);
    $propertyCity = test_input($_POST['city']);
    $propertyProvince = test_input($_POST['state']);
    $propertyZipcode = test_input($_POST['zipCode']);

    // Check if the property with the same name and address already exists
    $stmtCheckDuplicate = $pdo->prepare("SELECT * FROM property_tbl WHERE landlord_id = ? AND property_name = ? AND property_address = ?");
    $stmtCheckDuplicate->execute([$landlordId, $propertyName, $propertyAddress]);

    if ($stmtCheckDuplicate->rowCount() > 0) {
        $response = array('warning' => 'Property with the same name and address already exists. Please choose a different name or address.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Process propertyImage file (redundant data from original script)
    $propertyImageName = $_FILES['propertyImage']['name'];
    $propertyImageTemp = $_FILES['propertyImage']['tmp_name'];
    $propertyImagePath1 = '../img/' . $propertyImageName;
    $propertyImagePath = 'property/' . $propertyImageName;
    move_uploaded_file($propertyImageTemp, $propertyImagePath1);

    // Process propertyVideo file (redundant data from original script)
    $propertyVideoName = $_FILES['propertyVideo']['name'];
    $propertyVideoTemp = $_FILES['propertyVideo']['tmp_name'];
    $propertyVideoPath1 = '../vid/' . $propertyVideoName;
    $propertyVideoPath = 'vid/' . $propertyVideoName;
    move_uploaded_file($propertyVideoTemp, $propertyVideoPath1);

    // Process ownershipDocument file (redundant data from original script)
    $ownershipDocumentName = $_FILES['ownershipDocument']['name'];
    $ownershipDocumentTemp = $_FILES['ownershipDocument']['tmp_name'];
    $ownershipDocumentPath1 = '../documents/' . $ownershipDocumentName;
    $ownershipDocumentPath = 'documents/' . $ownershipDocumentName;
    move_uploaded_file($ownershipDocumentTemp, $ownershipDocumentPath1);

    // Set property_status to "pending"
    $propertyStatus = "Pending";

    // Encrypt sensitive data before storing it in the database
    $encryptedpropertyName = encryptData($propertyName, $encryptionKey);
    $encryptedpropertyDescription = encryptData($propertyDescription, $encryptionKey);
    $encryptedpropertyPrice = encryptData($propertyPrice, $encryptionKey);
    $encryptedpropertyType = encryptData($propertyType, $encryptionKey);
    $encryptedpropertyOccupancy = encryptData($propertyOccupancy, $encryptionKey);
    $encryptedpropertyAddress = encryptData($propertyAddress, $encryptionKey);
    $encryptedpropertyBrgy = encryptData($propertyBrgy, $encryptionKey);
    $encryptedpropertyCity = encryptData($propertyCity, $encryptionKey);
    $encryptedpropertyProvince = encryptData($propertyProvince, $encryptionKey);
    $encryptedpropertyImageName = encryptData($propertyImageName, $encryptionKey);
    $encryptedpropertyVideoName = encryptData($propertyVideoName, $encryptionKey);
    $encryptedownershipDocumentName = encryptData($ownershipDocumentName, $encryptionKey);

    // Insert data into the property_tbl
    $stmt = $pdo->prepare("
        INSERT INTO property_tbl (
            landlord_id,
            property_name,
            property_description,
            property_price,
            property_due,
            property_type,
            property_occupancy,
            property_address,
            property_brgy,
            property_city,
            property_province,
            property_zipcode,
            property_img,
            property_vid,
            property_docu,
            property_status,
            property_verifiedAt,
            encryption_key
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DEFAULT, ?)
    ");

    $stmt->execute([
        $landlordId,
        $encryptedpropertyName,
        $encryptedpropertyDescription,
        $encryptedpropertyPrice,
        $propertyDue,
        $propertyType,
        $encryptedpropertyOccupancy,
        $encryptedpropertyAddress,
        $encryptedpropertyBrgy,
        $encryptedpropertyCity,
        $encryptedpropertyProvince,
        $propertyZipcode,
        $encryptedpropertyImageName,
        $encryptedpropertyVideoName,
        $encryptedownershipDocumentName,
        $propertyStatus,
        $encryptionKey
    ]);

    // Check if the insertion was successful
    if ($stmt->rowCount() > 0) {
        $response = array('success' => 'Property added successfully!');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } else {
        $response = array('error' => 'Error adding property. Please try again.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
} else {
    // Return Method Not Allowed error
    http_response_code(405);
    $response = array('error' => 'Method Not Allowed.');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>