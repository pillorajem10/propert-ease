<?php
require_once('../connect.php');
require_once('includes/security.php');
if(isset($_GET["id"]))  :
 
    $pendingId = $_GET['id'];
    $stmt2 = $pdo->prepare("SELECT * FROM pending_tbl WHERE pending_id = ?");
    $stmt2->execute([$pendingId]);
    $pending = $stmt2->fetch(PDO::FETCH_ASSOC); 
    
    // Check if the pending record exists


    $tenantId = $pending['tenant_id'];
    $stmt2 = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
    $stmt2->execute([$tenantId]);
    $tenant = $stmt2->fetch(PDO::FETCH_ASSOC); 
    require_once('includes/tenant-decryption.php');
    // Check if the tenant record exists
    if(!$tenant) {
        echo "Tenant record not found.";
        exit;
    }

    $propertyId = $pending['property_id'];
    $stmt2 = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
    $stmt2->execute([$propertyId]);
    $property = $stmt2->fetch(PDO::FETCH_ASSOC); 
    require_once('includes/property-decryption.php');?>

    <h6 class="mt-3">Tenant Details:</h6>   
    <p><strong>Name:</strong>&nbsp;<?php echo htmlspecialchars($tenantFname) . ' ' . htmlspecialchars($tenantLname); ?></p>
    <p><strong>Email:</strong>&nbsp;<?php echo htmlspecialchars($tenant['tenant_email']); ?></p>
    <p><strong>Booked Property:</strong>&nbsp;<?php echo empty($bookedPropertyName) ? 'None' : $bookedPropertyName; ?></p>
    <p><strong>Message:</strong>&nbsp;<?php echo htmlspecialchars($pending['pending_message']); ?></p>
    <p><strong>Booking Date:</strong>&nbsp;<?php echo htmlspecialchars($pending['pending_bookedDate']); ?></p>
    </p>
    <p><strong>Last Cause of Exit:</strong>&nbsp;
    <?php if (empty($tenant['exit'])) :?>
        N/A
    <?php else: 
        echo htmlspecialchars($tenant['exit']);
    endif;?>
    </p>

    <!-- // Payment Details -->
    <h6 class="mt-5">Payment Details:</h6>
    <p><strong>Location of Property:</strong>&nbsp;<span id="modalPropertyLocation">
    <?php echo htmlspecialchars($propertyBrgy . ', ' . $propertyCity . ', ' . $propertyProvince . ', ' . $propertyZipcode);?>
    </span></p>
    <p><strong>Pay Rate:</strong>&nbsp;<span id="modalPayRate">
    <?php echo htmlspecialchars($propertyPrice);?>
    </span></p>
    <p><strong>Due Date:</strong>&nbsp;<span id="modalDueDate">Every 
    <?php echo htmlspecialchars($propertyDue . ' days');?>
    </span></p>
<?php endif;?>