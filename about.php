<?php
session_start();
require_once('connect.php');
require_once('includes/about-function.php');
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
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/about-section.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
    
    <!-- SLIDER AREA START (slider-3) -->
    <div class="slider-area section-bg-1">
        <div id="ltn__carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <!-- Slide Item 1 -->
                <div class="carousel-item active" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('img/rental-property.jpg'); height: 400px; background-size: cover; background-position: center;">
                    <div class="carousel-caption d-md-block">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="slide-item-info text-center text-md-center" style="margin-bottom: 7rem;">
                                        <h1 class="slide-title" style="color: #fff; font-size: 36px; font-weight: bold;">Discover Your Dream Rental</h1>
                                        <p class="slide-desc" style="color: #fff; font-size: 18px; line-height: 1.6;">Explore our curated selection of rental properties and find your perfect home away from home.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide Item 1 -->

                <!-- Slide Item 2 -->
                <div class="carousel-item" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('img/propertygallery.jpg'); height: 400px; background-size: cover; background-position: center;">
                    <div class="carousel-caption d-md-block">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="slide-item-info text-center text-md-center" style="margin-bottom: 8rem;">
                                        <h1 class="slide-title" style="color: #fff; font-size: 36px; font-weight: bold;">Find Your Perfect Getaway</h1>
                                        <p class="slide-desc" style="color: #fff; font-size: 18px; line-height: 1.6;">Discover scenic destinations and cozy retreats for your next vacation.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide Item 2 -->
            </div>
            <!-- Carousel Controls -->
            <a class="carousel-control-prev" href="#ltn__carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#ltn__carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <!-- SLIDER AREA END -->

    <!-- ABOUT US AREA START -->
    <div class="about-us-area py-5" style="background-color: #F2F4F6;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="about-info-wrap">
                        <div class="section-title-area mb-4">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <h2 class="section-subtitle mb-0 py-2 px-3" style="background-color: #0045AE; color: #fff; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">About Us</h2>
                                </div>
                                <div class="col">
                                    <hr class="my-0" style="border-top: 2px solid #0045AE;">
                                </div>
                            </div>
                            <h1 class="section-title mt-3" style="color: #333; font-size: 36px; font-weight: bold;">Welcome to Propert-Ease</h1>
                        </div>
                        <div class="about-desc mb-4" style="color: #555; font-size: 16px; line-height: 1.6;">
                            <p>Unlocking Your Dream Spaces</p>
                            <p>At Propert-Ease, we're dedicated to simplifying the search for your ideal property. Our platform offers a personalized experience, guiding you through a collection of handpicked listings tailored to your preferences.</p>
                            <p>Driven by innovation and a commitment to excellence, we strive to redefine the way you discover and engage with rental property.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="about-img-wrap about-img-left">
                        <a href="img/startup-logo.png" data-rel="lightcase:myCollection">
                            <img src="img/startup-logo.png" alt="About Us Image" style="border-radius: 10px; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ABOUT US AREA END -->
    
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
    <!-- All JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/about.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/back-button.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>