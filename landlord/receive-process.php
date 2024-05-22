<?php
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $tenantId=$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
    $stmt->execute([$tenantId]);
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("UPDATE tenant_tbl SET tenant_status = 'paid' where tenant_id = ?");
    $stmt->execute([$tenantId]);

    $landlordId = $tenant['landlord_id'];
    $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
    $stmt->execute([$landlordId]);
    $landlord = $stmt->fetch(PDO::FETCH_ASSOC);

    $landlordBalance = $landlord['landlord_balance'];

    $uniqueId = $tenant['unique_id'];
    $stmt = $pdo->prepare("SELECT * FROM transaction_records WHERE unique_id = ?");
    $stmt->execute([$uniqueId]);
    $transactions = $stmt->fetch(PDO::FETCH_ASSOC);

    $transactionTotal=$transactions['sub_total'];

    $newBalance = $landlordBalance + $transactionTotal;

    $stmt = $pdo->prepare("UPDATE landlord_tbl SET landlord_balance = ? WHERE landlord_id = ? ");
    $stmt->execute([$newBalance, $landlordId]);

    $stmt = $pdo->prepare("UPDATE transaction_records SET transaction_status = 'completed' WHERE unique_id = ? ");
    $stmt->execute([$uniqueId]);

    $response = array('success' => 'Transaction Completed successfully'); 
}else{
    http_response_code(405);
    $response = array('error' => 'Method Not Allowed.');
}
header('Content-Type: application/json');
echo json_encode($response);
exit;

?>