<?php
require_once('includes/security.php');
function my_autoloader($class) {
    include 'includes/' . strtolower($class) . '.php';
}

spl_autoload_register('my_autoloader');
?>
<div id="sidebar" class="col-md-3 col-12 bg-primary d-md-block">
    <div class="sidebar-container">
        <img class="logo" src="img/app-logo.png" alt="Logo" height="50">
    </div>
    <div class="profile-container">
        <?php
        // Check if the landlord_dp path is set and not empty
        if(isset($landlord['landlord_dp']) && !empty($landlord['landlord_dp'])) {
            $decryptedProfile = decryptData($landlord['landlord_dp'], $landlord['encryption_key']);
            $decryptedFname = decryptData($landlord['landlord_fname'], $landlord['encryption_key']);
            $decryptedLname = decryptData($landlord['landlord_lname'], $landlord['encryption_key']);
            $decryptedRole = decryptData($landlord['landlord_role'], $landlord['encryption_key']);

            $profilePictureDirectory = 'img/profile/';
            $imagePath = $profilePictureDirectory . $decryptedProfile;
        }
        ?>
        <img src="../<?= $imagePath ?>" alt="Profile Image" class="profile-image">
        <div class="profile-info">
            <p><span id="name"><?= isset($decryptedFname) ? $decryptedFname : '' ?> <?= isset($decryptedLname) ? $decryptedLname : '' ?></span></p>
            <p><span id="role"><?=$decryptedRole?></span></p>
            <a href="profile.php" class="profile-btn">Profile Account</a>
        </div>
    </div>
    <div class="features-container">
        <a href="dashboard.php" class="nav-link">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a href="property-list.php" class="nav-link nav-link2">
            <i class="fas fa-building me-2"></i> Property List
        </a>
        <form id="logout-form" method="POST">
            <a href="#" onclick="showLogoutConfirmation(event);" class="nav-link">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </form>
    </div>
    <div class="sidebar-footer">
        <p>&copy; <span class="current-year"></span> Propert-Ease. All rights reserved</p>
    </div>
</div>