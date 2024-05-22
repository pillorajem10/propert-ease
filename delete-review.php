<?php
require_once('connect.php');

// Validate request method
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Validate and sanitize input
    $review_id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if (!$review_id) {
        // Invalid request parameters
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Invalid review ID.'));
        exit();
    }

    try {
        // Use prepared statement to delete review
        $stmt = $pdo->prepare("DELETE FROM review_tbl WHERE review_id = ?");
        $stmt->execute([$review_id]); // Pass review_id as an array to execute()

        // Check if deletion was successful
        if ($stmt->rowCount() > 0) {
            // Review deleted successfully
            http_response_code(200); // OK
            echo json_encode(array('success' => 'Review deleted successfully!'));
        } else {
            // No matching review found
            http_response_code(404); // Not Found
            echo json_encode(array('error' => 'Review not found.'));
        }
    } catch (PDOException $e) {
        // Database error
        http_response_code(500); // Internal Server Error
        echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Invalid request method.'));
}
?>