<?php
// Start session with secure settings
session_start([
    'use_strict_mode' => true,
    'use_cookies' => 1,
    'use_only_cookies' => 1,
    'cookie_httponly' => 1,
    'cookie_secure' => 1,
    'cookie_samesite' => 'Strict'
]);

// Include database connection
include '../connect.php';

// Check if tenant_id is set in session and is an integer
if(isset($_SESSION['tenant_id']) && is_numeric($_SESSION['tenant_id'])) {
    // Assign tenant_id from session
    $tenant_id = $_SESSION['tenant_id'];

    // Prepare the query with placeholders to prevent SQL injection
    $query = "SELECT * FROM notifications WHERE tenant_id = ? AND status = 'unread'";
    $stmt = $conn->prepare($query);
    if(!$stmt) {
        // Handle error
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("i", $tenant_id);
    if(!$stmt->execute()) {
        // Handle error
        die("Error executing statement: " . $stmt->error);
    }

    // Get result and fetch notifications
    $result = $stmt->get_result();
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    // Encode notifications to JSON and echo
    echo json_encode($notifications);
} else {
    // Handle invalid session or tenant_id
    echo json_encode(['error' => 'Invalid session or tenant_id']);
}
?>