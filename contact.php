<?php
session_start();
require_once('connect.php');
require_once('includes/contact-function.php');
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
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/contact-section.css">
    <link rel="stylesheet" href="css/alert.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-GLhlTQ8i7uZL9gB1Tpp5mG8r7az2K4I5MOp+5mr5OqnySIIlkt6z3L4Ffnt5vBxU" crossorigin="anonymous">
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
                                    <div class="slide-item-info text-center text-md-center" style="margin-bottom: 8rem;">
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

    <!-- CONTACT ADDRESS AREA START -->
    <div class="contact-address-area mb-5" style="background-color: #F7F7F7; padding-top: 80px; padding-bottom: 80px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8" style="color: #0045AE;">
                    <div class="section-title-area text-center">
                        <h2 class="section-subtitle mb-4" style="color: #0045AE; padding-bottom: 5px; border-bottom: 2px solid #FF385C;">Contact Us</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <a class="card-link">
                        <div class="contact-address-item bg-white shadow-sm p-4 rounded">
                            <div class="contact-address-icon text-danger mb-3">
                                <i class="fas fa-envelope fa-2x"></i>
                            </div>
                            <h3 class="text-dark">Email Address</h3>
                            <p class="text-secondary">propertease20@gmail.com</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a class="card-link">
                        <div class="contact-address-item bg-white shadow-sm p-4 rounded">
                            <div class="contact-address-icon text-danger mb-3">
                                <i class="fas fa-phone fa-2x"></i>
                            </div>
                            <h3 class="text-dark">Phone Number</h3>
                            <p class="text-secondary">09123456780</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a class="card-link">
                        <div class="contact-address-item bg-white shadow-sm p-4 rounded">
                            <div class="contact-address-icon text-danger mb-3">
                                <i class="fas fa-map-marker-alt fa-2x"></i>
                            </div>
                            <h3 class="text-dark">Office Address</h3>
                            <p id="officeAddress" class="text-secondary">1234 Main Street Makati City</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title-area text-center">
                        <h2 class="section-subtitle mt-5" style="color: #0045AE; padding-bottom: 5px; border-bottom: 2px solid #FF385C;">Our Location</h2>
                    </div>
                </div>
            </div>
            <div class="map-responsive d-flex justify-content-center align-items-center">
                <?php require_once('includes/map.php');?>
                <div id="map" style="width: 80%; height: 100rem;">
                    <iframe src="about:blank" id="mapboxIframe" title="Mapbox Map" style="border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTACT ADDRESS AREA END -->

    <!-- CONTACT MESSAGE AREA START -->
    <div class="contact-message-area mb-5" style="background-color: #F7F7F7; padding-top: 80px; padding-bottom: 80px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-box contact-form-box shadow-sm" style="background-color: #FFFFFF; padding: 40px; border-radius: 15px;">
                        <h2 class="text-center mb-4" style="color: #333;">Get in Touch</h2>
                        <form id="contact-form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" id="name" name="name" placeholder="Your Name" class="form-control" style="border-radius: 8px;">
                                    <div id="error-name" class="error-message" style="display: none;"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="email" id="email" name="email" placeholder="Email Address" class="form-control" style="border-radius: 8px;">
                                    <div id="error-email" class="error-message" style="display: none;"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" id="phone" name="phone" placeholder="Phone Number" class="form-control" style="border-radius: 8px;">
                                    <div id="error-phone" class="error-message" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea id="message" name="message" placeholder="Your Message" class="form-control" rows="6" style="border-radius: 8px;"></textarea>
                                <div id="error-message" class="error-message" style="display: none;"></div>
                            </div>
                            <div class="form-check mb-4">
                                <input type="checkbox" name="agree" id="agree" class="form-check-input">
                                <label class="form-check-label" for="agree">Save my info for future messages.</label>
                            </div>
                            <div class="text-center">
                                <button class="btn bg-primary text-white py-2 px-4 rounded-pill submit-btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTACT MESSAGE AREA END -->
    
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
    require_once('footer.php');
    ?>
    <!-- FOOTER AREA END -->
</div>
<!-- Body main wrapper end -->

    <!-- All JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet" />
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/contact.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/back-button.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>