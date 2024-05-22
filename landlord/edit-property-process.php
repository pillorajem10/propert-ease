<?php
session_start();

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
$title = $description = $price = $dueDate = $rentalType = $occupancy = $address = $barangay = $city = $state = $zipCode = $propertyImage = $propertyVideo = $ownershipDocument = "";
$titleErr = $descriptionErr = $priceErr = $dueDateErr = $rentalTypeErr = $occupancyErr = $addressErr = $barangayErr = $cityErr = $stateErr = $zipCodeErr = $propertyImageErr = $propertyVideoErr = $ownershipDocumentErr = "";

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

    if (empty($_POST['dueDate'])) {
        $dueDateErr = "Due date is required";
    } else {
        $dueDate = test_input($_POST['dueDate']);
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
    if (empty($_FILES['propertyImage'])) {
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
    if (empty($_FILES['propertyVideo'])) {
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
    if (empty($_FILES['ownershipDocument'])) {
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
        empty($titleErr) && 
        empty($descriptionErr) && 
        empty($priceErr) && 
        empty($dueDateErr) && 
        empty($rentalTypeErr) && 
        empty($occupancyErr) &&
        empty($addressErr) && 
        empty($barangayErr) && 
        empty($cityErr) && 
        empty($stateErr) && 
        empty($zipCodeErr) &&
        empty($propertyImageErr) && 
        empty($propertyVideoErr) && 
        empty($ownershipDocumentErr)
    ) {   

        // Get form data
        $landlordId = $_SESSION['landlord_id'];
        $propertyId = $_POST['property_id'];
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

        $stmt = $pdo -> prepare("SELECT * FROM property_tbl where property_id = ?");
        $stmt-> execute([$propertyId]);
        $property= $stmt->fetch();

        $encryptionKey = $property['encryption_key'];
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

        // Update data into the property_tbl
        $stmt = $pdo->prepare("
            UPDATE property_tbl
            SET
                property_name = ?,
                property_description = ?,
                property_price = ?,
                property_due = ?,
                property_type = ?,
                property_occupancy = ?,
                property_address = ?,
                property_brgy = ?,
                property_city = ?,
                property_province = ?,
                property_zipcode = ?,
                property_img = ?,
                property_vid = ?,
                property_docu = ?,
                encryption_key =?
            WHERE landlord_id = ? AND property_id = ?
        ");

        $stmt->execute([

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
            $encryptionKey,
            $landlordId,
            $propertyId
        ]);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            $response = array('success' => 'Property updated successfully!');

        } else {
            $response = array('error' => 'Error updating property. Please try again.');
        }
    }else{
        // Return validation errors
        $response = array(
            'titleErr' => $titleErr,
            'descriptionErr' => $descriptionErr,
            'priceErr' => $priceErr,
            'dueDateErr' => $dueDateErr,
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
    }
} else {
    // Return Method Not Allowed error
    http_response_code(405);
    $response = array('error' => 'Method Not Allowed.');
}
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>