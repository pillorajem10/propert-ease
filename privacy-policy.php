<?php
session_start();
require_once('connect.php');
require_once('includes/privacypolicy-function.php');
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
    <link rel="stylesheet" href="css/privacy-policy.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Body main wrapper start -->
    <div class="body-wrapper">
        <!-- HEADER AREA START (header-5) -->
        <?php require_once 'header.php'; ?>
        <!-- HEADER AREA END -->

        <div class="ltn__utilize-overlay"></div>

        <!-- PRIVACY POLICY CONTENT START -->
        <div class="ltn__faq-area" style="background-color: #EBEBEB;">
            <div class="container py-5">
                <div class="row">
                <!-- Privacy Policy Section -->
                <div class="col-lg-8">
                    <h1 class="page-title mb-5">Privacy Policy</h1>
                    <div id="accordion">
                    <!-- Introduction -->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            1. Introduction
                            </button>
                        </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            This Privacy Policy explains how Propert-Ease collects, uses, shares, and protects user information.
                        </div>
                        </div>
                    </div>
                    <!-- Information We Collect -->
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            2. Information We Collect
                            </button>
                        </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            We collect various types of information, including personal data, usage data, and device information.
                        </div>
                        </div>
                    </div>
                    <!-- How We Use Information -->
                    <div class="card">
                        <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            3. How We Use Information
                            </button>
                        </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            We use the collected information to provide and improve our services, personalize content, and communicate with users.
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <?php
                // Check if the user is logged in
                $loggedIn = isset($_SESSION['tenant_id']);

                // Function to render the "Get Help" section
                function renderGetHelpSection() {
                    ?>
                    <div class="col-lg-4 mt-10">
                        <div class="text-center border rounded p-4" style="background-color: #f8f9fa; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            <h2 class="mb-4">Get Help</h2>
                            <p>Need assistance with your reservations, account, or more?</p>
                            <a href="login.html" class="btn btn-primary btn-lg mt-3">Login</a>
                            <a href="register.html" class="btn btn-secondary btn-lg mt-3">Register</a>
                        </div>
                    </div>
                    <?php
                }

                if (!$loggedIn) {
                    renderGetHelpSection();
                }
                ?>
                <div class="need-support text-center mt-50">
                    <h2>Still need help? Reach out to support 24/7:</h2>
                    <div class="text-center mt-4">
                        <a href="contact.php" class="btn btn-effect-1 text-uppercase" style="background-color: #008489; color: #fff; border-radius: 30px; padding: 12px 40px;">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- PRIVACY POLICY CONTENT END -->
        
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
        <?php require_once 'footer.php'; ?>
        <!-- FOOTER AREA END -->
    </div>
    <!-- Body main wrapper end -->

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- All JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>