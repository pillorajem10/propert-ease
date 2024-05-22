<?php
session_start();
require_once('connect.php');
require_once('includes/profile-function.php');
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Propert-Ease</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- logo icon image/x-icon  -->
	<link rel ="icon" href="img/icon.png" type="image/x-icon">
    <!-- Font Icons css -->
    <link rel="stylesheet" href="css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="css/plugins.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/account.css">
    <link rel="stylesheet" href="css/alert.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="manifest" href="manifest.json">
</head>

<body>
<!-- Body main wrapper start -->
<div class="body-wrapper">
    <!-- HEADER AREA START (header-5) -->
    <?php
    require_once 'header.php';
    ?>
    <!-- HEADER AREA END -->

    <div class="ltn__utilize-overlay"></div>

    <!-- Main Content -->
    <div class="ltn__product-area" style="background-color: #f7f7f7;">
        <main id="content" class="container">
            <div class="container-fluid bg-light py-5">
                <div class="container">
                    <!-- Breadcrumb Area -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Account</li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumb Area -->

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#profile-tab"><i class="fas fa-user"></i> Profile Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#password-tab"><i class="fas fa-lock"></i> Change Password</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-4">
                        <!-- Profile Account Tab -->
                        <div class="tab-pane fade show active" id="profile-tab">
                            <div class="row">
                                <div class="col-md-4 text-center profile-account">
                                    <h3 class="title mt-1">Profile Account</h3>
                                    <img class="profile-picture img-fluid rounded-circle mb-4" id="profile-picture" src="../<?=$imagePath?>" alt="User Image">
                                    <button id="editProfileBtn" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editProfileModal">Edit Information</button>
                                </div>
                                <div class="col-md-7 profile-account">
                                    <form href="#" class="mt-5">
                                        <div class="form-group">
                                            <label for="fname">First Name:</label>
                                            <input type="text" id="fname" name="ltn__fname" class="form-control" value="<?php echo $fname; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="lname">Last Name:</label>
                                            <input type="text" id="lname" name="ltn__lname" class="form-control" value="<?php echo $lname; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address:</label>
                                            <input type="email" id="email" name="ltn__email" class="form-control" value="<?php echo $temail; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact">Contact Number:</label>
                                            <input type="text" id="contact" name="ltn__contact" class="form-control" value="<?php echo $contact; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address:</label>
                                            <input type="text" id="address" name="ltn__address" class="form-control" value="<?php echo $taddress; ?>" readonly>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Profile Account Tab -->

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="password-tab">
                            <div class="row">
                                <div class="col-md-6 offset-md-3 change-password">
                                    <h2 class="mt-4 ml-5">Change Password</h2>
                                    <form method="POST" id="changepassword-form" enctype="multipart/form-data">
                                        <div class="form-group ml-5">
                                            <label for="current-password" class="label">Current Password:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="current-password" placeholder="Enter current password">
                                                <div class="input-group-append">
                                                    <button class="btn toggle-password" type="button" data-target="current-password">
                                                        <i class="fa fa-eye-slash"></i>
                                                    </button>
                                                </div>
                                                <div id="error-currentpassword" class="error-message mb-5" style ="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group ml-5">
                                            <label for="new-password" class="label">New Password:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="new-password" placeholder="Enter new password">
                                                <div class="input-group-append">
                                                    <button class="btn toggle-password" type="button" data-target="new-password">
                                                        <i class="fa fa-eye-slash"></i>
                                                    </button>
                                                </div>
                                                <div id="error-newpassword" class="error-message mb-5" style ="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group ml-5">
                                            <label for="confirm-password" class="label">Confirm Password:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirm-password" placeholder="Confirm new password">
                                                <div class="input-group-append">
                                                    <button class="btn toggle-password" type="button" data-target="confirm-password">
                                                        <i class="fa fa-eye-slash"></i>
                                                    </button>
                                                </div>
                                                <div id="error-confirmpassword" class="error-message mb-5" style ="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="text-center ml-5">
                                            <button class="btn btn-primary btn-block" type="submit">Change Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Change Password Tab -->
                    </div>
                    <!-- End Tab Content -->
                </div>
            </div>

            <!-- Profile Account Edit Modal -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Account</h5>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <form method="POST" id="edit-profileform" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit-profile-image">Upload your photo:</label>
                                    <input type="file" id="edit-profile-image" accept="image/*" onchange="displayProfilePicture()">
                                    <img class="profile-picture img-fluid rounded-circle mt-2" src="<?=$imagePath?>" id="uploaded-image" alt="User Image">
                                    <div id="error-profile" class="error-message" style="display: none;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="edit-fname">First Name:</label>
                                    <input type="text" id="edit-fname" name="tenant_fname" value="<?php echo $fname; ?>" class="form-control">
                                    <div id="error-fname" class="error-message" style ="display: none;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="edit-lname">Last Name:</label>
                                    <input type="text" id="edit-lname" name="tenant_lname" value="<?php echo $lname; ?>" class="form-control">
                                    <div id="error-lname" class="error-message" style ="display: none;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="edit-email">Email Address:</label>
                                    <input type="email" id="edit-email" name="tenant_email" value="<?php echo $temail; ?>" class="form-control">
                                    <div id="error-email" class="error-message" style ="display: none;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="edit-contact">Contact Number:</label>
                                    <input type="text" id="edit-contact" name="tenant_contact" value="<?php echo $contact; ?>" class="form-control">
                                    <div id="error-contact" class="error-message" style ="display: none;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="edit-address">Address:</label>
                                    <input type="text" id="edit-address" name="tenant_address" value="<?php echo $taddress; ?>" class="form-control">
                                    <div id="error-address" class="error-message" style ="display: none;"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="submit" id="submitBtn" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Main Content End -->
    
    <!-- CHAT AREA START -->
    <?php
    require_once 'chat-support.php';
    ?>
    <!-- CHAT AREA END -->
    
    <!-- HOVER AREA START -->
    <?php
    require_once 'hover.php';
    ?>
    <!-- HOVER AREA END -->

    <!-- FOOTER AREA START -->
    <?php
    require_once 'footer.php';
    ?>
    <!-- FOOTER AREA END -->
</div>
<!-- Body main wrapper end -->

    <!-- Bootstrap, jQuery, and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <!-- All JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/profile-function.js"></script>
    <script src="js/change-password.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/close-modal.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/toggle-resetpassword.js"></script>
</body>
</html>