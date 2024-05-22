<?php
session_start();
// Include autoload function
function autoloader($class) {
    include 'includes/' . strtolower($class) . '.php';
}

// Register autoloader
spl_autoload_register('autoloader');

// Assuming $admin array is set with necessary data
$admin = $_SESSION['admin']; // Assuming admin data is stored in session
?>
<div class="dropdown ltn__drop-menu user-menu" style="margin-left: auto;">
    <input type="checkbox" id="userMenuDropdown" class="dropdown-toggle">
    <label for="userMenuDropdown" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="icon-user"></i>
    </label>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuDropdown">
        <!-- Display admin username -->
        <div class="dropdown-item text-center">
            <p class="mb-0"><?= isset($admin['username']) ? $admin['username'] : '' ?></p>
        </div>
        <div class="dropdown-divider"></div>
        <!-- Logout feature -->
        <a class="dropdown-item" href="#" onclick="showLogoutConfirmation(event);"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
    </div>
</div>