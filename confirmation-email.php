<?php
if (!isset($_SESSION['registration_data'])) {
    header("Location: index.php");
    exit;
}
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
    <link rel="stylesheet" href="css/confirmationemail-style.css">
    <link rel="stylesheet" href="css/alert.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <div class="container">
        <div class="confirmation-container">
            <div class="card">
                <div class="logo">
                    <img src="img/logo.png" alt="Logo">
                </div>
                <div class="card-header">Reset Password Link Confirmation</div>
                <div class="card-body">
                    <form method="POST" id="confirmation-form" enctype="multipart/form-data" >
                        <div class="form-group">
                          <label for="verification_code" class="form-label">Please enter the verification code sent to your email to reset your password:</label>
                          <input id="verification_code" type="text" class="form-control" name="verification_code">
                          <div id="error-verifycode" class="error-message" style ="display: none;"></div>
                        </div>
                        <div class="btns-group">
                          <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/confirmation-email.js"></script>
</body>
</html>