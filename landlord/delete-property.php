<?php
session_start();
require_once('../connect.php');
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";

if (isset($_GET['id'])) {
    $propertyId = $_GET['id'];

    $updateStmt = $pdo->prepare("UPDATE property_tbl SET property_status = 'Removing' WHERE property_id = ?");
    $updateStmt->execute([$propertyId]);

    if ($updateStmt->rowCount() > 0) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "success",
                        title: "Success",
                        text: "Property removal request submitted. Please wait for admin approval.",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "property-list.php";
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
                        text: "Error submitting removal request. Please try again.",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "property-list.php";
                    });
                });
            </script>';
        exit;
    }
} else {
    http_response_code(400);
    echo '<script>alert("Bad Request. Property ID not provided.");</script>';
    echo '<script>window.location.href = "property-list.php";</script>';
    exit;
}
?>
