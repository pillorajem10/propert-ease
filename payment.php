<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenantName = $_POST['fullname'];
    $location  = $_POST['propertyLocation'];
    $payRate = $_POST['paymentRate'];
    $dueDate = $_POST['due_date'];
    $subTotal = $_POST['subtotal'];
    $vat = $_POST['vat'];
    $method = $_POST['method'];
    $propertyName = $_POST['propertyName'];
    $landlordId = $_POST['landlordId'];
    
    $_SESSION['payment_data']=[
        'propertyName' => $propertyName,
        'subtotal' => $subTotal,
        'fullname' => $tenantName,
        'method' => $method,
        'landlordId' => $landlordId,
        'location' => $location,
        'payrate' => $payRate,
        'dueDate' => $dueDate,
        'vat' => $vat
    ];
    $response = array('success' => 'gcash.php');
}else{
    http_response_code(405);
    $response = array('error' => 'Method Not Allowed.');
}
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>