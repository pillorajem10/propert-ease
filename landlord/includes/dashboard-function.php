<?php
// Check if user is logged in as landlord
if (!isset($_SESSION['landlord_id'])) {
    header("Location: login.html");
    exit;
}

$landlordId = $_SESSION['landlord_id'];

// Fetch landlord details
$landlordStmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
$landlordStmt->execute([$landlordId]);
$landlord = $landlordStmt->fetch(PDO::FETCH_ASSOC);

// Specify the property_id you want to fetch
$property_id = 1; // Change this to the desired property_id

// Fetch property details
$stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
$stmt->execute([$property_id]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch paid tenants for this property using the correct column name
$Stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE landlord_id = ?");
$Stmt->execute([$landlordId]);

$pendingStmt = $pdo->prepare("SELECT * FROM pending_tbl WHERE landlord_id = ?");
$pendingStmt->execute([$landlordId]);

// Pagination variables
$perPage = 5;
$totalPaidTenants = $Stmt->rowCount();
$totalPages = ceil($totalPaidTenants / $perPage);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentPage - 1) * $perPage;

// Pagination variables
$pendingperPage = 5;
$totalPendingTenants = $pendingStmt->rowCount();
$totalpendingPages = ceil($totalPendingTenants / $pendingperPage);
$pendingcurrentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$pendingstart = ($pendingcurrentPage - 1) * $pendingperPage;

// Fetch paginated paid tenants using the correct column name
$paidTenantsStmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE property_id = ? AND tenant_status = 'paid' LIMIT $start, $perPage");
$paidTenantsStmt->execute([$property_id]);
$paidTenants = $paidTenantsStmt->fetchAll(PDO::FETCH_ASSOC);
?>