<?php
require_once('includes/security.php');

// Function to generate a random AES-256 encryption key
function generateEncryptionKey()
{
    return openssl_random_pseudo_bytes(32); // 256 bits
}

// Function to encrypt data using AES-256
function encryptData($data, $key)
{
    $iv = openssl_random_pseudo_bytes(16); // Initialization vector
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

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

// Validate admin data before usage
if (!$admin) {
    // Admin not found or unauthorized to perform secure logout
    header("Location: logout.php");
    exit();
}

// Determine current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of records per page
$recordsPerPage = 5;

// Calculate start for the SQL LIMIT clause
$start = ($page - 1) * $recordsPerPage;

// Fetch transaction records data from the database with pagination
$stmt = $pdo->prepare("SELECT * FROM transaction_records LIMIT :start, :limit");
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Loop through each transaction record to decrypt landlord and tenant names
foreach ($transactions as &$transaction) {
    // Decrypt landlord's first name and last name
    $landlordId = $transaction['landlord_id'];
    $stmt=$pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
    $stmt -> execute([$landlordId]);
    $landlord = $stmt->fetch();

    $encryptionKeyLandlord = $landlord['encryption_key'];
    $decryptedLandlordFname = decryptData($landlord['landlord_fname'], $encryptionKeyLandlord);
    $decryptedLandlordLname = decryptData($landlord['landlord_lname'], $encryptionKeyLandlord);


    // Decrypt tenant's first name and last name
    $tenantId = $transaction['tenant_id'];
    $stmt=$pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
    $stmt -> execute([$tenantId]);
    $tenant = $stmt->fetch();

    $encryptionKeyTenant = $tenant['encryption_key'];
    $decryptedTenantFname = decryptData($tenant['tenant_fname'], $encryptionKeyTenant);
    $decryptedTenantLname = decryptData($tenant['tenant_lname'], $encryptionKeyTenant);

}

// Get total number of transaction records
$stmt = $pdo->prepare("SELECT COUNT(*) FROM transaction_records");
$stmt->execute();
$totalTransactions = $stmt->fetchColumn();

// Calculate total pages
$totalPages = ceil($totalTransactions / $recordsPerPage);
?>