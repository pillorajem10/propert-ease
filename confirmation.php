<?php
session_start();
if (!isset($_SESSION['registration_data'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propert-Ease</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- logo icon image/x-icon  -->
    <link rel="icon" href="img/icon.png" type="image/x-icon">
    <!-- Font Icons css -->
    <link rel="stylesheet" href="css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="css/plugins.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/confirmation-style.css">
    <link rel="stylesheet" href="css/alert.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6 col-lg-5 mb-5">
                <div class="content text-center mb-5">
                    <img src="img/propertease-logo.png" alt="Propert-Ease Logo" class="logo">
                    <p class="text-muted">Renting Made Easy</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="container-confirmation p-4" id="confirmation-form-container">
                    <div class="confirmation-label">Confirmation</div>
                    <form method="POST" id="confirmation-form">
                        <div class="form-group">
                            <label for="verification_code" class="form-label">Enter the email verification code:</label>
                            <input id="verification_code" type="text" class="form-control" name="verification_code">
                            <div id="error-verifycode" class="error-message" style ="display: none;"></div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary py-2 px-4 rounded-pill w-50">Confirm</button>
                        </div>
                    </form>                                        
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap, jQuery, and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/confirmation.js"></script>
    <script src="js/sw-function.js"></script>
</body>
</html>