<?php
$encryptionKey3 = $yourReview['encryption_key'];
$yourReviewFname = decryptData($yourReview['tenant_fname'], $encryptionKey3);
$yourReviewLname = decryptData($yourReview['tenant_lname'], $encryptionKey3);
$yourReviewEmail = $yourReview['tenant_email'];
$yourReviewProfile = decryptData($yourReview['tenant_dp'], $encryptionKey3);
$picPath = 'img/profile/';
$yourReviewDp = $picPath . $yourReviewProfile;
$dateString=$tenantReview['review_date'];
$date = new DateTime($dateString);
$formattedDate3 = $date->format('F j, Y');
?>