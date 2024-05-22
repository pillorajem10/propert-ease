<?php

$tenantId=$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
$stmt->execute([$tenantId]);
$tenant = $stmt->fetch(PDO::FETCH_ASSOC);

if($tenant['tenant_status']!= "pending"){
    header("Location:dashboard.php");
}
require_once('includes/tenant-decryption.php');

$propertyId = $tenant['property_id'];
$stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
$stmt->execute([$propertyId]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

require_once('includes/property-decryption.php');

$uniqueId = $tenant['unique_id'];
$stmt = $pdo->prepare("SELECT * FROM transaction_records WHERE unique_id = ?");
$stmt->execute([$uniqueId]);
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

$transaction_total=$transaction['sub_total'];
?>