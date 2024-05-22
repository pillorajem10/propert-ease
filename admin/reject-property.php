<?php
session_start();
require_once('../connect.php');
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";

if (isset($_GET['id'])) {
    $propertyId = $_GET['id'];

    $rejectStmt = $pdo->prepare("UPDATE property_tbl SET property_status = 'Rejected' WHERE property_id = ?");
    $rejectStmt->execute([$propertyId]);

    if ($rejectStmt->rowCount() > 0) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "success",
                        title: "Success",
                        text: "Property rejected successfully!",
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
                        icon: "error",
                        title: "Error",
                        text: "Error rejecting property. Please try again.",
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
