<?php
require 'vendor/autoload.php';

$options = array(
    'cluster' => 'YOUR_PUSHER_CLUSTER',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    'YOUR_PUSHER_KEY',
    'YOUR_PUSHER_SECRET',
    'YOUR_PUSHER_APP_ID',
    $options
);

$message = $_POST['message'];
$data['message'] = $message;
$data['sender'] = 'Tenant';

$pusher->trigger('chat-channel', 'new-message', $data);

// Simple bot response
if (stripos($message, 'book viewing') !== false) {
    $botResponse = "Sure, I can help you with booking a property viewing. Can you please provide me with the date and time you're interested in?";
    $data['message'] = $botResponse;
    $data['sender'] = 'Chatbot';
    $pusher->trigger('chat-channel', 'new-message', $data);
}

echo json_encode(['status' => 'success']);
?>