document.addEventListener("DOMContentLoaded", function() {
    // DOM elements for change password form
    var currentPasswordInput = document.getElementById("current-password");
    var newPasswordInput = document.getElementById("new-password");
    var confirmPasswordInput = document.getElementById("confirm-password");

    // Error elements for change password form
    var currentPasswordError = document.getElementById("error-currentpassword");
    var newPasswordError = document.getElementById("error-newpassword");
    var confirmPasswordError = document.getElementById("error-confirmpassword");

    // Form submission event listener for change password
    document.getElementById("changepassword-form").addEventListener("submit", function(event) {
        event.preventDefault();

        // Clear previous error messages
        clearAllErrorMessages();

        // Validate form inputs
        if (!validateForm()) {
            return;
        }

        // Get form data
        var formData = new FormData();
        formData.append('current-password', currentPasswordInput.value);
        formData.append('new-password', newPasswordInput.value);
        formData.append('confirm-password', confirmPasswordInput.value);

        // Submit the form data via fetch to change password PHP endpoint
        fetch('includes/change-password.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
            } else if (data.success) {
                displaySweetAlert("Password changed successfully", data.success, "success", "#6EC6FF");
            } else {
                // Handle unexpected response format
                throw new Error('Unexpected response from server');
            }
        })
        .catch(console.error);
    });

    // Function to clear all error messages
    function clearAllErrorMessages() {
        var errorElements = document.querySelectorAll(".error-message");
        errorElements.forEach(function(element) {
            element.textContent = "";
        });
    }

    currentPasswordInput.addEventListener("input", function () {
        var currentPassword = currentPasswordInput.value;
        if (!currentPassword) {
            displayErrorMessage(currentPasswordError, "Current password is required");
        } else if (currentPassword.length < 8) {
            displayErrorMessage(currentPasswordError, "Your password must be at least 8 characters long.");
        } else if (!/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(currentPassword)) {
            displayErrorMessage(currentPasswordError, "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*).");
        } else {
            hideErrorMessage(currentPasswordError);
        }
    });

    newPasswordInput.addEventListener("input", function () {
        var newPassword = newPasswordInput.value;
        if (!newPassword) {
            displayErrorMessage(newPasswordError, "New password is required");
        } else if (newPassword.length < 8) {
            displayErrorMessage(newPasswordError, "Your password must be at least 8 characters long.");
        } else if (!/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(newPassword)) {
            displayErrorMessage(newPasswordError, "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*).");
        } else {
            hideErrorMessage(newPasswordError);
        }
    });

    confirmPasswordInput.addEventListener("input", function () {
        var confirmPassword = confirmPasswordInput.value;
        var newPassword = newPasswordInput.value;

        if (!confirmPassword) {
            displayErrorMessage(confirmPasswordError, "Confirm Password is required");
        } else if (newPassword !== confirmPassword) {
            displayErrorMessage(confirmPasswordError, "Passwords do not match");
        } else if (confirmPassword.length < 8) {
            displayErrorMessage(confirmPasswordError, "Your password must be at least 8 characters long.");
        } else if (!/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(confirmPassword)) {
            displayErrorMessage(confirmPasswordError, "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*).");
        } else {
            hideErrorMessage(confirmPasswordError);
        }
    });

    // Function to validate form inputs
    function validateForm() {
        var isValid = true;

        // Validate current password
        var currentPassword = currentPasswordInput.value;
        if (!currentPassword) {
            displayErrorMessage(currentPasswordError, "Current password is required");
            isValid = false;
        } else if (currentPassword.length < 8) {
            displayErrorMessage(currentPasswordError, "Your password must be at least 8 characters long.");
            isValid = false;
        } else if (!/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(currentPassword)) {
            displayErrorMessage(currentPasswordError, "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*).");
            isValid = false;
        }

        // Validate new password
        var newPassword = newPasswordInput.value;
        if (!newPassword) {
            displayErrorMessage(newPasswordError, "New password is required");
            isValid = false;
        } else if (newPassword.length < 8) {
            displayErrorMessage(newPasswordError, "Your password must be at least 8 characters long.");
            isValid = false;
        } else if (!/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(newPassword)) {
            displayErrorMessage(newPasswordError, "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*).");
            isValid = false;
        }

        // Validate confirm password
        var confirmPassword = confirmPasswordInput.value;
        if (!confirmPassword) {
            displayErrorMessage(confirmPasswordError, "Confirm Password is required");
            isValid = false;
        } else if (confirmPassword.length < 8) {
            displayErrorMessage(confirmPasswordError, "Your password must be at least 8 characters long.");
            isValid = false;
        } else if (!/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(confirmPassword)) {
            displayErrorMessage(confirmPasswordError, "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*).");
            isValid = false;
        } else if (newPassword !== confirmPassword) {
            displayErrorMessage(confirmPasswordError, "Passwords do not match");
            isValid = false;
        }

        return isValid;
    }

    // Function to display error message
    function displayErrorMessage(element, message) {
        element.textContent = message;
        element.style.display = "block";
    }

    // Function to hide error message
    function hideErrorMessage(element) {
        element.textContent = "";
        element.style.display = "none";
    }

    // Function to display SweetAlert
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
});