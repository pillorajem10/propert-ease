<?php
require_once('../connect.php');
require_once('includes/security.php');
require_once('includes/receive-payment-process.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propert-Ease</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Logo icon -->
    <link rel="icon" href="img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/receive-payment.css" type="text/css">
</head>
<body>
    <div class="gcash-container">
        <div class="gcash-column blue">
            <div class="gcash-logo">
                <img class="logo" src="img/gcash.png" alt="logo">
            </div>
        </div>
        <div class="gcash-form" id="gcash-form">
            <form id="gcash" enctype="multipart/form-data">
                <div class="form-content">
                    <div class="form-group">
                        <label class="label-input">Property Booked: <span id="propertyname" class="field"><?=$propertyName?></span></label><br>
                    </div>
                    <div class="form-group">
                        <label class="label-input">Paid by: <span id="tenantname" class="field"><?=$tenantFname.' '.$tenantLname?></span></label><br>
                    </div>
                    <div class="form-group">
                        <label class="label-input">Amount to Receive: <span id="amount" class="field"><?=$transaction_total?></span></label><br>
                    </div>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" onclick="showPaymentForm()">Proceed to Receive Payment</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="payment-form" id="payment-form" style="display: none;">
            <h2 class="payment-title">Receive Payment</h2>
            <form>
                <div class="form-content">
                    <div class="form-group">
                        <label class="label-input">Tenant's Name:</label>
                        <span id="tenantname" class="field"><?=$tenantFname.' '.$tenantLname?></span><br>
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <hr class="headerline">
                    </div>
                    <div class="form-group">
                        <label class="label-input"><strong>Total to be Received:</strong></label>
                        <span id="granttotal" class="field"><?=$transaction_total?></span><br>
                    </div>
                    <div class="form-group">
                        <p class="description">Please confirm receipt of payment.</p>
                    </div>
                </div>
                <div class="paymentform-body">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" onclick="confirmPayment(<?=$tenantId?>)">Confirm Payment</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelPayment()">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="gcash-column gray">
            <div class="footer-container" style="position: absolute; margin-bottom: 50%;">
            </div>
        </div>
    </div>
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/receive-payment.js"></script>
</body>
</html>