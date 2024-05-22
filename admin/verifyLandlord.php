<?php
require_once('../connect.php');
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $landlordId = $_GET['id'];

    // Update landlord_tbl with verification details
    $stmt = $pdo->prepare("UPDATE landlord_tbl SET landlord_verifStatus = 'verified', landlord_verifiedAt = CURRENT_TIMESTAMP WHERE landlord_id = ?");
    $stmt->execute([$landlordId]);

    if ($stmt->rowCount() > 0) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "success",
                        title: "Success",
                        text: "Landlord verified successfully!",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "dashboard.php"; // Redirect to the dashboard
                    });
                });
              </script>';
    } else {
        // Handle errors or invalid verification
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "error",
                        title: "Error",
                        text: "Error verifying landlord",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "dashboard.php"; // Redirect to the dashboard
                    });
                });
              </script>';
    }
} else {
    // Handle invalid request
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    target: "body",
                    icon: "error",
                    title: "Error",
                    text: "Error verifying landlord",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "dashboard.php"; // Redirect to the dashboard
                });
            });
          </script>';
}
?>
