<?php
// Fetch latest message previews
$sql = "SELECT u.id AS tenant_id, u.name AS tenant_name, m.message AS latest_message
        FROM users u
        LEFT JOIN messages m ON u.id = m.receiver_id
        WHERE u.role = 'tenant'
        ORDER BY m.timestamp DESC";

$result = $conn->query($sql);

$previews = [];
while ($row = $result->fetch_assoc()) {
    $previews[$row['tenant_name']] = $row['latest_message'];
}

echo json_encode($previews);
?>