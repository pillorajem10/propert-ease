<?php
require_once 'includes/gcash-function.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propert-Ease</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- logo icon image/x-icon  -->
	<link rel ="icon" href="img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/gcash.css" type="text/css">
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
                        <label class="label-input">Property Purchased: <span id="propertyname" class="field"><?=$property?></span></label><br>
                    </div>
                    <div class="form-group">
                        <label class="label-input">Amount to pay: <span id="amount" class="field"><?=$subTotal?></span></label><br>
                    </div>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" onclick="showPaymentForm()">Next</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="payment-form" id="payment-form" style="display: none;">
            <h2 class="payment-title">Pay with GCash</h2>
            <form id="gcash-paid" method = "post">
                <div class="form-content">
                    <div class="form-group">
                        <label class="label-input">Tenant Name:</label>
                        <span id="gcashname" class="field"><?=$tenantName?></span></label><br>
                    </div>
                    <div class="form-group">
                        <label class="label-input">You are about to pay:</label>
                        <span id="price" class="field"><?=$subTotal?></span></label><br>
                    </div>
                    <div class="form-group">
                        <hr class="headerline">
                    </div>
      
                    <div class="form-group">
                        <p class="description">Please review to ensure that the details are correct before you proceed.</p>
                    </div>
                </div>
                <div class="paymentform-body">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Pay <span id="price"></span></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="gcash-column gray">
            <div class="footer-container" style="position: absolute; margin-bottom: 50%;">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/payment-form.js"></script>
    <script src="js/gcash.js"></script>
</body>
</html>