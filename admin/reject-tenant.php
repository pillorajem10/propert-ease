<?php
require_once('../connect.php');
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['tenantId']) && isset($_POST['remarks']) && isset($_POST['reason'])) {
        // Retrieve form data
        $tenantId = $_POST['tenantId'];
        $remarks = $_POST['remarks'];
        $reason = $_POST['reason'];

        try {
            // Start a transaction
            $pdo->beginTransaction();

            // Delete the tenant record
            $deleteStmt = $pdo->prepare("DELETE FROM tenant_tbl WHERE tenant_id = ?");
            $deleteStmt->execute([$tenantId]);

            // Save the remarks and reason to a separate table
            $insertStmt = $pdo->prepare("INSERT INTO tenantremarks_tbl (tenant_id, remarks, reason) VALUES (?, ?, ?)");
            $insertStmt->execute([$tenantId, $remarks, $reason]);

            // Commit the transaction
            $pdo->commit();

            // Alert for successful rejection
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            target: "body",
                            icon: "success",
                            title: "Success",
                            text: "Tenant rejected successfully!",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "dashboard.php";
                        });
                    });
                </script>';
            exit;
        } catch (PDOException $e) {
            // Rollback the transaction in case of error
            $pdo->rollBack();

            // Handle the error
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            target: "body",
                            icon: "error",
                            title: "Error",
                            text: "Error rejecting tenant. Please try again.",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "dashboard.php";
                        });
                    });
                </script>';
        }
    } else {
        // Handle missing form fields
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "error",
                        title: "Error",
                        text: "Please fill in all fields.",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "dashboard.php";
                    });
                });
            </script>';
    }
} else {
    // Redirect to dashboard if form was not submitted
    header("Location: dashboard.php");
    exit;
}
?>
