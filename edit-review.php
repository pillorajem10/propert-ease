<?php
// Include necessary files and initialize session (if needed)
require_once('connect.php');
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the review_id and updated_description from the form data
    $reviewId = $_GET['id'];
    $updatedDescription = isset($_POST['updated_description']) ? $_POST['updated_description'] : null;

    // Validate and sanitize inputs if necessary

    // Perform database update operation
    $stmt = $pdo->prepare("UPDATE review_tbl SET review_description = ? WHERE review_id = ?");
    $result = $stmt->execute([$updatedDescription, $reviewId]);

    // Check if the update was successful
    if ($result) {
        // Return a success message (optional)
        http_response_code(200); // OK
        echo json_encode(array('success' => 'Review updated successfully!'));
    } else {
        // Return an error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array('error' => 'Error updating review.'));
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Invalid request method.'));
}
?>