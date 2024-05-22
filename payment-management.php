<?php
session_start();
require_once('connect.php');
require_once('includes/payment-function.php');
?>

<!doctype html>
<html class="no-js" lang="zxx">
<style>
#pdfPreview {
    max-width: 100%;
    height: auto;
}
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Propert-Ease</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Include Bootstrap CSS, jQuery, and Popper.js -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>

    <!-- logo icon image/x-icon  -->
	<link rel ="icon" href="img/icon.png" type="image/x-icon">
    <!-- Font Icons css -->
    <link rel="stylesheet" href="css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="css/plugins.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/payment-management.css">
    <link rel="stylesheet" href="css/modal.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
<!-- Body main wrapper start -->
<div class="body-wrapper">
    <!-- COOKIES AREA START -->

    <!-- COOKIES AREA END -->

    <!-- HEADER AREA START (header-5) -->
    <?php
    require_once 'header.php';
    ?>
    <!-- HEADER AREA END -->

    <div class="ltn__utilize-overlay" style="display: none;"></div>

    <div class="body-container">
        <!-- Navigation and Page Title -->
        <div class="container-fluid bg-primary py-4">
            <div class="container">
                <h1 class="page-title text-center text-white mt-2">Payment Management</h1>
            </div>
        </div>

        <!-- Payment Details Section -->
        <div class="container mt-5">
            <div class="card shadow-sm rounded border-0">
                <div class="card-body">
                    <!-- View Property Button -->
                    <div class="text-center mb-4">
                        <div class="view-btn">
                            <a href="#">
                                <ul>
                                    <button onclick="propertySelect(<?=$propertyId?>)" >
                                        <li><h4>View Property</h4></li>
                                    </button>
                                </ul>
                            </a>
                        </div>
                    </div>

                    <h2 class="text-center mb-4">Payment Details</h2>
                    <?php
                    require_once 'includes/property-decryption.php';
                    require_once 'includes/landlord-decryption.php';
                    ?>
                    <!-- Property Image -->
                    <div class="text-center mb-4">
                        <img src="<?= isset($property['property_img']) && !empty($property['property_img']) ? $path : 'img/white-background.jpg' ?>" alt="Property Image" class="img-fluid property-image mx-auto d-block" style="width: 500px; height: 300px;">
                    </div>

                    <!-- Payment Information -->
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <p class="label"><strong>Property:</strong> <?= isset($property['property_name']) ? $propertyName : 'Unknown Property' ?></p>
                            <p class="label"><strong>Property Type:</strong> <?= isset($property['property_type']) ? $property['property_type'] : 'Unknown Type' ?></p>
                            <p class="label"><strong>Location:</strong> <?= isset($property['property_brgy']) ? $propertyBrgy : 'Unknown Location' ?></p>
                        </div>
                        <div class="col-lg-6">
                            <p class="label"><strong>Pay Rate:</strong> Php <?= isset($property['property_price']) ? $propertyPrice. ' per ' . ($property['property_due'] === 30 ? 'month' : '2 weeks') : 'Unknown pay rate' ?></p>
                            <p class="label"><strong>Due Date:</strong> <?= $newDueDate ?></p>
                            <p class="label"><strong>Tenant Name:</strong> <?= $fname ?> <?= $lname ?></p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="nav-buttons text-center">
                        <?php if ($tenant['unique_id']!=NULL):?>
                            <button id="viewReceiptBtn" class="btn btn-primary btn-lg" onclick="generateReceipt('viewReceiptModal')">View Receipt</button>
                        <?php endif;?>
                        <?php if ($tenant['tenant_status']!="Requesting Exit"):?>
                            <?php if($tenant['tenant_status']="paid"):?>
                            <button id="payNowBtn" class="btn btn-primary btn-lg" onclick="showModal('paymentReceiptModal')">Pay Rent</button>
                                
                            <?php else:?>
                            <button class="btn btn-primary btn-lg" disabled>Processing Payment</button>
                            <?php endif;?>
                            <button class="btn btn-danger btn-lg" onclick="requestExit()">Request for Exit</button>
                        <?php else:?>
                            <button class="btn btn-danger btn-lg" onclick="cancelExit()">Cancel Exit</button>
                            
                        <?php endif;?>
                            

                        
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>

        <!-- Modal for Payment -->
        <div id="paymentReceiptModal" class="modal">
            <div class="modal-content">
                <button type="button" class="close mr-n1 mt-n1" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                    <span aria-hidden="true" class="close-icon" id="exitBtn" onclick="closeModal('paymentReceiptModal')">&times;</span>
                </button>
                <div id="paymentMethodSection" class="modal-section show-section p-4">
                    <h2 class="text-center mb-4">Select Payment Method</h2>
                    <div class="payment-method-options d-grid gap-3">
                        <div class="btn btn-primary payment-button d-flex flex-column align-items-center justify-content-center p-3" onclick="selectPaymentMethod('gcash')">
                            <img src="img/gcash-logo.png" alt="GCash" class="mb-2">
                            <span class="fw-bold">GCash</span>
                        </div>
                        <div class="btn btn-primary payment-button d-flex flex-column align-items-center justify-content-center p-3" onclick="selectPaymentMethod('onhand')">
                            <img src="img/peso-logo.png" alt="Onhand Cash" class="mb-2">
                            <span class="fw-bold">Cash</span>
                        </div>
                    </div>
                </div>
                <div id="gcashDetailsSection" class="modal-section p-4" style="background-color: #007FFF; width: 109.8%; height: 150vh; margin-left: -4.85%;">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center mb-4">
                                <img src="img/gcash-logo.png" class="img-fluid" alt="GCash Logo" style="width: 50%; max-height: 100px;">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <h2 class="text-center mb-4">Upload GCash Payment Receipt</h2>
                                <form id="gcashPaymentForm" enctype="multipart/form-data" method="post" >
                                    <div class="mb-3">
                                        <h6 class="text-center mb-4">Amount to pay: Php <?=$propertyPrice?></h6>
                                        <h6 class="text-center mb-4">Landlord Gcash: <?=$landlordNum?></h6>
                                        <label for="receiptInput" class="form-label">Choose File</label>
                                        <input type="file" class="form-control" id="receiptInput" name="receipt" required onchange="showPDFPreview1()">
                                    </div>
                                    <div id="alertMessage" class="alert alert-danger" role="alert" style="display: none;">
                                        No attachment uploaded. Please choose a file.
                                    </div>
                                    <div id="pdfPreview" class="mb-3" style="display: none;">
                                        <embed id="pdfViewer" src="#" type="application/pdf" width="100%" height="400px" />
                                    </div>
                                    <div class="d-grid gap-2" id="submitButton">
                                        <button type="submit" class="btn btn-primary mb-3">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="onhandDetailsSection" class="modal-section p-4" style="background-color: #FFA500; width: 109.8%; height: 150vh; margin-left: -4.85%;">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center mb-4">
                                <img src="img/peso-logo.png" class="img-fluid" alt="Cash Logo" style="width: 50%; max-height: 200px;">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <h2 class="text-center mb-4">Upload Cash Payment Receipt</h2>

                                <form id="onhandPaymentForm" enctype="multipart/form-data" method="post" onsubmit="closeModal('paymentReceiptModal')">
                                    <div class="mb-3">
                                        <h6 class="text-center mb-4">Amount to pay: Php <?=$propertyPrice?></h6>
                                        <label for="onhandReceipt" class="form-label">Choose File</label>
                                        <input type="file" class="form-control" id="receiptInput" name="receipt" required onchange="showPDFPreview2()">
                                    </div>
                                    <div id="alertMessage" class="alert alert-danger" role="alert" style="display: none;">
                                        No attachment uploaded. Please choose a file.
                                    </div>
                                    <div id="pdfPreview" class="mb-3" style="display: none;">
                                        <embed id="pdfViewer" src="#" type="application/pdf" width="100%" height="400px" />
                                    </div>
                                    <div class="d-grid gap-2" id="submitButton">
                                        <button type="submit" class="btn btn-primary mb-5" onclick="closeModal('paymentReceiptModal')">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Confirmation Section -->
                <div id="paymentConfirmationSection" class="modal-section" style="border: 2px solid rgba(0, 128, 128, 0.7); background-color: rgba(0, 128, 128, 0.2); height: 100vh;">
                    <h2>Confirmation</h2>
                    <p>Do you want to proceed with the payment for your booked rental property?</p>
                    <div class="nav-buttons" style="display: flex; justify-content: center; margin-top: 20px;">
                        <button class="confirm-button" onclick="showPaymentSuccessfulSection()" style="margin-right: 5px;">Yes</button>
                        <button class="cancel-button" onclick="cancelPayment()" style="margin-left: 5px;">Cancel</button>
                    </div>
                </div>
                <!-- Payment Successful Section -->
                <div id="paymentSuccessfulSection" class="modal-section" style="border: 2px solid rgba(0, 128, 128, 0.7); background-color: rgba(0, 128, 128, 0.2); height: 100vh;">
                    <h2>Payment Successful</h2>
                    <p>Your payment has been successfully approved by the landlord.</p>
                    <div class="nav-buttons">
                        <button class="next-button" onclick="showPaymentReceiptSection()">Next</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Payment Receipt -->
        <div id="viewReceiptModal" class="modal">
            <div class="modal-content">
                <button type="button" class="close mr-n1 mt-n1" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                    <span aria-hidden="true" class="close-icon" id="exitBtn" onclick="closeModal('viewReceiptModal')">&times;</span>
                </button>
                <!-- Payment Receipt Section -->
                <div id="paymentReceiptSection" class="modal-section show-section">
                    <div class="modal-header">
                        <h2>Payment Receipt</h2>
                    </div>
                    <div class="modal-body">
                        <iframe id="pdfIframe" width="100%" height="500"></iframe>
                        <a id="downloadBtn" class="btn btn-primary" style="margin-top: 1%;" download="payment-receipt.pdf">Download Receipt</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/rental-button.js"></script>
    <script src="js/view-button.js"></script>
    <!-- <script src="js/receipt-modal.js"></script> -->
    <script src="js/generate-receipt.js"></script>
    <script src="js/request-exit.js"></script>
    <script src="js/payment-function.js"></script>
    <!-- <script src="js/upload.js"></script> -->
    <script src="js/cookies.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/payment.js"></script>
    <!-- <script src="js/reciept-funtcion.js"></script> -->
    <script src="js/property-id.js"></script>
    <script src="js/hover.js"></script>
</body>
</html>