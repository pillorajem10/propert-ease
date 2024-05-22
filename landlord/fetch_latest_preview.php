<?php
$tenant = $_GET['tenant'];

// Get tenant ID
$stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
$stmt->bind_param("s", $tenant);
$stmt->execute();
$result = $stmt->get_result();
$tenant_id = $result->fetch_assoc()['id'];

// Fetch latest message for the tenant
$stmt = $conn->prepare("SELECT message FROM messages WHERE receiver_id = ? ORDER BY timestamp DESC LIMIT 1");
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result();
$latest_message = $result->fetch_assoc()['message'];

echo $latest_message;
?>