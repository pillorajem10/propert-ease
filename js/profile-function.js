document.addEventListener("DOMContentLoaded", function() {
    // DOM elements
    var firstNameInput = document.getElementById("edit-fname");
    var lastNameInput = document.getElementById("edit-lname");
    var contactNumberInput = document.getElementById("edit-contact");
    var addressInput = document.getElementById("edit-address");
    var emailInput = document.getElementById("edit-email");
    var profileInput = document.getElementById("edit-profile-image");

    // Error elements
    var firstNameError = document.getElementById("error-fname");
    var lastNameError = document.getElementById("error-lname");
    var contactNumberError = document.getElementById("error-contact");
    var addressError = document.getElementById("error-address");
    var emailError = document.getElementById("error-email");
    var profileError = document.getElementById("error-profile");

    // Profile picture change event listener
    profileInput.addEventListener("change", function() {
        displayProfilePicture(profileInput);
    });

    // Function to handle profile picture changes
    function displayProfilePicture(profileInputElement) {
        var previewContainer = document.getElementById("uploaded-image");
        var previewImage = new Image();

        // Clear previous preview
        previewContainer.src = '';

        // Display selected image
        if (profileInputElement.files && profileInputElement.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.maxWidth = "200px";
                previewContainer.src = previewImage.src;
            };

            reader.readAsDataURL(profileInputElement.files[0]);
        }
    }

    // Form submission event listener
    document.getElementById("edit-profileform").addEventListener("submit", function(event) {
        event.preventDefault();

        // Clear previous error messages
        clearAllErrorMessages();

        // Validate form inputs
        if (!validateForm()) {
            return; // Stop further execution
        }

        // Get form data
        var formData = new FormData();
        formData.append('edit-fname', firstNameInput.value);
        formData.append('edit-lname', lastNameInput.value);
        formData.append('edit-contact', contactNumberInput.value);
        formData.append('edit-address', addressInput.value);
        formData.append('edit-email', emailInput.value);
        formData.append('edit-profile-image', profileInput.files[0]);

        // Submit the form data via fetch
        fetch('includes/profile-function.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
            } else if (data.success) {
                displaySweetAlert("Profile Edit Successfully", data.success, "success", "#6EC6FF", "account.php");
            } else {
                // Handle unexpected response format
                throw new Error('Unexpected response from server');
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            displaySweetAlert("Error", "An unexpected error occurred. Please try again later.", "error", "#6EC6FF", null);
        });
    });

    // Input event listeners for real-time validation
    firstNameInput.addEventListener("input", function() {
        validateInput(firstNameInput, firstNameError, "First Name is required.");
    });

    lastNameInput.addEventListener("input", function() {
        validateInput(lastNameInput, lastNameError, "Last Name is required.");
    });

    contactNumberInput.addEventListener("input", function() {
        validateInput(contactNumberInput, contactNumberError, "Contact Number is required.");
    });

    addressInput.addEventListener("input", function() {
        validateInput(addressInput, addressError, "Address is required.");
    });

    emailInput.addEventListener("input", function() {
        validateInput(emailInput, emailError, "Email is required.");
    });

    profileInput.addEventListener("change", function() {
        validateProfilePicture(profileInput, profileError);
    });

    // Function to validate a single input
    function validateInput(inputElement, errorElement, errorMessage) {
        if (!inputElement.value.trim()) {
            displayErrorMessage(errorElement, errorMessage);
        } else {
            hideErrorMessage(errorElement);
        }
    }

    // Function to validate profile picture
    // function validateProfilePicture(profileInputElement, profileErrorElement) {
    //     if (!profileInputElement.files[0]) {
    //         displayErrorMessage(profileErrorElement, "Profile picture is required.");
    //     } else {
    //         hideErrorMessage(profileErrorElement);
    //     }
    // }

    // Function to clear all error messages
    function clearAllErrorMessages() {
        var errorElements = document.querySelectorAll(".error-message");
        errorElements.forEach(function(element) {
            hideErrorMessage(element);
        });
    }

    // Function to validate form inputs
    function validateForm() {
        var isValid = true;

        // Validate first name
        if (!firstNameInput.value) {
            displayErrorMessage(firstNameError, "First Name is required");
            isValid = false;
        }

        // Validate last name
        if (!lastNameInput.value) {
            displayErrorMessage(lastNameError, "Last Name is required");
            isValid = false;
        }

        // Validate contact number
        if (!contactNumberInput.value) {
            displayErrorMessage(contactNumberError, "Contact Number is required");
            isValid = false;
        }

        // Validate address
        if (!addressInput.value) {
            displayErrorMessage(addressError, "Address is required");
            isValid = false;
        }

        // Validate email
        if (!emailInput.value) {
            displayErrorMessage(emailError, "Email is required");
            isValid = false;
        }

        // Validate profile picture
        if (!profileInput.files[0]) {
            displayErrorMessage(profileError, "Profile picture is required");
            isValid = false;
        } else {
            // Validate file extension
            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
            var fileExt = profileInput.files[0].name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(fileExt)) {
                displayErrorMessage(profileError, "Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF, JFIF");
                isValid = false;
            }
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