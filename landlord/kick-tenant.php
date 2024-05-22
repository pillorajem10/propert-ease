<?php
require_once('../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $tenantId = $_GET['id'];
        $tenantStmt = $pdo->prepare("SELECT * FROM tenant_tbl where tenant_id = ?");
        $tenantStmt->execute([$tenantId]);
        $tenant= $tenantStmt->fetch(PDO::FETCH_ASSOC);
        $propertyId=$tenant['property_id'];

        $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
        $stmt->execute([$propertyId]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);

        $currTenant = $property['property_tenants'];
        $tenantCount = $currTenant - 1;

        $updateStmt = $pdo->prepare("UPDATE tenant_tbl SET property_id = NULL, tenant_status=NULL, `exit` ='Kicked' , tenant_previous = ?, landlord_id=NULL WHERE tenant_id = ?");
        $updateStmt->execute([$propertyId, $tenantId]);

        $updateStmt = $pdo->prepare("UPDATE property_tbl SET property_tenants = ?, property_status = 'Active'  WHERE property_id = ?");
        $updateStmt->execute([$tenantCount, $propertyId]);


        if ($updateStmt->rowCount() > 0) {
            $response = array('success' => 'Tenant kicked successfully!');
        } else {
            $response = array('error' => 'Error kicking tenant. Please try again.');
        }
    } else {
        $response = array('error' => 'Invalid pending ID.');
    }
}else{
    http_response_code(405);
    $response = array('error' => 'Invalid Request.');
}

header('Content-Type: application/json');
echo json_encode($response);
exit;   
?>