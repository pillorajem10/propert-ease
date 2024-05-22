<?php
require_once('../connect.php');
require_once('includes/security.php');

$tenantId=$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
$stmt->execute([$tenantId]);
$tenant = $stmt->fetch(PDO::FETCH_ASSOC);

require_once('includes/tenant-decryption.php');

$reviewStmt = $pdo->prepare("SELECT * FROM landlordreview_tbl WHERE tenant_id=?");
$reviewStmt->execute([$tenantId]);
$reviewRow = $reviewStmt->fetch(PDO::FETCH_ASSOC);

?>

<p><strong>Name:</strong>&nbsp;<?php echo htmlspecialchars($tenantFname) . ' ' . htmlspecialchars($tenantLname); ?></p>

<?php
echo $reviewRow ? $reviewRow['review_description'] : 'No review yet';
?>