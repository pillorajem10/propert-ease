<?php
require_once('../connect.php');
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $tenantId = $_GET['id'];

    // Update tenant_tbl with verification details
    $stmt = $pdo->prepare("UPDATE tenant_tbl SET tenant_verifStatus = 'verified', tenant_verifiedAt = CURRENT_TIMESTAMP WHERE tenant_id = ?");
    $stmt->execute([$tenantId]);

    if ($stmt->rowCount() > 0) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        target: "body",
                        icon: "success",
                        title: "Success",
                        text: "Tenant verified successfully!",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "dashboard.php";
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
                        text: "Error verifying tenant",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "dashboard.php";
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
                    text: "Error verifying tenant",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "dashboard.php";
                });
            });
          </script>';
}
?>
