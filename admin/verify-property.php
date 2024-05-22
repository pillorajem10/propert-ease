<?php
require_once('../connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $propertyId = $_GET['id'];
    
        $stmt = $pdo->prepare("UPDATE property_tbl SET property_status = 'Active', property_verifiedAt = CURRENT_TIMESTAMP WHERE property_id = ?");
        $stmt->execute([$propertyId]);
    
        if ($stmt->rowCount() > 0) {
            $response = array('success' => 'Property verified successfully!');
        } else {
            $response = array('error' => 'Error verifying property. Please try again.');
        }
    } else {
        $response = array('error' => 'Invalid property ID.');
    }    
} else {
    http_response_code(405);
    $response = array('error' => 'Method Not Allowed.');
}
header('Content-Type: application/json');
echo json_encode($response);
exit;

?>