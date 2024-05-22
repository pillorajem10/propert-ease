<div id="sidebar" class="col-md-3 col-12 bg-primary d-md-block">
    <div class="sidebar-container">
        <img class="logo" src="img/app-logo.png" alt="Logo" height="50">
    </div>
    <div class="profile-container">
        <img src="img/admin.png" alt="Profile Image" class="profile-image">
        <div class="profile-info">
            <p><span id="username"><?= isset($admin['admin_username']) ? $admin['admin_username'] : 'Unknown' ?></span></p>
        </div>
    </div>
    <div class="features-container">
        <a href="dashboard.php" class="nav-link">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a href="property-management.php" class="nav-link nav-link2">
            <i class="fas fa-building me-2"></i> Property Management
        </a>
        <div class="dropdown">
            <a class="nav-link dropdown-toggle sub-btn" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-address-card me-2"></i> Logs
            </a>
            <ul class="dropdown-menu sub-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="history-logs.php"><i class="fas fa-history me-2"></i> History Logs</a></li>
                <li><a class="dropdown-item" href="transaction-logs.php"><i class="fas fa-file me-2"></i> Transaction Logs</a></li>
            </ul>
        </div>
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