<?php
require_once('../connect.php');
require_once('includes/security.php');
$propertyId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
$stmt->execute([$propertyId]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);


if ($property) {
    require_once('includes/property-decryption.php');
    ?>
    <iframe src="<?=$pathDoc?>" height="400" width="800"></iframe>
    <?php

} else {
    echo 'Property document not found';
}
?>