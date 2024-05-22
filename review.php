<?php
session_start();
require_once('connect.php');

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $reviewDescription = isset($_POST['review_description']) ? $_POST['review_description'] : '';
    $tenantId = isset($_POST['tenant_id']) ? $_POST['tenant_id'] : '';
    $propertyId = isset($_POST['property_id']) ? $_POST['property_id'] : '';

    // Insert the new review into the database
    try {
        // Prepare and execute the SQL query
        $stmt = $pdo->prepare("INSERT INTO review_tbl (review_description, tenant_id, property_id) VALUES (?, ?, ?)");
        $stmt->execute([$reviewDescription, $tenantId, $propertyId]);

        // Respond with success message
        $response = array('success' => 'Review added successfully!');
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } catch (PDOException $e) {
        // Respond with error message
        $response = array('error' => 'Error adding review. Please try again.');
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
} else {
    // If not a POST request, respond with error
    $response = array('error' => 'Invalid request method.');
    http_response_code(405); // Method Not Allowed
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>