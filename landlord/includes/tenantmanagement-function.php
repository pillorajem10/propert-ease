<?php
if (!isset($_SESSION['landlord_id'])) {

    header("Location: login.html");
    exit;
}
$landlordId=$_SESSION['landlord_id'];
$landlordStmt=$pdo->prepare("SELECT * FROM landlord_tbl where landlord_id = ?");
$landlordStmt->execute([$landlordId]);
$landlord= $landlordStmt->fetch(PDO::FETCH_ASSOC);

$property_id = $_GET['id']; 
$stmt=$pdo->prepare("SELECT * FROM property_tbl where property_id = ?");
$stmt->execute([$property_id]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE property_id = ? AND tenant_status = ?");
$stmt -> execute([$property_id,'paid']);
$paidTenants = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE property_id = ? AND tenant_status = ?");
$stmt -> execute([$property_id,'paid']);
$totalPaidTenants = $stmt->rowCount();


$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 5;

// Calculate start for the SQL LIMIT clause
$start = ($page - 1) * $recordsPerPage;


$stmt = $pdo->prepare("SELECT COUNT(*) FROM tenant_tbl WHERE property_id = ? AND tenant_status = ?");
$stmt -> execute([$property_id,'paid']);

$totalTransactions = $stmt->fetchColumn();

// Calculate total pages
$totalPages = ceil($totalTransactions / $recordsPerPage);
?>

