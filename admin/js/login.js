$(document).ready(function() {
  // Trigger the loaded class to apply animation after page load
  $('#login-page').addClass('loaded');
});

var usernameInput = document.getElementById("username");
var passwordInput = document.getElementById("password");
var usernameError = document.getElementById("error-username");
var passwordError = document.getElementById("error-password");

function displayErrorMessage(element, message) {
  element.innerHTML = '<span class="error-message" style="color: red;">' + message + '</span>';
  element.style.display = "block"; // Show the error message
}

function hideErrorMessage(element) {
  element.innerHTML = "";
  element.style.display = "none"; // Hide the error message
}

function displaySweetAlert(title, text, icon, confirmButtonColor, redirectUrl) {
  Swal.fire({
    title: title,
    text: text,
    icon: icon,
    confirmButtonColor: confirmButtonColor,
    showConfirmButton: false,
    timer: 1500
  }).then(() => {
    if (redirectUrl) {
      window.location.href = redirectUrl;
    }
  });
}

usernameInput.addEventListener("input", function () {
  var username = usernameInput.value;
  if (!username) {
    displayErrorMessage(usernameError, "Username is missing. Please enter your username.");
  } else {
    hideErrorMessage(usernameError);
  }
});

passwordInput.addEventListener("input", function () {
  var password = passwordInput.value;
  if (!password) {
    displayErrorMessage(passwordError, "Password is missing. Please enter your password.");
  } else if (password.length < 8) {
    displayErrorMessage(
      passwordError,
      "Your password must be at least 8 characters long."
    );
  } else if (!/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(password)) {
    displayErrorMessage(
      passwordError,
      "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*)."
    );
  } else {
    hideErrorMessage(passwordError);
  }
});

document.getElementById("login-form").addEventListener("submit", function (event) {
  event.preventDefault();

      // Clear previous error messages
      clearAllErrorMessages();

  var username = usernameInput.value;
  var password = passwordInput.value;

  // Clear previous error messages

  if (!validateForm()) {
    return; // Stop further execution
}

  

  // If all validations pass, submit the form
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "admin_login.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response.error) {
        displaySweetAlert("Error", response.error, "error", "#6EC6FF", null);
        // Display server-side errors directly
      } else if (response.usernameErr) {
          displayErrorMessage(usernameError, response.usernameErr);
        } else if (response.passwordErr) {
          displayErrorMessage(passwordError, response.passwordErr);
      } else if (response.success) {
        displaySweetAlert("Login Success", response.success, "success", "#6EC6FF", "dashboard.php");
      } else if (response.notfound) {
        displaySweetAlert("Error", response.notfound, "error", "#6EC6FF", null);
      }
    } else {
      // Display error message using SweetAlert
      displaySweetAlert("Error", "An error occurred while validating the login credentials.", "error", "#6EC6FF", null);
    }
  };
  var data = "username=" + username + "&password=" + password;
  xhr.send(data);
});

function clearAllErrorMessages() {
  var errorElements = document.querySelectorAll(".error-message");
  errorElements.forEach(function(element) {
      element.textContent = "";
  });
}

function validateForm() {
  var isValid = true;

// Check if username is missing
if (!usernameInput.value) {
  displayErrorMessage(usernameError, "Username is missing. Please enter your username.");
  isValid = false;
}

// Check if password is missing
if (!passwordInput.value) {
  displayErrorMessage(passwordError, "Password is missing. Please enter your password.");
  isValid = false;
} else if (passwordInput.value.length < 8) {
  displayErrorMessage(
    passwordError,
    "Your password must be at least 8 characters long."
  );
  isValid = false;
} else if (!/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(passwordInput.value)) {
  displayErrorMessage(
    passwordError,
    "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*)."
  );
  isValid = false;
}

  return isValid;

}