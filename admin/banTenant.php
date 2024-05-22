<?php
require_once('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['tenantId'])) {
    $tenantId = $_GET['tenantId'];
    $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
    $stmt->execute([$tenantId]);
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC);
    $role = "banned";

    if ($tenant) {
        $stmt = $pdo->prepare("UPDATE tenant_tbl SET tenant_role = ? WHERE tenant_id = ?");
        $stmt->execute([$role, $tenantId]);
        $stmt1 = $pdo->prepare("UPDATE tenant_tbl SET property_id = NULL WHERE tenant_id = ?");
        $stmt1->execute([$tenantId]);
        $response = array('success' => 'Tenant has been banned successfully.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        $response = array('error' => 'Tenant not found.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
} else {
    http_response_code(405);
    $response = array('error' => 'Method Not Allowed.');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>