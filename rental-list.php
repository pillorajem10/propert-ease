<?php
session_start();
require_once('connect.php');
require_once('includes/security.php');
require_once('includes/rentallist-function.php');
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>

    <!-- logo icon image/x-icon  -->
    <link rel="icon" href="img/icon.png" type="image/x-icon">
    <!-- Font Icons css -->
    <link rel="stylesheet" href="css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="css/plugins.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/rental-list.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <!-- Body main wrapper start -->
    <div class="body-wrapper">
        <!-- HEADER AREA START (header-5) -->
        <?php require_once 'header.php'; ?>
        <!-- HEADER AREA END -->

        <div class="ltn__utilize-overlay"></div>

        <!-- Rental List Section -->
        <div class="ltn__product-area ltn__product-gutter" style="background-color: #f7f7f7;">
            <div class="container">
                <h1 class="page-title mb-4">Rental List</h1>
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <aside class="sidebar ltn__shop-sidebar ltn__right-sidebar p-4 rounded shadow" style="background-color: #ffffff; border: 1px solid #e0e0e0;">
                            <h3 class="mb-3">Navigation</h3>
                            <div class="widget ltn__menu-widget">
                                <h4 class="ltn__widget-title mb-3">Rental Type:</h4>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <label class="checkbox-item">
                                            House
                                            <input type="radio" name="rental_type" value="House" class="rental-type-btn" onchange="handleRentalTypeChange(this)">
                                            <span class="checkType <?php echo (strtolower($showingType) === 'house' ? 'checked' : ''); ?>"></span>
                                        </label>
                                        <span class="category-no"><?php echo $numHouses; ?></span>
                                    </li>
                                    <li>
                                        <label class="checkbox-item">
                                            Apartment
                                            <input type="radio" name="rental_type" value="Apartment" class="rental-type-btn" onchange="handleRentalTypeChange(this)">
                                            <span class="checkType <?php echo (strtolower($showingType) === 'apartment' ? 'checked' : ''); ?>"></span>
                                        </label>
                                        <span class="category-no"><?php echo $numApartments; ?></span>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <div class="widget ltn__menu-widget">
                                <h4 class="ltn__widget-title mb-3">Location:</h4>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <label class="checkbox-item">
                                            Olongapo
                                            <input type="radio" name="property_location" value="Olongapo" class="property-location-btn" onchange="handlePropertyLocationChange(this)" <?php echo (strtolower($showingCity) === 'olongapo' ? 'checked' : ''); ?>>
                                            <span class="checkCity <?php echo (strtolower($showingCity) === 'olongapo' ? 'checked' : ''); ?>"></span>
                                        </label>
                                        <span class="category-no"><?php echo $numOlongapo; ?></span>
                                    </li>
                                    <li>
                                        <label class="checkbox-item">
                                            Subic
                                            <input type="radio" name="property_location" value="Subic" class="property-location-btn" onchange="handlePropertyLocationChange(this)" <?php echo (strtolower($showingCity) === 'subic' ? 'checked' : ''); ?>>
                                            <span class="checkCity <?php echo (strtolower($showingCity) === 'subic' ? 'checked' : ''); ?>"></span>
                                        </label>
                                        <span class="category-no"><?php echo $numSubic; ?></span>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <div class="widget ltn__price-filter-widget">
                                <form id="price_filter_form">
                                    <h4 class="ltn__widget-title ltn__widget-title-border mb-3">Filter by Price</h4>
                                    <div class="price_filter">
                                        <div class="price_slider_amount">
                                            <input type="range" class="form-control-range mt-2" id="min_price" name="min_price" min="0" max="5000" step="100" value="<?php echo isset($_POST['min_price']) ? $_POST['min_price'] : '0'; ?>" />
                                            <input type="range" class="form-control-range mt-2" id="max_price" name="max_price" min="0" max="5000" step="100" value="<?php echo isset($_POST['max_price']) ? $_POST['max_price'] : '5000'; ?>" />
                                            <div class="mt-2">
                                                Price Range: <span id="price_range"><?php echo isset($_POST['min_price']) ? '₱' . $_POST['min_price'] : '₱0'; ?> - <?php echo isset($_POST['max_price']) ? '₱' . $_POST['max_price'] : '₱5000'; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </aside>
                    </div>
                    <!-- End Sidebar -->

                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-4 offset-md-8 mb-3">
                                <div class="input-group position-relative">
                                    <input type="text" class="form-control rounded-pill" placeholder="Search Property..." id="searchInput">
                                    <div class="search-icon position-absolute" style="right: 20px; top: 50%; transform: translateY(-50%);">
                                        <i class="fas fa-search text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product Listing -->
                        <div class="ltn__shop-options">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="text-left">
                                        <span id="selected_rental_type">
                                            <?php 
                                                if (!empty($selected_rental_type)) {
                                                    echo 'Showing ' . $selected_rental_type;
                                                }
                                                if (!empty($selected_property_city)) {
                                                    echo 'Showing ' . $selected_property_city;
                                                }
                                                if (empty($selected_rental_type) && empty($selected_property_city)) {
                                                    echo 'Showing All';
                                                }
                                            ?>:
                                        </span>
                                    </h3>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="text-right">1–<?php echo min(12, count($properties)); ?> of <?php echo $totalResults; ?> results</h3>
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
                                    <?php require 'includes/rentallist-decryption.php'; ?>
                                    <?php if ($property['property_status'] === 'Active'): ?>
                                        <div class="col-xl-6 col-md-6 col-12 mb-4 property <?= $property['property_type'] ?>" <?= $property['property_city'] ?>" data-city="<?= strtolower($property['property_city']) ?>" data-type="<?= $property['property_type'] ?>" data-price="<?= $property['property_price'] ?>">
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
                                                    <p class="card-text location text-muted"><i class="flaticon-pin" style="background-color: #f8d7da; padding: 6px; border-radius: 50%;"></i> <?= $propertyCity ?>, <?= $propertyProvince ?></p>
                                                    <hr>
                                                    <!-- Description -->
                                                    <p class="card-text text-muted mb-3" style="flex: 1; min-height: <?= $maxDescriptionLength * -15 ?>px;"><?= $propertyDescription ?></p>
                                                    <!-- Price -->
                                                    <p class="card-text price-data-filter text-center"><strong>₱<?= $propertyPrice ?> per month</strong></p>
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
                        <!-- No Results Message -->
                        <div class="row">
                            <div class="col-md-12 text-center mt-4">
                                <div class="alert alert-warning" role="alert" id="noResultsMessage" style="display: none;">
                                    <strong>No results found</strong>
                                </div>
                            </div>
                        </div>
                        <!-- End No Results Message -->
                    </div>
                    <!-- End Main Content -->
                </div>
            </div>
        </div>
        <!-- Rental List Section End -->
        
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

    <!-- Bootstrap, jQuery, and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <!-- Slick Slider JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <!-- All JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/back-button.js"></script>
    <script src="js/rentallist-function.js"></script>
    <script src="js/propertylist-function.js"></script>
    <script src="js/product-slider.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/search.js"></script>
    <script src="js/property-id.js"></script>
    <script src="js/carousel-function.js"></script>
    <script src="js/choose-function.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>