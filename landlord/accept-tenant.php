<?php
require_once('../connect.php');
require_once('includes/security.php');

if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $pendingId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM pending_tbl WHERE pending_id = ?");
    $stmt->execute([$pendingId]);
    $pending = $stmt->fetch(PDO::FETCH_ASSOC);

    $tenantId = $pending['tenant_id'];
    $propertyId = $pending['property_id'];
    $landlordId = $pending['landlord_id'];

    $checkStmt = $pdo->prepare("SELECT property_id FROM tenant_tbl WHERE tenant_id = ? AND property_id IS NOT NULL");
    $checkStmt->execute([$tenantId]);

    if ($checkStmt->fetchColumn() !== false) {
        $response = array('warning' => 'Tenant already assigned to a property.');
    } else {
        $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
        $stmt->execute([$propertyId]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);

        require('includes/property-decryption.php');

        $currTenant = $property['property_tenants'];
        $tenantCount = $currTenant + 1;
        $dueDate= $property['property_due'];

        $updateStmt = $pdo->prepare("UPDATE tenant_tbl SET property_id = ?, landlord_id = ?, tenant_status='not paid', tenant_acceptdate= CURRENT_TIMESTAMP, tenant_dueDate =   DATE_ADD(CURRENT_TIMESTAMP, INTERVAL ? DAY)   WHERE tenant_id = ?");
        $updateStmt->execute([$propertyId, $landlordId, $dueDate, $tenantId]);
        if ($tenantCount === (int)$propertyOccupancy) {
            $updateStmt1 = $pdo->prepare("UPDATE property_tbl SET property_tenants = ?, property_status = 'Full' WHERE property_id = ?");
            $updateStmt1->execute([$tenantCount, $propertyId]);
        } else {
            $updateStmt1 = $pdo->prepare("UPDATE property_tbl SET property_tenants = ? WHERE property_id = ?");
            $updateStmt1->execute([$tenantCount, $propertyId]);
        }
        
        
        $deleteStmt = $pdo->prepare("DELETE FROM pending_tbl WHERE pending_id = ?");
        $deleteStmt->execute([$pendingId]);

        if ($updateStmt->rowCount() > 0) {

            $response = array('success' => 'Tenant accepted successfully!');

        } else {

            $response = array('error' => 'Error accepting tenant. Please try again.');

        }
    }
}else{
    http_response_code(405);
    $response = array('error' => 'Invalid Request.');
}
header('Content-Type: application/json');
echo json_encode($response);
exit;      
?>