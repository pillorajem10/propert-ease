<?php
function my_autoloader($class) {
    include 'includes/' . strtolower($class) . '.php';
}

function decryptData($data, $key)
{
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encryptedData = substr($data, 16);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}


spl_autoload_register('my_autoloader');

?>

<header class="ltn__header-area ltn__header-5 ltn__header-transparent--- gradient-color-4---">
    <!-- ltn__header-middle-area start -->
    <div class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-white">
        <div class="container">
            <div class="row align-items-center">
                <!-- User Options -->
                <div class="col-md-2 col-6 text-right">
                    <div class="ltn__header-options ltn__header-options-2 mb-sm-20">
                        <!-- User Menu -->
                        <div class="dropdown ltn__drop-menu user-menu">
                            <a class="dropdown-toggle" href="#" role="button" id="userMenuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-user"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuDropdown">
                                <?php
                                // Check if the landlord_dp path is set and not empty
                                if(isset($landlord['landlord_dp']) && !empty($landlord['landlord_dp'])) {
                                    $decryptedProfile = decryptData($landlord['landlord_dp'], $landlord['encryption_key']);
                                    $decryptedFname = decryptData($landlord['landlord_fname'], $landlord['encryption_key']);
                                    $decryptedLname = decryptData($landlord['landlord_lname'], $landlord['encryption_key']);
                                    $decryptedRole = decryptData($landlord['landlord_role'], $landlord['encryption_key']);

                                    $profilePictureDirectory = '/img/profile/';
                                    $imagePath = $profilePictureDirectory . $decryptedProfile ;
                                }
                                ?>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ltn__header-middle-area end -->
</header>