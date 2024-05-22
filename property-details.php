<?php
session_start();
require_once('connect.php');
require_once('includes/security.php');
require_once('includes/propertydetail-function.php');
require_once('includes/map-script.php');
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-GLhlTQ8i7uZL9gB1Tpp5mG8r7az2K4I5MOp+5mr5OqnySIIlkt6z3L4Ffnt5vBxU" crossorigin="anonymous">
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.css" rel="stylesheet">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/property-details.css">
    <link rel="stylesheet" href="css/alert.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
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

    <!-- IMAGE AREA START -->
    <div class="ltn__img-area mb-90" style="background-color: #f7f7f7;">
        <div class="container">
            <div class="exit-btn">
                <a href="rental-list.php" class="btn btn-primary text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary">
                    Go Back
                </a>
            </div>
            <?php if($property):
            require_once('includes/property-decryption.php');?>
            <h1 class="page-title mt-4">Property Details</h1>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="product-img" style="position: relative; overflow: hidden; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <a href="<?=$path?>" data-rel="lightcase:myCollection">
                            <img src="<?=$path?>" alt="Property Image" class="card-img-top img-fluid mb-4" height="400" width="600" style="object-fit: cover;">
                        </a>
                    </div>
                    <!-- Property Details -->
                    <div class="property-details card">
                        <div class="card-body">
                            <div class="ltn__blog-meta">
                                <ul>
                                    <li class="ltn__blog-category">
                                        <a href="#" style="background-color: #6EC6FF; color: #fff;">Featured</a>
                                    </li>
                                    <li class="ltn__blog-category">
                                        <a href="#" style="background-color: #77C720; color: #fff;">For Rent</a>
                                    </li>
                                    <li class="ltn__blog-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <?php
                                        $dateString=$property['property_verifiedAt'];
                                        $date = new DateTime($dateString);
                                        $formattedDate = $date->format('F j, Y');
                                        echo $formattedDate;
                                        ?>
                                    </li>
                                    <li>
                                        <a href="#"><i class="far fa-comments"></i><?=$property['property_comments']?> comments</a>
                                    </li>
                                </ul>
                                <h2 class="mt-3"><?=$propertyName?></h2>
                                <p class="text-muted"><i class="flaticon-pin ltn__secondary-color"></i> <?=$propertyCity?>, <?=$propertyProvince?></p>
                                <p class="text-capitalize"><?=$propertyDescription?></p>
                                <ul class="list-unstyled">
                                    <li><strong>Price:</strong> ₱<?=$propertyPrice?> </span><span>
                                            <?php
                                                if ($propertyDue === 30){
                                                    echo '(Monthly due)';
                                                } else{
                                                    echo '(Semi-Monthly due)';
                                                }
                                            ?>
                                        </span></li>
                                    <li><strong>Number of Occupants:</strong> <?=$propertyOccupancy?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 contact-info">
                    <!-- Author Info -->
                    <div class="card h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <?php require_once 'includes/landlord-decryption.php'; ?>
                            <img src="<?=$landlordDp?>" alt="Landlord Image" class="img-fluid rounded-circle mb-3" style="height: 260px; width: 300px;">
                            <h4 class="mb-1"><?=$landlordFname?> <?=$landlordLname?></h4>
                            <p class="text-muted mb-3" style="color: #000; font-weight: bold; font-size: 20px">Landlord</p>
                            <div class="bg-light p-3 rounded" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border: 1px solid #e2eaee; border-radius: 10px; padding: 20px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="mb-3">Contact Information:</h5>
                                        <div class="contact-details">
                                            <p class="mb-2"><strong>Email:</strong> <?=$landlord['landlord_email']?></p>
                                            <p class="mb-2"><strong>Contact Number:</strong> <?=$landlord['landlord_contact']?></p>
                                            <p class="mb-2"><strong>Address:</strong> <?=$decryptedAddress?></p>
                                        </div>
                                        <button type="button" class="btn btn-primary text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary mt-3" data-toggle="modal" data-target="#landlordReviewModal">
                                            <i class="fas fa-message"></i> Leave a Review
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal for leaving a landlord review -->
                <div class="modal fade" id="landlordReviewModal" tabindex="-1" role="dialog" aria-labelledby="landlordReviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title p-3" id="landlordReviewModalLabel">Leave a Review for <?=$decryptedFname?> <?=$decryptedLname?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="landlord-review.php" method="POST">
                                    <div class="form-group">
                                        <label for="reviewDescription">Review</label>
                                        <textarea class="form-control" id="reviewDescription" name="review_description" rows="3"></textarea>
                                    </div>
                                    <input type="hidden" name="landlord_id" value="<?=$landlordId?>">
                                    <input type="hidden" name="property_id" value="<?=$propertyId?>">
                                    <div class="input-group-append justify-content-end">
                                        <button type="submit" class="btn btn-primary text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary">Submit Review</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
    <!-- IMAGE AREA END -->

    <!-- SHOP DETAILS AREA START -->
    <div class="ltn__shop-details-area py-5" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h4>From Our Gallery</h4>
                    <div class="ltn__property-details-gallery mb-30">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?=$path?>" data-rel="lightcase:myCollection">
                                    <img class="mb-30" src="<?=$path?>" alt="Image">
                                </a>
                            </div>
                        </div>
                    </div>

                    <h4>Property Video</h4>
                    <div class="ltn__video-bg-img ltn__video-popup-height-500 bg-overlay-black-50 bg-image mb-60" data-bg="<?= $property['property_vid'] ?>">
                        <video width="100%" height="100%" controls data-rel="lightcase:myCollection">
                            <source src="<?= $pathVid?>" type="video/mp4">
                            
                            <i class="fa fa-play"></i>
                        </video>
                    </div>

                    <!-- Map -->
                    <div class="mb-4">
                        <h4>Location</h4>
                        <?php if (!empty($mapboxUrl)): ?>
                            <p style="font-size: 20px;"><?php echo $encodedAddress; ?></p>
                            <div class="property-details-google-map mb-60">
                                <!-- Securely embed the Mapbox map using an iframe -->
                                <div id="map" style="width: 100%; height: 400px;">
                                    <iframe width="100%" height="400" src="about:blank" id="mapboxIframe" title="Mapbox Map" style="border: none;"></iframe>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-15 mt-5">
                        <div class="card p-4 shadow-lg">
                            <h4 class="mb-4">Tenant Reviews</h4>

                            <?php if (!empty($reviewCount)): ?>
                                <ul class="list-unstyled">
                                    <?php if (!empty($tenantReview)):?>
                                    <?php require_once 'includes/tenant-review-decryption.php' ?>
                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="<?= $yourReviewDp ?>" alt="Tenant Image" class="rounded-circle" style="width: 50px;">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6><?= $yourReviewFname . ' ' . $yourReviewLname    ?></h6>
                                                    <p><?= $tenantReview['review_description'] ?></p>
                                                    <small class="text-muted"><?= $formattedDate3 ?></small>
                                                </div>
                                                <div class="ml-auto">
                                                    <a href="#" data-toggle="modal" data-target="#editReviewModal_<?= htmlspecialchars($tenantReview['review_id'])?>" class="text-primary mr-3">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                        <button type="button" class="btn btn-link text-danger" onclick="confirmDelete(<?=$tenantReview['review_id']?>)">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endif; ?>
                                    <?php foreach ($reviews as $review): ?>
                                        <?php
                                        require 'includes/review-decryption.php';
                            
                                        ?>

                                        <li class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="<?= $reviewTenantDp ?>" alt="Tenant Image" class="rounded-circle" style="width: 50px;">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6><?= $reviewTenantFname . ' ' . $reviewTenantLname ?></h6>
                                                    <p><?= $review['review_description'] ?></p>
                                                    <small class="text-muted"><?= $formattedDate4 ?></small>
                                                </div>
                                            </div>
                                        </li>

                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">No reviews available for this property.</p>
                            <?php endif; 
                            require_once 'includes/tenant-decryption.php';
                            ?>
                            <?php if(!isset($tenant['property_id'])):?>
                            <?php else :?>
                            
                            <!-- Add Review -->
                            <hr>
                            <h4 class="mb-3">Add a Review</h4>
                            <form id="review-form" method="POST">
                                <div class="form-group">
                                    <textarea class="form-control" id="reviewDescription" name="review_description" rows="3" placeholder="Write your review..."></textarea>
                                    <!-- <div id="error-description" class="error-message" style ="display: none;"></div> -->
                                </div>
                                <input type="hidden" id="tenantId" name="tenant_id" value="<?= $tenant['tenant_id'] ?>">
                                <input type="hidden" id="propertyId" name="property_id" value="<?= $property['property_id'] ?>">
                                <div class="input-group-append justify-content-end">
                                    <button type="submit" class="btn btn-primary mt-2 text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary">Submit Review</button>
                                </div>
                            </form>
                            <?php endif;?>
                        </div>
                    </div>

                    <!-- Edit Review Modal -->
                        <div class="modal fade" id="editReviewModal_<?= htmlspecialchars($tenantReview['review_id'])?>" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editReviewForm<?= htmlspecialchars($tenantReview['review_id']) ?>" onsubmit="submitUpdatedReview(event, <?= $tenantReview['review_id'] ?>)">
                                            <div class="form-group">
                                                <label for="updatedDescription">Updated Review Description:</label>
                                                <textarea class="form-control" id="updatedDescription" name="updated_description" rows="3"><?= $tenantReview['review_description'] ?></textarea>
                                                <input type="hidden" id="reviewIdInput_<?= htmlspecialchars($tenantReview['review_id']) ?>" name="review_id" value="<?= htmlspecialchars($tenantReview['review_id']) ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-lg-4">
                    <?php 
                    if (!isset($tenant['property_id'])): 
                    ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4>Request Property Viewing</h4>
                                <form id='booking-form' method="post">
                                    <div class="form-group">
                                        <input id="tenant-name" type="text" class="form-control mb-2" name="yourname" value="<?=$tenantFname?> <?=$tenantLname?>" placeholder="Your name">
                                        <input id="tenant-email" type="text" class="form-control mb-2" name="youremail" value="<?=$tenant['tenant_email']?>" placeholder="Your email">
                                        <input id="tenant-date" type="date" class="form-control mb-2" name="booking_date" placeholder="Select a date" required min="<?=$minDate?>">
                                        <textarea id="tenant-message" class="form-control mb-2" name="booking_message" placeholder="Write a message (optional)"></textarea>
                                        <button type="submit" class="btn btn-primary btn-block text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-primary">Request Viewing</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php 
                    endif;
                    ?>
                    <!-- Report Form -->
                    <div class="card">
                        <div class="card-body">
                            <h4>Report this landlord</h4>
                            <form action="report.php?id=<?=$propertyId?>&landlordId=<?=$landlordId?>" method="post">
                                <textarea class="form-control mb-2" name="yourmessage" placeholder="Write a message"></textarea>
                                <button type="submit" class="btn btn-danger btn-block text-white font-weight-bold py-2 px-4 rounded-pill shadow-sm bg-danger">Send Report</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SHOP DETAILS AREA END -->
    
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
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.js"></script>
    <script src="js/plugins.js"></script>
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
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/review.js"></script>
    <script src="js/submit-review.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/back-button.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/mail.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>