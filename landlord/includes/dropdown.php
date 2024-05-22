<?php
session_start();
// Include autoload function
function autoloader($class) {
    include 'includes/' . strtolower($class) . '.php';
}

// Function to decrypt data
function decryptedData($data, $key)
{
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encryptedData = substr($data, 16);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}

// Register autoloader
spl_autoload_register('autoloader');

// Assuming $landlord array is set with necessary data
$landlord = $_SESSION['landlord_id']; // Assuming landlord data is stored in session
?>

<!-- Dropdown Menu -->
<div class="dropdown ltn__drop-menu user-menu" style="margin-left: auto;">
    <input type="checkbox" id="userMenuDropdown" class="dropdown-toggle">
    <label for="userMenuDropdown" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="icon-user"></i>
    </label>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuDropdown">
        <?php
        // Check if the landlord_dp path is set and not empty
        if(isset($landlord['landlord_dp']) && !empty($landlord['landlord_dp'])) {
            $decryptedProfile = decryptedData($landlord['landlord_dp'], $landlord['encryption_key']);
            $decryptedFname = decryptedData($landlord['landlord_fname'], $landlord['encryption_key']);
            $decryptedLname = decryptedData($landlord['landlord_lname'], $landlord['encryption_key']);
            $decryptedRole = decryptedData($landlord['landlord_role'], $landlord['encryption_key']);

            $profilePictureDirectory = '/img/profile/';
            $imagePath = $profilePictureDirectory . $decryptedProfile ;
        }
        ?>
        <!-- Display profile information -->
        <div class="dropdown-item text-center">
            <img src="<?php echo $imagePath; ?>" class="profile-image mb-2" alt="Profile Image" height="100" width="100">
            <p class="mb-0"><?= isset($decryptedFname) ? $decryptedFname : '' ?> <?= isset($decryptedLname) ? $decryptedLname : '' ?></p>
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="profile.php"><i class="fas fa-user mr-2"></i> User Account</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" onclick="showLogoutConfirmation(event);"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
    </div>
</div>