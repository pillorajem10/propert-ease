<?php
if (!isset($_SESSION['landlord_id'])) {
    // Redirect to the login page
    header("Location: login.html");
    exit;
}

// Check if the property ID is provided via URL parameter
if (!isset($_GET['id'])) {
    header("Location: property-list.php");
    exit;
}

$propertyId = $_GET['id'];
$landlordId = $_SESSION['landlord_id'];

$landlordStmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
$landlordStmt->execute([$landlordId]);
$landlord = $landlordStmt->fetch(PDO::FETCH_ASSOC);

// Fetch property details from the database
$stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE landlord_id = ? AND property_id = ?");
$stmt->execute([$landlordId, $propertyId]);

// Check if property exists and retrieve its details
if ($stmt->rowCount() > 0) {
    $property = $stmt->fetch(PDO::FETCH_ASSOC);

    // Extract property details
    $propertyName = $property['property_name'];
    $propertyDescription = $property['property_description'];
    $propertyPrice = $property['property_price'];
    $propertyDue = $property['property_due'];
    $propertyType = $property['property_type'];
    $propertyOccupancy = $property['property_occupancy'];
    $propertyAddress = $property['property_address'];
    $propertyBrgy = $property['property_brgy'];
    $propertyCity = $property['property_city'];
    $propertyProvince = $property['property_province'];
    $propertyZipcode = $property['property_zipcode'];
} else {
    // Redirect to property list if property not found
    header("Location: property-list.php");
    exit;
}
?>