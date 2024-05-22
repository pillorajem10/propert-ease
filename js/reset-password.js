var verifyCodeInput = document.getElementById("verification_code");
var verifyCodeError = document.getElementById("error-verifycode");

function displayErrorMessage(element, message) {
    element.innerHTML = '<span class="error-message" style="color: red;">' + message + '</span>';
    element.style.display = "block"; // Show the error message
}

function hideErrorMessage(element) {
    element.innerHTML = "";
    element.style.display = "none"; // Hide the error message
}

verifyCodeInput.addEventListener("input", function () {
    var verifyCode = verifyCodeInput.value;
    if (!verifyCode) {
      displayErrorMessage(verifyCodeError, "Verification code is missing. Please enter your verification code.");
    } else {
      hideErrorMessage(verifyCodeError);
    }
  });

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

document.getElementById("resetpassword-form").addEventListener("submit", function(event) {
    event.preventDefault();

    var verifyCode = verifyCodeInput.value;
    var formData = new FormData();
     formData.append('verification_code', verifyCode);

    // Clear previous error messages
    hideErrorMessage(verifyCodeError);

    // Check if verification code is missing
    if (!verifyCode) {
        displayErrorMessage(verifyCodeError, "Verification code is missing. Please enter your verification code.");
        return; // Stop further execution
    }

    fetch('reset-pass.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        // Check if there's an error
        console.log(data);
        if (data.error) {
            displayErrorMessage(verifyCodeError, data.error);
        } else if (data.success) {
            // Display success message for email verification
            displaySweetAlert("Reset Password Successfully", data.success, "success", "#6EC6FF", "login.html");
        } else {
            // Display generic error message for HTTP errors
            displaySweetAlert("Error", "An error occurred while validating the confirmation credentials.", "error", "#6EC6FF", null);
        }
        
      })
      .catch(console.error);
});