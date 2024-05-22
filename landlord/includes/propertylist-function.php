<?php
if (!isset($_SESSION['landlord_id'])) {
    // Redirect to the login page
    header("Location: login.html");
    exit;
}

if (isset($_SESSION['landlord_id'])) {
    $landlordId = $_SESSION['landlord_id'];

    $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE landlord_id = ?");
    $stmt->execute([$landlordId]);
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}

$landlordStmt=$pdo->prepare("SELECT * FROM landlord_tbl where landlord_id = ?");
$landlordStmt->execute([$landlordId]);
$landlord= $landlordStmt->fetch(PDO::FETCH_ASSOC);
?>