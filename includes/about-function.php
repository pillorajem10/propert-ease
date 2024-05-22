<?php
// Check if the user is not logged in
if (isset($_SESSION['tenant_id'])) {
    // Bind tenant ID parameter to prevent SQL injection
    $tenantId = $_SESSION['tenant_id'];
    $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
    $stmt->execute([$tenantId]);
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC); 

    // Check if tenant is banned
    if ($tenant && $tenant['tenant_role'] === 'banned') {
        unset($_SESSION['tenant_id']);
        session_destroy();
        header("Location: index.php");
        exit;
    }

}
?>