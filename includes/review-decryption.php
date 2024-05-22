<?php
$reviewId = $review['tenant_id'];
$stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
$stmt->execute([$reviewId]);
$reviewTenant = $stmt->fetch(PDO::FETCH_ASSOC); 

if ($reviewTenant && is_array($reviewTenant)) {
    $encryptionKey4 = $reviewTenant['encryption_key'] ?? null;
    $reviewTenantFname = isset($reviewTenant['tenant_fname']) ? decryptData($reviewTenant['tenant_fname'], $encryptionKey4) : '';
    $reviewTenantLname = isset($reviewTenant['tenant_lname']) ? decryptData($reviewTenant['tenant_lname'], $encryptionKey4) : '';
    $reviewTenantEmail = $reviewTenant['tenant_email'] ?? '';
    $reviewTenantProfile = isset($reviewTenant['tenant_dp']) ? decryptData($reviewTenant['tenant_dp'], $encryptionKey4) : '';
    $picPath = 'img/profile/';
    $reviewTenantDp = $picPath . $reviewTenantProfile;
    
    $dateString = $tenantReview['review_date'] ?? '';
    $date = new DateTime($dateString);
    $formattedDate4 = $date->format('F j, Y');
}
?>