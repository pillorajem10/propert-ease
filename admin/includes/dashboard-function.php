<?php
session_start();

// Redirect to login page if admin session is not set
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

// Validate user agent to prevent session hijacking
if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    // Destroy session data and redirect to login page
    session_unset();
    session_destroy();
    header("Location: login.html");
    exit();
}

// Update last activity time and user agent
$_SESSION['last_activity'] = time();
$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

// Store last activity time for javascript usage
echo '<input type="hidden" id="lastActivityTime" value="' . $_SESSION['last_activity'] . '" />';

$adminId = $_SESSION['admin'];
$stmt = $pdo->prepare("SELECT * FROM admin_tbl WHERE admin_id = ?");
$stmt->execute([$adminId]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Prepare the statement to count verified properties
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM property_tbl WHERE property_verifiedAt IS NOT NULL");
$stmt->execute();
$verifiedPropertiesCount = $stmt->fetchColumn();

// Prepare the statement to count verified tenants
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM tenant_tbl WHERE tenant_verifiedAt IS NOT NULL");
$stmt->execute();
$verifiedTenantsCount = $stmt->fetchColumn();

// Prepare the statement to count verified landlords
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM landlord_tbl WHERE landlord_verifiedAt IS NOT NULL");
$stmt->execute();
$verifiedLandlordsCount = $stmt->fetchColumn();

// Prepare the statement to count banned tenants
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM tenant_tbl WHERE tenant_role = 'banned' AND tenant_bannedAt IS NULL");
$stmt->execute();
$bannedTenantsCount = $stmt->fetchColumn();

// Prepare the statement to count banned landlords
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM landlord_tbl WHERE landlord_role = 'banned' AND landlord_bannedAt IS NULL");
$stmt->execute();
$bannedLandlordsCount = $stmt->fetchColumn();

// Prepare the statement to count paid tenants
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM tenant_tbl WHERE tenant_status = 'paid' AND tenant_dueDate IS NOT NULL");
$stmt->execute();
$paidTenantsCount = $stmt->fetchColumn();

// Validate admin data before usage
if (!$admin) {
    // Admin not found or unauthorized to perform secure logout
    header("Location: logout.php");
    exit();
}
?>