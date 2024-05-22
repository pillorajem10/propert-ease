$(document).ready(function() {
    $('.card-link').hover(
        function() {
            $(this).find('.contact-address-item').addClass('shadow-lg');
        },
        function() {
            $(this).find('.contact-address-item').removeClass('shadow-lg');
        }
    );
    $('.card-link').click(function(event) {
        event.preventDefault();
    });
});

// DOM elements
var nameInput = document.getElementById("name");
var emailInput = document.getElementById("email");
var phoneInput = document.getElementById("phone");
var messageInput = document.getElementById("message");
var saveInfoCheckbox = document.getElementById("agree");

// Error elements
var nameErr = document.getElementById("error-name");
var emailErr = document.getElementById("error-email");
var phoneErr = document.getElementById("error-phone");
var messageErr = document.getElementById("error-message");

// Check local storage for saved user info
window.addEventListener("DOMContentLoaded", function () {
    var savedUserInfo = localStorage.getItem("savedUserInfo");

    if (savedUserInfo) {
        var userInfo = JSON.parse(savedUserInfo);

        // Populate form fields with saved user info
        nameInput.value = userInfo.name;
        emailInput.value = userInfo.email;
        phoneInput.value = userInfo.phone;
        messageInput.value = userInfo.message;

        // Check the save info checkbox
        saveInfoCheckbox.checked = true;
    }
});

document.getElementById("contact-form").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData();

    formData.append('name', nameInput.value);
    formData.append('email', emailInput.value);
    formData.append('phone', phoneInput.value);
    formData.append('message', messageInput.value);

    // Save user info to local storage if checkbox is checked
    if (saveInfoCheckbox.checked) {
        var userInfo = {
            name: nameInput.value,
            email: emailInput.value,
            phone: phoneInput.value,
            message: messageInput.value
        };

        localStorage.setItem("savedUserInfo", JSON.stringify(userInfo));
    } else {
        // Clear saved user info if checkbox is not checked
        localStorage.removeItem("savedUserInfo");
    }

    // If all validations pass, check for tenant details and submit the form
    fetch('contact_email.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            // Display server-side error
            displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
        } else if (data.success) {
            // Display success message
            displaySweetAlert("Message sent successfully!", data.success, "success", "#6EC6FF", "contact.php");
        }
    })
    .catch(error => {
        // Handle fetch request errors
        console.error('Error:', error);
        displaySweetAlert("Error", "Failed to submit the form. Please try again later.", "error", "#6EC6FF", null);
    });

    // Check if all form fields are empty
    if (!nameInput.value && !emailInput.value && !phoneInput.value && !messageInput.value) {
        // Display tenant details not found error
        displaySweetAlert("Error", "Your details not found. Please fill in the form.", "error", "#6EC6FF", null);
    }
});

// Function to clear all error messages
function clearAllErrorMessages() {
    var errorElements = document.querySelectorAll(".error-message");
    errorElements.forEach(function(element) {
        element.textContent = "";
    });
}

    // Validate name
    nameInput.addEventListener("input", function () {
        var name = nameInput.value;
        if (!name) {
            displayErrorMessage(nameErr, "Fullname is required");
        } else {
            hideErrorMessage(nameErr);
        }
    });

    // Validate email
    emailInput.addEventListener("input", function () {
        var email = emailInput.value;
        if (!email) {
            displayErrorMessage(emailErr, "Email is required");
        } else {
            hideErrorMessage(emailErr);
        }
    });

    // Validate phone
    phoneInput.addEventListener("input", function () {
        var phone = phoneInput.value;
        if (!phone) {
            displayErrorMessage(phoneErr, "Contact number is required");
        } else {
            hideErrorMessage(phoneErr);
        }
    });

    // Validate message
    messageInput.addEventListener("change", function () {
        var message = messageInput.value;
        if (!message) {
            displayErrorMessage(messageErr, "Message is required");
        } else {
            hideErrorMessage(messageErr);
        }
    });
  

// Function to validate form inputs
function validateForm() {
    var isValid = true;

    // Perform individual validations
    if (!nameInput.value) {
        displayErrorMessage(nameErr, "Fullname is required");
        isValid = false;
    }

    if (!emailInput.value) {
        displayErrorMessage(emailErr, "Email is required");
        isValid = false;
    }

    if (!phoneInput.value) {
        displayErrorMessage(phoneErr, "Contact number is required");
        isValid = false;
    }

    if (!messageInput.value) {
        displayErrorMessage(messageErr, "Message is required");
        isValid = false;
    }

    return isValid;
}

// Function to display error message
function displayErrorMessage(element, message) {
    element.innerHTML = '<span style="color: red;">' + message + '</span>';
    element.style.display = "block"; // Show the error message
}

function hideErrorMessage(element) {
    element.innerHTML = "";
    element.style.display = "none"; // Hide the error message
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