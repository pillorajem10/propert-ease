$(document).ready(function() {
    // Trigger the loaded class to apply animation after page load
    $('#verification-page').addClass('loaded');
});

var verifyEmailInput = document.getElementById("email");
var verifyEmailError = document.getElementById("error-email");

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

document.getElementById("verification-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    var verifyEmail = verifyEmailInput.value;
    
    // Clear previous error messages
    hideErrorMessage(verifyEmailError);

    // Check if verification code is missing
    if (!verifyEmail) {
        displayErrorMessage(verifyEmailError, "Email is missing. Please enter your email.");
        return; // Stop further execution
    }
    var formData = new FormData();
    formData.append('email', verifyEmail);
    // Send the form data to verification.php

    fetch('verif.php',{
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.error) {
            // Display error message for invalid email or other errors
            displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
        } else if (data.success) {
            // Display success message for email verification
            displaySweetAlert("Email Verification Code Sent", data.success, "success", "#6EC6FF", "confirmation.php");
        } else if (data.exist) {
            // Display success message for email verification
            displaySweetAlert("Notice", data.exist, "warning", "#6EC6FF", "confirmation.php");
        }
    })
    .catch(console.error);            
});