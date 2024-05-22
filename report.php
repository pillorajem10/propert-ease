<?php
require_once('connect.php');
session_start();
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id']) && isset($_GET['landlordId'])) {
    $tenantId = $_SESSION['tenant_id'];
    $reportDescription = $_POST['yourmessage'];
    $propertyId = $_GET['id'];
    $landlordId = $_GET['landlordId'];

    $insertStmt = $pdo->prepare("INSERT INTO report_tbl (report_description, landlord_id, tenant_id) VALUES (?, ?, ?)");
    $insertStmt->execute([$reportDescription, $landlordId, $tenantId]);

    if ($insertStmt->rowCount() > 0) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "success",
                        title: "Report submitted successfully!",
                        showConfirmButton: false,
                        timer: 1500,
                        onClose: () => {
                            window.location.href = "property-details.php?id='.$propertyId.'";
                        }
                    });
                });
            </script>';
    } else {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "error",
                        title: "Error submitting report",
                        text: "Please try again.",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                });
              </script>';
    }

    exit();
} else {
    echo '<script>window.location.href = "property-details.php";</script>';
    exit();
}
?>
