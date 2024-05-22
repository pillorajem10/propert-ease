<?php
session_start();
require_once 'connect.php';
require_once 'includes/security.php';

if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $tenantId = $_SESSION['tenant_id'];
    $updateStmt = $pdo->prepare("UPDATE tenant_tbl SET tenant_status='not paid' WHERE tenant_id = ?");
    $updateStmt->execute([$tenantId]);

    if ($updateStmt->rowCount() > 0) {
        $response = array('success' => ' Request for exit canceled.');
    } else {
        $response = array('error' => 'Error canceling exit request, Please try again.');
    }
}else{
    http_response_code(405);
    $response = array('error' => 'Invalid Request.');
}

header('Content-Type: application/json');
echo json_encode($response);
exit;   
?>