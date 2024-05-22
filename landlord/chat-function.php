<?php
require 'vendor/autoload.php';

$options = array(
    'cluster' => 'ap1',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    '501b026dfa7fa71d224d',
    '802a2ed1633f5fb2edb6',
    '1806365',
    $options
);

$message = $_POST['message'];

$data['message'] = $message;
$data['sender'] = 'Tenant'; // or 'Landlord' based on session or other logic

$pusher->trigger('chat-channel', 'new-message', $data);

echo json_encode(['status' => 'success']);

$action = $_POST['action'];
$tenant = $_POST['tenant'];
$message = $_POST['message'];

if ($action == 'sendmessage') {
    // Get tenant ID
    $stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $tenant);
    $stmt->execute();
    $result = $stmt->get_result();
    $tenant_id = $result->fetch_assoc()['id'];
    
    // Assuming landlord ID is known (e.g., 1)
    $landlord_id = 1;

    // Insert message into database
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message, timestamp) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $landlord_id, $tenant_id, $message);
    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>