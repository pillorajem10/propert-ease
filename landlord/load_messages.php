<?php
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tenant = $_GET['tenant'];

// Get tenant ID
$stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
$stmt->bind_param("s", $tenant);
$stmt->execute();
$result = $stmt->get_result();
$tenant_id = $result->fetch_assoc()['id'];

// Assuming landlord ID is known (e.g., 1)
$landlord_id = 1;

// Fetch messages between landlord and tenant
$stmt = $conn->prepare("SELECT sender_id, message, timestamp FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp ASC");
$stmt->bind_param("iiii", $landlord_id, $tenant_id, $tenant_id, $landlord_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
?>
<div class="chatbox">
<?php foreach ($messages as $msg): ?>
    <div class="chat-message <?php echo $msg['sender_id'] == $landlord_id ? 'me' : ''; ?>">
        <div class="message-text"><?php echo htmlspecialchars($msg['message']); ?></div>
        <div class="message-time"><?php echo date('h:i A', strtotime($msg['timestamp'])); ?></div>
    </div>
<?php endforeach; ?>
</div>