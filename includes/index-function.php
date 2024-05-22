<?php
// Function to fetch tenant details by ID
function getTenantById($pdo, $tenantId) {
    $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
    $stmt->execute([$tenantId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Check if the user is logged in and fetch tenant details securely
if (isset($_SESSION['tenant_id'])) {
    $tenantId = $_SESSION['tenant_id'];
    $tenant = getTenantById($pdo, $tenantId);

    // Check if tenant exists and is not banned
    if ($tenant && $tenant['tenant_role'] !== 'banned') {
        // Check if tenant has an associated property ID

    } else {
        // Tenant is banned or not found, destroy session
        unset($_SESSION['tenant_id']);
        header("Location: index.php");
        exit;
    }
}

// Retrieve selected city and rental type from URL parameters
$city = isset($_GET['city']) ? $_GET['city'] : '';
$rentalType = isset($_GET['rental_type']) ? $_GET['rental_type'] : '';

// Build SQL query to fetch properties based on city and rental type
$sql = "SELECT * FROM property_tbl WHERE property_status = 'Active'";
$params = [];

if (!empty($city)) {
    // Encrypt the selected city for comparison with encrypted values in the database
    $encryptedCity = encryptData($city, $encryptionKey); // Ensure to use appropriate encryption method
    $sql .= " AND property_city = ?";
    $params[] = $encryptedCity;
}
if (!empty($rentalType)) {
    $sql .= " AND property_type = ?";
    $params[] = $rentalType;
}

// Prepare and execute SQL query with prepared statements
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to get the number of occupied units for a property
function getOccupiedCount($pdo, $propertyId) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS occupied_count FROM property_tbl WHERE property_id = ? AND property_status = 'Active'");
    $stmt->execute([$propertyId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['occupied_count'];
}
?>