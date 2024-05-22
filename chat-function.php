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
?>