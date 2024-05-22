<?php
session_start();
require_once('../connect.php');
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";

if (isset($_GET['id'])) {
    $propertyId = $_GET['id'];

    // Delete property directly
    $stmt = $pdo->prepare("DELETE FROM property_tbl WHERE property_id = ?");
    $stmt->execute([$propertyId]);

    if ($stmt->rowCount() > 0) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "success",
                        title: "Success",
                        text: "Property deleted successfully!",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "property-list.php";
                    });
                });
            </script>';
    } else {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "error",
                        title: "Error",
                        text: "Error deleting property. Please try again.",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "property-list.php";
                    });
                });
            </script>';
    }
    exit;
} else {
    http_response_code(400);
    echo '<script>
            alert("Bad Request. Property ID not provided.");
            window.location.href = "property-list.php";
          </script>';
    exit;
}
?>
