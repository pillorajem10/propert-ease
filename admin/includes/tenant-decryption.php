<?php
$encryptionKey2 = $tenant['encryption_key'];
$tenantFname = decryptData($tenant['tenant_fname'], $encryptionKey2);
$tenantLname = decryptData($tenant['tenant_lname'], $encryptionKey2);
$tenantProfile = decryptData($tenant['tenant_dp'], $encryptionKey2);
$tenantDate = date('F j, Y', strtotime($tenant['tenant_verifiedAt']));
$tenantDue = date('F j, Y', strtotime($tenant['tenant_dueDate']));
$tenantId = $tenant['tenant_id'];
$picPath = '../img/profile/';
$tenantDp = $picPath . $tenantProfile;
$tenantStatus = $tenant['tenant_status'];
?>