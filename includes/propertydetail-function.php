<?php
// Check if the user is logged in and tenant_id is set in the session
if (isset($_SESSION['tenant_id']) && !empty($_SESSION['tenant_id'])) {
    $tenantId = $_SESSION['tenant_id'];
    // Fetch tenant information based on tenant_id
    $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
    $stmt->execute([$tenantId]);
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC); 

    // Check if the tenant is banned
    if ($tenant['tenant_role'] === 'banned') {
        unset($_SESSION['tenant_id']);
        header("Location: index.php");
        exit;
    }


} else {
    // Redirect to the rental list page if the tenant is not registered
    header("Location: index.php");
    exit;
}

// Fetch contact information from the database
$adminId = 1;
$stmtContact = $pdo->prepare("SELECT * FROM admin_tbl WHERE admin_id =?");
$stmtContact->execute([$adminId]);
$contactInfo = $stmtContact->fetch(PDO::FETCH_ASSOC);

$minDate = date('Y-m-d');

// Fetch property details
if (isset($_SESSION['property_id']) && !empty($_SESSION['property_id'])) {
    try {
        // Prevent SQL Injection by using prepared statements
        $propertyId = $_SESSION['property_id'];
        $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
        $stmt->execute([$propertyId]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);
        // Check if property exists
        if (!$property) {
            throw new Exception("Property not found.");
        }
        // Fetch landlord details
        $landlordId = $property['landlord_id'];
        $stmt1 = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
        $stmt1->execute([$landlordId]);
        $landlord = $stmt1->fetch(PDO::FETCH_ASSOC);
        // Fetch tenant details
        // $tenantId = $_SESSION['tenant_id'];
        // $stmt2 = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id =?");
        // $stmt2->execute([$tenantId]);
        // $tenant = $stmt2->fetch(PDO::FETCH_ASSOC); 
        // Fetch reviews for the property

        $stmt = $pdo->prepare("SELECT * FROM review_tbl where property_id = ?");
        $stmt->execute([$propertyId]);
        $reviewCount = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM review_tbl where property_id = ? && tenant_id != ?");
        $stmt->execute([$propertyId, $tenantId]);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM review_tbl where  property_id = ? && tenant_id = ?");
        $stmt->execute([$propertyId, $tenantId]);
        $tenantReview = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tenantReview){
        $tenantReviewId = $tenantReview['tenant_id'];
        $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
        $stmt->execute([$tenantReviewId]);
        $yourReview = $stmt->fetch(PDO::FETCH_ASSOC); 
        }

    } catch (Exception $e) {
        http_response_code(400);
        echo '<script>alert("Bad Request. ' . $e->getMessage() . '");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit;
    }
} else {
    http_response_code(400);
    echo '<script>alert("Bad Request. Property ID not provided.");</script>';
    echo '<script>window.location.href = "index.php";</script>';
    exit;
}

// Check if property exists
if (!$property) {
    http_response_code(404);
    echo "Property not found.";
    exit;
}

// Function to construct the address string
function constructAddress($property) {
    $encryptionKey1 = $property['encryption_key'];
    $address = decryptData($property['property_address'], $encryptionKey1);
    $brgy = decryptData($property['property_brgy'], $encryptionKey1);
    $city = decryptData($property['property_city'], $encryptionKey1);
    $province = decryptData($property['property_province'], $encryptionKey1);
    $zipcode = urlencode($property['property_zipcode']);
    
    return $address . ', ' . $brgy . ', ' . $city . ', ' . $province . ' ' . $zipcode;
}

// Construct the address string
$address = constructAddress($property);

// Encode the address component for use in the URL
$encodedAddress = urlencode($address);

// Make a request to Mapbox Geocoding API to get coordinates
$accessToken = 'pk.eyJ1IjoicHJvcGVydGVhc2UiLCJhIjoiY2xzaDF3bGcxMXE4ajJpcGMzajV6bG15MCJ9.NBAdRDSG_PNXxDIiuQW0bg';
$geocodingUrl = "https://api.mapbox.com/geocoding/v5/mapbox.places/$encodedAddress.json?access_token=$accessToken";

$response = file_get_contents($geocodingUrl);

// Check if request was successful
if ($response === FALSE) {
    echo "Failed to connect to the Mapbox Geocoding API.";
    exit;
}

$data = json_decode($response, true);

// Extract coordinates from the response
if (isset($data['features'][0]['geometry']['coordinates'])) {
    $coordinates = $data['features'][0]['geometry']['coordinates'];

    // Get property details
    $encryptionKey1 = $property['encryption_key'];
    $address = decryptData($property['property_address'], $encryptionKey1);
    $brgy = decryptData($property['property_brgy'], $encryptionKey1);
    $city = decryptData($property['property_city'], $encryptionKey1);
    $province = decryptData($property['property_province'], $encryptionKey1);
    $zipcode = $property['property_zipcode'];

    // Construct the complete address string
    $completeAddress = urlencode("$address, $brgy, $city, $province $zipcode");
    $completeAddressSentence = "$address, $brgy, $city, $province $zipcode";

    // Construct Mapbox static image URL with coordinates, centered and zoomed with a marker and property address label
    $latitude = $coordinates[1];
    $longitude = $coordinates[0];
    $mapboxUrl = "https://api.mapbox.com/styles/v1/propertease/clsh1ng2500k001po5djpetqj/static/pin-s+ff0000($longitude,$latitude)/$longitude,$latitude,18,0,0/770x400?access_token=$accessToken&title=Property Address&text=$completeAddress&yOffset=-40";
} else {
    echo "Coordinates not found for the given address.";
    exit;
}
?>