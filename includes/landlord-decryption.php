<?php
$encryptionKey3 = $landlord['encryption_key'];
$landlordFname = decryptData($landlord['landlord_fname'], $encryptionKey3);
$landlordLname = decryptData($landlord['landlord_lname'], $encryptionKey3);
$landlordpic = decryptData($landlord['landlord_dp'], $encryptionKey3);
$decryptedAddress = decryptData($landlord['landlord_address'], $encryptionKey3);
$landlordNum = $landlord['landlord_contact'];
$pathing = "img/profile/";
$landlordDp = $pathing . $landlordpic;
?>