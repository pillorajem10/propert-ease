<?php
require_once('connect.php');
require_once('includes/payment-function.php');

// Function to decrypt data using AES-256
function decryptedData($data, $key)
{
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encryptedData = substr($data, 16);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}

// Initialize variables
$fname = '';
$lname = '';
$landlordfname = '';
$landlordlname = '';
$propertyType = '';
$location = '';
$payRate = '';
$payRateFrequency = '';
$newDueDate = '';

// Check if tenant session is set
if (!isset($_SESSION['tenant_id'])) {
    header("Location: index.php");
    exit;
}

try {
    // Get tenant data from database
    $tenantId = $_SESSION['tenant_id'];
    $stmt2 = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
    $stmt2->execute([$tenantId]);
    $tenant = $stmt2->fetch(PDO::FETCH_ASSOC);

    // Check if tenant data exists
    if ($tenant) {
        // Decrypt tenant name
        $fname = isset($tenant['tenant_fname']) ? decryptedData($tenant['tenant_fname'], $tenant['encryption_key']) : '';
        $lname = isset($tenant['tenant_lname']) ? decryptedData($tenant['tenant_lname'], $tenant['encryption_key']) : '';

        // Get property data associated with the tenant
        $propertyId = $tenant['property_id'];
        $propertyStmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
        $propertyStmt->execute([$propertyId]);
        $property = $propertyStmt->fetch(PDO::FETCH_ASSOC);

        // Check if property data exists
        if ($property) {
            // Decrypt landlord name
            $landlordId = $property['landlord_id'];
            $landlordStmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
            $landlordStmt->execute([$landlordId]);
            $landlord = $landlordStmt->fetch(PDO::FETCH_ASSOC);

            // Check if landlord data exists
            if ($landlord) {
                $landlordfname = isset($landlord['landlord_fname']) ? decryptedData($landlord['landlord_fname'], $landlord['encryption_key']) : '';
                $landlordlname = isset($landlord['landlord_lname']) ? decryptedData($landlord['landlord_lname'], $landlord['encryption_key']) : '';
            }

            if ($property && is_array($property)) {
                // Populate property details
                $propertyType = isset($property['property_type']) ? $property['property_type'] : '';
                $location = isset($property['property_brgy'], $property['property_city'], $property['property_province']) ?
                            $property['property_brgy'] . ' ' . $property['property_city'] . ' ' . $property['property_province'] : '';
                $payRate = isset($property['property_price']) ? $property['property_price'] : '';
                $payRateFrequency = ($property['property_due'] === 30) ? 'month' : '2 weeks';
            
                // Calculate due date if necessary
                if ($tenant && is_array($tenant) && isset($tenant['tenant_acceptdate'], $property['property_due'])) {
                    $tenantDate = $tenant['tenant_dueDate'];
            
                    // Ensure $tenantDate is a valid date string
                    if (strtotime($tenantDate) !== false) {
                        $dueDate = new DateTime($tenantDate);
                        $newDueDate = $dueDate->format('F j, Y');
                    } else {
                        $newDueDate = 'Invalid date';
                    }
                }
            }                        
        }else{
            header("Location: index.php");
        }
    }
} catch (PDOException $e) {
    // Handle database connection or query errors
    echo "Database error: " . $e->getMessage();
    exit;
}
?>