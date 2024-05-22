<?php
require_once ('connect.php');
require_once 'includes/security.php';
session_start();

function generateEncryptionKey()
{
  return openssl_random_pseudo_bytes(32); // 256 bits
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a unique encryption key
$uniqueId = generateEncryptionKey();

$receipt=$_FILES['onhandReceipt']['name'];
$method = $_POST['method'];

$min = pow(10, 10); // Smallest 11-digit number
$max = pow(10, 11) - 1; // Largest 11-digit number
 
$transNum = random_int($min, $max);

$tenantId = $_SESSION['tenant_id'];

// Fetch the tenant's property ID
$stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
$stmt->execute([$tenantId]);
$tenant = $stmt->fetch();

$propertyId = $tenant['property_id'];
$tenantDue = $tenant['tenant_dueDate'];
$landlordId = $tenant['landlord_id'];

$stmt = $pdo->prepare('SELECT * FROM property_tbl WHERE property_id = ?');
$stmt->execute([$propertyId]);
$property = $stmt->fetch();

require_once 'includes/property-decryption.php';

$propertyDue= $property['property_due'];
$payRate = $propertyPrice;

// // // Insert transaction record
$stmt = $pdo->prepare('INSERT INTO transaction_records (tenant_id, landlord_id, method, price, property_id, unique_id, transaction_date, transaction_status, tenant_due, transaction_gcash, transaction_receipt) VALUES (?,?,?,?,?,?, CURRENT_TIMESTAMP, "pending", ?, ?, ?)');
$stmt->execute([$tenantId, $landlordId, $method, $payRate, $propertyId, $uniqueId, $tenantDue, $receipt, $transNum]);

// // Update tenant payment information
$stmt = $pdo->prepare('UPDATE tenant_tbl SET tenant_dueDate = DATE_ADD(?, INTERVAL ? DAY), unique_id = ?, tenant_paymentmethod = ?, tenant_status = "pending" WHERE tenant_id = ?');
$stmt->execute([$tenantDue, $propertyDue, $uniqueId, $method, $tenantId]);


$profilePictureDirectory = 'img/';
move_uploaded_file($_FILES['receipt']['tmp_name'],  $profilePictureDirectory .  $receipt);

// $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
// $stmt->execute([$landlordId]);
// $landlord = $stmt->fetch();

// // Update landlord's balance
// $newBalance = (float)$landlord['landlord_balance'] + (float)$subTotal;
// $stmt = $pdo->prepare('UPDATE landlord_tbl SET landlord_balance = ? WHERE landlord_id = ?');
// $stmt->execute([$newBalance, $landlordId]);

    $response = array('success' => 'Transaction Processing wait for Landlord Confimation'); 
}else{
    http_response_code(405);
    $response = array('error' => 'Method Not Allowed.');
}
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>