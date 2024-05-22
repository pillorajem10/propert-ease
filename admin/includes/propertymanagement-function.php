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

// Validate admin data before usage
if (!$admin) {
    // Admin not found or unauthorized to perform secure logout
    header("Location: logout.php");
    exit();
}
?>