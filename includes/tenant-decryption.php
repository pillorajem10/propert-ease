<?php
$encryptionKey2 = $tenant['encryption_key'];
$tenantFname = decryptData($tenant['tenant_fname'], $encryptionKey2);
$tenantLname = decryptData($tenant['tenant_lname'], $encryptionKey2);
$tenantEmail = $tenant['tenant_email'];
$tenantProfile = decryptData($tenant['tenant_dp'], $encryptionKey2);
$picPath = '../img/';
$tenantDp = $picPath . $tenantProfile;
?>