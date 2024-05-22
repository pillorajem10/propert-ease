<?php
session_start();

// Clear specific session variables (if needed)
unset($_SESSION['admin']);
unset($_SESSION['username']);

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Regenerate CSRF token to prevent token reuse
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Clear the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to login page after logout
header("Location: login.html");
exit();
?>