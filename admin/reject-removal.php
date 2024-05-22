<?php
require_once('../connect.php');
session_start();
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";

if (isset($_GET['id'])) {
    $propertyId = $_GET['id'];

    // Delete related records in landlordreview_tbl first
    $deleteRelatedStmt = $pdo->prepare("DELETE FROM landlordreview_tbl WHERE property_id = ?");
    $deleteRelatedStmt->execute([$propertyId]);

    // Then delete the property data
    $deleteStmt = $pdo->prepare("DELETE FROM property_tbl WHERE property_id = ?");
    $deleteStmt->execute([$propertyId]);

    if ($deleteStmt->rowCount() > 0) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        title: "Success!",
                        text: "Property deleted successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "dashboard.php";
                    });
                });
              </script>';
        exit;
    } else {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        title: "Error!",
                        text: "Error deleting property. Please try again.",
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "dashboard.php";
                    });
                });
              </script>';
        exit;
    }
} else {
    http_response_code(400);
    echo '<script>alert("Bad Request. Property ID not provided.");</script>';
    echo '<script>window.location.href = "dashboard.php";</script>';
    exit;
}
?>
