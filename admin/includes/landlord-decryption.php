<?php
$encryptionKey3 = $landlord['encryption_key'];
$landlordProfile = decryptData($landlord['landlord_dp'], $encryptionKey3);
$landlordFname = decryptData($landlord['landlord_fname'], $encryptionKey3);
$landlordLname = decryptData($landlord['landlord_lname'], $encryptionKey3);
$landlordDate = date('F j, Y', strtotime($landlord['landlord_verifiedAt']));
$landlordId = $landlord['landlord_id'];
$profilePictureDirectory = '../img/profile/';
$imagePath = $profilePictureDirectory . $landlordProfile;
?>