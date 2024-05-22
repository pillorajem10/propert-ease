<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propert-Ease</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Logo icon image/x-icon  -->
    <link rel="icon" href="img/icon.png" type="image/x-icon">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/resetpassword-style.css">
    <link rel="stylesheet" href="css/alert.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <div class="container">
        <div class="resetpassword-container">
            <div class="card">
                <div class="logo">
                    <img src="img/logo.png" alt="Logo">
                </div>
                <div class="card-header">Reset Password</div>
                <div class="card-body">
                  <form method="POST" id="resetpassword-form" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="current-password" class="form-label">Current Password</label>
                          <input id="current-password" type="password" class="form-control" name="current-password">
                          <button class="toggle-currentpassword" type="button" id="toggleCurrentPassword">
                              <i class="fa fa-eye-slash"></i>
                          </button>
                      </div>
                      <div class="form-group">
                          <label for="new-password" class="form-label">New Password:</label>
                          <input id="new-password" type="password" class="form-control" name="new-password">
                          <button class="toggle-newpassword" type="button" id="toggleNewPassword">
                              <i class="fa fa-eye-slash"></i>
                          </button>
                      </div>
                      <div class="form-group">
                          <label for="confirm-newpassword" class="form-label">Confirm New Password:</label>
                          <input id="confirm-newpassword" type="password" class="form-control" name="confirm-newpassword">
                          <button class="toggle-confirmpassword" type="button" id="toggleConfirmPassword">
                              <i class="fa fa-eye-slash"></i>
                          </button>
                          <div id="error-password" class="error-message" style="display: none;"></div>
                      </div>
                      <div class="btns-group">
                          <button type="submit" class="btn btn-primary">Reset Password</button>
                      </div>
                  </form>
              </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/reset-password.js"></script>
    <script src="js/toggle-newpassword.js"></script>
</body>
</html>