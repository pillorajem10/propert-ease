<?php
require_once('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['landlordId'])) {
    $landlordId = $_GET['landlordId'];
    $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
    $stmt->execute([$landlordId]);
    $landlord = $stmt->fetch(PDO::FETCH_ASSOC);
    $role = "landlord";

    if ($landlord) {
        $stmt = $pdo->prepare("UPDATE landlord_tbl SET landlord_role =? WHERE landlord_id = ?");

        $stmt->execute([$role, $landlordId]);
        $response = array('success' => 'Landlord has been unbanned successfully.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        $response = array('error' => 'Landlord not found.');
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