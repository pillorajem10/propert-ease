<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propert-Ease</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- logo icon image/x-icon  -->
    <link rel="icon" href="img/icon.png" type="image/x-icon">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/verificationemail-style.css">
    <link rel="stylesheet" href="css/alert.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <div class="container">
        <div class="verificationemail-container">
            <div class="card">
                <div class="logo">
                    <img src="img/logo.png" alt="Logo">
                </div>
                <div class="card-header">Verify Email</div>
                <div class="card-body">
                    <form method="POST" id="verificationemail-form">
                        <div class="form-group">
                            <label for="email" class="form-label">Please enter your email address:</label>
                            <input id="email" type="email" class="form-control" name="email" autocomplete="email">
                            <div id="error-email" class="error-message" style="display: none;"></div>
                        </div>
                        <div class="btns-group">
                            <button type="submit" class="btn btn-primary">Send Reset Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/verification-email.js"></script>
    <script src="js/sw-function.js"></script>
</body>
</html>