<?php
require_once('../connect.php');
require_once('includes/security.php');

$tenantId=$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
$stmt->execute([$tenantId]);
$tenant = $stmt->fetch(PDO::FETCH_ASSOC);

require_once('includes/tenant-decryption.php');

$propertyId = $tenant['property_id'];
$stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
$stmt->execute([$propertyId]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

require_once('includes/property-decryption.php');

$uniqueId = $tenant['unique_id'];
$stmt = $pdo->prepare("SELECT * FROM transaction_records WHERE unique_id = ?");
$stmt->execute([$uniqueId]);
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

$pdfPath = $transaction['transaction_gcash'];
?>

<!-- Tenant Details -->
<h6 class="mt-3">Tenant Details:</h6>
<p><strong>Name:</strong>&nbsp;<?php echo htmlspecialchars($tenantFname) . ' ' . htmlspecialchars($tenantLname); ?></p>
<p><strong>Contact:</strong>&nbsp;<?php echo htmlspecialchars($tenantContact); ?></p>
<p><strong>Email:</strong>&nbsp;<?php echo htmlspecialchars($tenantEmail); ?></p>

<!-- Payment Details -->
<h6 class="mt-4">Payment Details:</h6>
<p><strong>Property Name:</strong>&nbsp;<span id="modalPropertyName"><?php echo htmlspecialchars($propertyName); ?></span></p>
<p><strong>Location of Property:</strong>&nbsp;<span id="modalPropertyLocation"><?php echo htmlspecialchars($propertyBrgy . ', ' . $propertyCity . ', ' . $propertyProvince . ', ' . $propertyZipcode); ?></span></p>
<p><strong>Pay Rate:</strong>&nbsp;<span id="modalPayRate"><?php echo htmlspecialchars($propertyPrice); ?></span></p>
<p><strong>Due Date:</strong>&nbsp;<span id="modalDueDate">Every <?php echo htmlspecialchars($propertyDue . ' days'); ?></span></p>

<!-- PDF Payment Receipt -->
<h6 class="mt-4">Payment Receipt:</h6>
<?php if(!empty($pdfPath)): ?>
    <iframe src="../img/<?php echo $pdfPath; ?>" width="100%" height="auto" style="max-height: 600px;" frameborder="0"></iframe>
<?php else: ?>
    <p>No payment receipt uploaded yet.</p>
<?php endif; ?>

<div class="d-flex justify-content-center align-items-center">
    <?php if ($tenant['tenant_status'] === 'pending'): ?>
        <a id="receivePaymentBtn" class="btn btn-primary text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary" onclick="confirmPayment(<?= $tenantId ?>)">Receive Payment</a>
        <button class="btn btn-secondary text-white font-weight-bold ml-3 py-2 px-4 rounded-pill shadow-sm bg-secondary" onclick="cancelPayment(<?= $tenantId ?>)">Cancel</button>
    <?php else: ?>
        <button class="btn btn-primary text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary" disabled>Payment Received</button>
    <?php endif; ?>
</div>

<script src="js/receive-payment.js"></script>