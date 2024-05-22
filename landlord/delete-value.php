<?php
session_start();
require_once('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' ) {
    if (isset($_GET['id'])) {
        $propertyId = $_GET['id'];

        $stmt = $pdo->prepare("DELETE FROM property_tbl WHERE property_id = ?");
        $stmt->execute([$propertyId]);

        if ($stmt->rowCount() > 0) {
            $response = array('success' => 'Property deleted successfully!.');
        } else {
            $response = array('error' => 'Error deleting property. Please try again.');
        }
    } else {
        $response = array('error' => 'Bad Request. Property ID not provided.');
    }

} else {
    $response = array('error' => 'Method Not Allowed.');
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>