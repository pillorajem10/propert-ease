<?php
function my_autoloader($class) {
    include 'includes/' . strtolower($class) . '.php';
}

require_once('includes/security.php');

spl_autoload_register('my_autoloader');
?>
<style>
#notificationList {
    max-height: 400px;
    overflow-y: auto;
}
.nav-icon {
    display: flex;
    position: absolute;
    margin-top: 0.2%;
    margin-left: -35%;
}
</style>
<header class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="img/app-logo.png" alt="Logo" width="150">
        </a>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav text-center text-lg-left d-none d-lg-flex">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold fs-5 fs-lg-4" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold fs-5 fs-lg-4" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold fs-5 fs-lg-4" href="rental-list.php">Properties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold fs-5 fs-lg-4" href="contact.php">Contact</a>
                </li>
            </ul>
        </div>

        <!-- User Options -->
        <div class="nav-item dropdown ml-auto">
            <?php
            if (!isset($_SESSION['tenant_id'])) {
                echo '
                    <a class="nav-link font-weight-bold" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                    </a>
                ';
            } else {
                echo '
                    <div class="nav-icon">
                        <a class="nav-link font-weight-bold" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i> <span id="notificationCount" class="badge badge-danger" style="display: none;"></span>
                        </a>
                    </div>
                    <a class="nav-link dropdown-toggle font-weight-bold" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle mr-1"></i> My Account
                    </a>
                ';
            }
            ?>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <?php
                if (!isset($_SESSION['tenant_id'])) {
                    echo '
                        <a class="dropdown-item" href="login.html"><i class="fas fa-sign-in-alt mr-2"></i> Login</a>
                        <a class="dropdown-item" href="register.html"><i class="fas fa-user-plus mr-2"></i> Register</a>
                    ';
                } else {
                    if (isset($tenant) && is_array($tenant)) {
                        $decryptedProfile = decryptData($tenant['tenant_dp'], $tenant['encryption_key']);
                        $decryptedFname = decryptData($tenant['tenant_fname'], $tenant['encryption_key']);
                        $decryptedLname = decryptData($tenant['tenant_lname'], $tenant['encryption_key']);
            
                        echo '
                            <div class="dropdown-item text-center">
                                <img src="img/profile/'.$decryptedProfile.'" class="profile-image mb-2 rounded-circle" alt="Profile Image" height="80" width="80">
                                <p class="mb-0">'.$decryptedFname.' '.$decryptedLname.'</p>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="account.php"><i class="fas fa-user mr-2"></i> User Account</a>
                        ';
        
                        if ($tenant['property_id']) {
                            echo '<a class="dropdown-item" href="payment-management.php"><i class="fas fa-money-check-alt mr-2"></i> Payment Management</a>';
                        } else {
                            echo '<a class="dropdown-item disabled" href="#"><i class="fas fa-money-check-alt mr-2"></i> Payment Management</a>';
                        }
            
                        echo '
                            <a class="dropdown-item" href="privacy-policy.php"><i class="fas fa-shield-alt mr-2"></i> Privacy Policy</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="showLogoutConfirmation(event);"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                        ';
                    }
                }
                ?>
        
                <!-- Show these items only in mobile view -->
                <a class="dropdown-item hide-web" href="index.php"><i class="fas fa-home mr-2"></i> Home</a>
                <a class="dropdown-item hide-web" href="about.php"><i class="fas fa-info-circle mr-2"></i> About</a>
                <a class="dropdown-item hide-web" href="rental-list.php"><i class="fas fa-building mr-2"></i> Properties</a>
                <a class="dropdown-item hide-web" href="contact.php"><i class="fas fa-envelope mr-2"></i> Contact</a>
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown" id="notificationList">
            <!-- Notifications will be appended here by JavaScript -->
            <a class="dropdown-item" href="#" id="markAllReadBtn">Mark All as Read</a>
        </div>
    </div>
</header>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
$(document).ready(function() {
    // Check screen width on page load
    checkScreenWidth();

    // Check screen width on window resize
    $(window).resize(checkScreenWidth);

    function checkScreenWidth() {
        var screenWidth = $(window).width();
        if (screenWidth < 992) {
            $('.dropdown-menu .hide-web').removeClass('d-none');
        } else {
            $('.dropdown-menu .hide-web').addClass('d-none');
        }
    }

    // Add click event listener to navbar toggler button
    $('.navbar-toggler').on('click', function() {
        var $dropdownMenu = $(this).siblings('.dropdown-menu');
        $dropdownMenu.toggleClass('show');
    });

    // Add click event listener to dropdown toggle in user options
    $('#navbarDropdown').on('click', function(event) {
        event.preventDefault();
        var $dropdownMenu = $(this).next('.dropdown-menu');
        $dropdownMenu.toggleClass('show');
        // Clear notification count when dropdown is opened
        $('#notificationCount').hide();
    });

    $('#notificationDropdown').on('click', function(event) {
        event.preventDefault();
        var $dropdownMenu = $('#notificationList');
        $dropdownMenu.toggleClass('show');
        // Clear notification count when dropdown is opened
        $('#notificationCount').hide();
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('.nav-item.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });
    
    // Add click event listener to "Mark All as Read" button
    $('#markAllReadBtn').on('click', function(event) {
        event.preventDefault();
        // Mark all notifications as read (this is a simulated action)
        $('#notificationList').empty().append('<a class="dropdown-item" href="#">All notifications marked as read</a>');
        $('#notificationCount').hide(); // Hide notification count
    });


    // Function to fetch and display notifications
    function fetchNotifications() {
        // Simulated test data
        var notifications = [
            {
                title: "New Message",
                message: "You have received a new message.",
                date: "2024-05-18"
            },
            {
                title: "Reminder",
                message: "Don't forget about the meeting tomorrow.",
                date: "2024-05-19"
            },
            {
                title: "Alert",
                message: "System maintenance scheduled for next week.",
                date: "2024-05-20"
            }
        ];

        var notificationList = $('#notificationList');
        var notificationCount = $('#notificationCount');
        notificationList.empty();

        if (notifications.length > 0) {
            notifications.forEach(function(notification) {
                // Format date
                var formattedDate = new Date(notification.date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });

                // Append notification to list
                notificationList.append(`
                    <a class="dropdown-item" href="#">
                        <div class="title">${notification.title}</div>
                        <div class="message">${notification.message}</div>
                        <div class="date">${formattedDate}</div>
                    </a>
                `);
            });

            // Show notification count only if there are new notifications
            if ($('#notificationCount').css('display') === 'none') {
                notificationCount.text(notifications.length).show();
                $('#notificationDropdown').addClass('show'); // Ensure dropdown is shown
            }
        } else {
            // If no notifications, display a message
            notificationList.append('<a class="dropdown-item" href="#">No new notifications</a>');
            notificationCount.hide(); // Hide notification count
        }
    }

    // Initially fetch notifications
    fetchNotifications();

    // Periodically update notifications (simulated here with setTimeout)
    setInterval(fetchNotifications, 60000); // Update every 60 seconds
});
</script>