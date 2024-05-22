<?php
session_start();
require_once('connect.php');
require_once('includes/index-function.php');
?>
<!doctype html>
<html lang="en">

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
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/home-section.css">
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
                                    <div class="slide-item-info text-center text-md-center" style="margin-bottom: 4rem;">
                                        <h1 class="slide-title" style="color: #fff; font-size: 36px; font-weight: bold;">Discover Your Dream Rental</h1>
                                        <p class="slide-desc" style="color: #fff; font-size: 18px; line-height: 1.6;">Explore our curated selection of rental properties and find your perfect home away from home.</p>
                                        <div class="btn-wrapper mt-4 d-flex justify-content-center">
                                            <a href="rental-list.php" class="btn bg-primary" style="color: #fff; border-radius: 30px; padding: 12px 40px;">Get Started</a>
                                        </div>
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
                                    <div class="slide-item-info text-center text-md-center" style="margin-bottom: 4.5rem;">
                                        <h1 class="slide-title" style="color: #fff; font-size: 36px; font-weight: bold;">Find Your Perfect Getaway</h1>
                                        <p class="slide-desc" style="color: #fff; font-size: 18px; line-height: 1.6;">Discover scenic destinations and cozy retreats for your next vacation.</p>
                                        <div class="btn-wrapper mt-4 d-flex justify-content-center">
                                            <a href="rental-list.php" class="btn bg-primary" style="color: #fff; border-radius: 30px; padding: 12px 40px;">Explore Now</a>
                                        </div>
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
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 mb-5">
                    <div class="about-content text-center p-4" style="background-color: #0045AE; border-radius: 8px; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);">
                        <h2 class="mb-3" style="font-size: 32px; font-weight: 700; color: #fff;">Discover Unique Spaces</h2>
                        <p class="mb-4" style="font-size: 18px; color: #fff;">Explore a curated selection of exceptional properties with distinctive features and amenities.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="about-info-wrap">
                        <div class="section-title-area mb-4">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <h2 class="section-subtitle mb-0 py-2 px-3" style="background-color: #0045AE; color: #fff; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">Our Story</h2>
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
                        <div class="btn-wrapper">
                            <a href="about.php" class="btn btn-primary text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary btn-team btn-hover" style="background-color: #0045AE; color: #fff; border-radius: 30px; padding: 12px 40px;">Meet Our Team</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="about-img-wrap about-img-left">
                        <a href="img/propertygallery.jpg" data-rel="lightcase:myCollection">
                            <img src="img/propertygallery.jpg" alt="About Us Image" style="border-radius: 10px; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ABOUT US AREA END -->

    <!-- PRODUCT SLIDER AREA START -->
    <div class="ltn__product-slider-area pt-5 pb-5" style="background-color: #FFF8F6;">
        <div class="container">
            <div class="section-title-area mb-4">
                <div class="row align-items-center">
                    <div class="col-auto text-center p-4">
                        <h2 class="section-subtitle mb-0 py-2 px-3" style="background-color: #0045AE; color: #fff; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">Featured Listings</h2>
                    </div>
                </div>
                <div class="row align-items-center mt-3">
                    <div class="col text-center">
                        <h1 class="section-title mb-4" style="color: #333; font-size: 36px; font-weight: bold;">Explore Our Properties</h1>
                        <hr class="my-0 d-md-none" style="border-top: 2px solid #0045AE;">
                    </div>
                </div>
            </div>
            <div class="ltn__product-slider ltn__product-tab-content-inner ltn__product-grid-view">
                <div class="row ltn__product-slider justify-content-center">
                    <?php
                    // Find the maximum description length to determine the height
                    $maxDescriptionLength = 0;
                    foreach ($properties as $property) {
                        if ($property['property_status'] === 'Active') {
                            $descriptionLength = strlen($property['property_description']);
                            if ($descriptionLength > $maxDescriptionLength) {
                                $maxDescriptionLength = $descriptionLength;
                            }
                        }
                    }
                    ?>
                    <?php foreach ($properties as $property): ?>
                        <?php require 'includes/property-decryption.php'; ?>
                        <?php if ($property['property_status'] === 'Active'): ?>
                            <div class="col-md-6 col-sm-12 mb-4 col-lg-4 col-lg-12 text-center">
                                <div class="card h-100 ltn__product-item ltn__product-item-4 d-flex flex-column" style="background-color: #fff; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <!-- Property Image -->
                                    <div class="product-img" style="position: relative; overflow: hidden; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <a href="<?= $path ?>" data-rel="lightcase:myCollection">
                                            <img src="<?= $path ?>" class="card-img-top img-fluid" style="object-fit: cover; width: 100%; height: 300px;" alt="Property Image">
                                        </a>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <ul class="product-badge">
                                            <li class="sale-badge" style="background-color: #77C720; color: #fff;">For Rent</li>
                                        </ul>
                                        <!-- Property Title -->
                                        <h5 class="card-title mt-3 mb-2"><?= $propertyName ?></h5>
                                        <!-- Location -->
                                        <p class="card-text text-muted"><i class="flaticon-pin" style="background-color: #f8d7da; padding: 6px; border-radius: 50%;"></i> <?= $propertyCity ?>, <?= $propertyProvince ?></p>
                                        <hr>
                                        <!-- Description -->
                                        <p class="card-text text-muted mb-3 property-description" style="flex: 1; min-height: <?= $maxDescriptionLength * -15 ?>px;"><?= $propertyDescription ?></p>
                                        <!-- Price -->
                                        <p class="card-text"><strong>₱<?= $propertyPrice ?> per month</strong></p>
                                        <!-- View Details Button -->
                                        <div class="text-center mt-auto">
                                            <a href="#" class="btn btn-primary text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary" title="Property Details" onclick="propertySelect(<?= $propertyId ?>)">
                                                <i class="fa fa-eye"></i> View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT SLIDER AREA END -->
    
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

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>

    <!-- jQuery (required by Slick Slider) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Slick Slider JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    
    <!-- All JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/property.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/product-slider.js"></script>
    <script src="js/property-id.js"></script>
    <script src="js/choose-function.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>