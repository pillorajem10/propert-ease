$(document).ready(function() {
  // Trigger the loaded class to apply animation after page load
  $('#login-page').addClass('loaded');
});

var emailInput = document.getElementById("email");
var passwordInput = document.getElementById("password");
var emailError = document.getElementById("error-email");
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

emailInput.addEventListener("input", function () {
  var email = emailInput.value;
  if (!email) {
    displayErrorMessage(emailError, "Email is required");
  } else {
    const emailPattern = /^[\w\.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailPattern.test(email)) {
      displayErrorMessage(emailError, 'Please enter a valid email address');
  } else {
      hideErrorMessage(emailError);
    }
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

  var email = emailInput.value;
  var password = passwordInput.value;

  // Clear previous error messages

  if (!validateForm()) {
    return; // Stop further execution
}

  

  // If all validations pass, submit the form
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "login.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response.error) {
        displaySweetAlert("Error", response.error, "error", "#6EC6FF", null);
        // Display server-side errors directly
      } else if (response.emailErr) {
          displayErrorMessage(emailError, response.emailErr);
        } else if (response.passwordErr) {
          displayErrorMessage(passwordError, response.passwordErr);
      } else if (response.success) {
        displaySweetAlert("Login Success", response.success, "success", "#6EC6FF", "index.php");
      } else if (response.verify) {
        displaySweetAlert("Error", response.verify, "error", "#6EC6FF", "verification.php");
      } else if (response.banned || response.notfound) {
        displaySweetAlert("Error", response.banned || response.notfound, "error", "#6EC6FF", null);
      }
    } else {
      // Display error message using SweetAlert
      displaySweetAlert("Error", "An error occurred while validating the login credentials.", "error", "#6EC6FF", null);
    }
  };
  var data = "email=" + email + "&password=" + password;
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

// Check if email is missing
if (!emailInput.value) {
    displayErrorMessage(emailError, 'Email is required');
    isValid = false;
} else {
    const emailPattern = /^[\w\.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailPattern.test(emailInput.value)) {
        displayErrorMessage(emailError, 'Please enter a valid email address ');
        isValid = false;
    }
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