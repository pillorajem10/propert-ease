<?php
require_once('../connect.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pendingId = $_GET['id'];

    // Delete the pending record


    // Check if all required fields are set
    if (isset($_POST['pendingId']) && isset($_POST['remarks']) && isset($_POST['reason'])) {
        // Retrieve form data
        $pendingId = $_POST['pendingId'];
        $remarks = $_POST['remarks'];
        $reason = $_POST['reason'];

        try {
            // Start a transaction
            $pdo->beginTransaction();



            // Save the remarks and reason to a separate table
            $insertStmt = $pdo->prepare("INSERT INTO remarks_tbl (pending_id, remarks, reason) VALUES (?, ?, ?)");
            $insertStmt->execute([$pendingId, $remarks, $reason]);

            $deleteStmt = $pdo->prepare("DELETE FROM pending_tbl WHERE pending_id = ?");
            $deleteStmt->execute([$pendingId]);
        
            $response = array('success' => 'Tenant rejected successfully.');

            // Commit the transaction
            $pdo->commit();

        } catch (PDOException $e) {
            // Rollback the transaction in case of error
            $pdo->rollBack();

            $response = array('error' => 'Error rejecting tenant. Please try again.');
        }
    } else {
        $response = array('warning' => 'Please fill in all fields..');
    }
} else {
    http_response_code(405);
    $response = array('error' => 'Invalid Request.');
}
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>