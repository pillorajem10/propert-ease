$(document).ready(function () {
  // Trigger the loaded class to apply animation after page load
  $("#register-page").addClass("loaded");
});

$(document).ready(function () {
  var currentStep = 1;

  // Function to show current step and update progress bar
  function showStep(step) {
    $(".form-step").hide(); // Hide all steps
    $("#step" + step).show(); // Show current step
    $(".progress-step").removeClass("progress-step-active"); // Remove active class from all progress steps
    $(".progress-step")
      .eq(step - 1)
      .addClass("progress-step-active"); // Add active class to current progress step
    $("#progress .progress-bar").css("width", (step - 1) * 33.33 + "%"); // Update progress bar width

    // Check if it's a previous or next step
    if (step < currentStep) {
      // Previous step: Set margin top to 20%
      $(".form-step").css("margin-top", "20%");
    } else {
      // Next step: Maintain margin top at 20%
      $(".form-step").css("margin-top", "20%");
    }
  }

  // Initialize page: Show initial step and hide progress bar
  showStep(currentStep);
  $(".progressbar").hide();

  // Next button click handler
  $(".btn-next").click(function (e) {
    e.preventDefault();
    let fName = document.querySelector("#first-name").value;
    let lName = document.querySelector("#last-name").value;
    let contact = document.querySelector("#contact-number").value;
    let address = document.querySelector("#address").value;
    let email = document.querySelector("#email").value;
    let pass = document.querySelector("#password").value;
    let confirmPass = document.querySelector("#confirm-password").value;
    let role = document.querySelector("#role").value;
    let idType = document.querySelector("#id-type").value;
    let idSerial = ""; //document.querySelector("#id-serial").value
    let validId = document.querySelector("#valid-id").value;
    let selfieId = document.querySelector("#selfie-id").value;
    console.log(formStepsNum);
    if (selfieId && validId && idSerial && idType && formStepsNum == 3) {
      // Check if there are any visible error messages in the current step
      var errorMessages = $("#step" + currentStep + " .error-message:visible");
      if (errorMessages.length > 0) {
        return; // Stop further execution if there are visible error messages
      }

      if (currentStep < 4) {
        // Check if it's not the last step
        currentStep++; // Increment current step
        showStep(currentStep); // Show next step
        $(".progressbar").show(); // Show progress bar
      }
    } else if (role && confirmPass && pass && email && formStepsNum == 2) {
      // Check if there are any visible error messages in the current step
      var errorMessages = $("#step" + currentStep + " .error-message:visible");
      if (errorMessages.length > 0) {
        return; // Stop further execution if there are visible error messages
      }

      if (currentStep < 4) {
        // Check if it's not the last step
        currentStep++; // Increment current step
        showStep(currentStep); // Show next step
        $(".progressbar").show(); // Show progress bar
      }
    } else if (address && contact && formStepsNum == 1) {
      // Check if there are any visible error messages in the current step
      var errorMessages = $("#step" + currentStep + " .error-message:visible");
      if (errorMessages.length > 0) {
        return; // Stop further execution if there are visible error messages
      }

      if (currentStep < 4) {
        // Check if it's not the last step
        currentStep++; // Increment current step
        showStep(currentStep); // Show next step
        $(".progressbar").show(); // Show progress bar
      }
    } else if (fName && lName && formStepsNum == 0) {
      // Check if there are any visible error messages in the current step
      var errorMessages = $("#step" + currentStep + " .error-message:visible");
      if (errorMessages.length > 0) {
        return; // Stop further execution if there are visible error messages
      }

      if (currentStep < 4) {
        // Check if it's not the last step
        currentStep++; // Increment current step
        showStep(currentStep); // Show next step
        $(".progressbar").show(); // Show progress bar
      }
    }
  });

  // Previous button click handler
  $(".btn-prev").click(function (e) {
    e.preventDefault();
    if (currentStep > 1) {
      // Check if it's not the first step
      currentStep--; // Decrement current step
      showStep(currentStep); // Show previous step
      $(".progressbar").show(); // Show progress bar
    }
  });
});

// Function for multi-step form with progress bar
const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");
const agreeCheckbox = document.getElementById("agree-checkbox");
const termsLink = document.querySelector('a[href="terms.html"]');

let formStepsNum = 0;

nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    let fName = document.querySelector("#first-name").value;
    let lName = document.querySelector("#last-name").value;
    let contact = document.querySelector("#contact-number").value;
    let address = document.querySelector("#address").value;
    let email = document.querySelector("#email").value;
    let pass = document.querySelector("#password").value;
    let confirmPass = document.querySelector("#confirm-password").value;
    let role = document.querySelector("#role").value;
    let idType = document.querySelector("#id-type").value;
    let idSerial = document.querySelector("#serial-id").value
    let validId = document.querySelector("#valid-id").value;
    let selfieId = document.querySelector("#selfie-id").value;
    console.log(formStepsNum);
    if (selfieId && validId && idSerial && idType && formStepsNum == 3) {
      if (!agreeCheckbox.checked && formStepsNum === 3) {
        showTermsAgreement();
        return;
      }
      formStepsNum++;
      updateFormSteps();
      updateProgressbar();
    } else if (role && confirmPass && pass && email && formStepsNum == 2) {
      if (!agreeCheckbox.checked && formStepsNum === 3) {
        showTermsAgreement();
        return;
      }
      formStepsNum++;
      updateFormSteps();
      updateProgressbar();
    } else if (address && contact && formStepsNum == 1) {
      if (!agreeCheckbox.checked && formStepsNum === 3) {
        showTermsAgreement();
        return;
      }
      formStepsNum++;
      updateFormSteps();
      updateProgressbar();
    } else if (fName && lName && formStepsNum == 0) {
      if (!agreeCheckbox.checked && formStepsNum === 3) {
        showTermsAgreement();
        return;
      }
      formStepsNum++;
      updateFormSteps();
      updateProgressbar();
    }
  });
});

prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {

    
    formStepsNum--;
    updateFormSteps();
    updateProgressbar();
  });
});

function updateFormSteps() {
  formSteps.forEach((formStep) => {
    formStep.style.display = "none";
  });

  formSteps[formStepsNum].style.display = "block";
}

function updateProgressbar() {
  progressSteps.forEach((progressStep, idx) => {
    progressStep.classList.remove("progress-step-active");
    if (idx <= formStepsNum) {
      progressStep.classList.add("progress-step-active");
    }
  });

  const progressActive = document.querySelectorAll(".progress-step-active");

  progress.style.width =
    ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
}

function showTermsAgreement(event) {
  const agreeCheckbox = document.getElementById("agree-checkbox");

  // Prevent the default action of the anchor tag (prevent navigating to '#')
  event.preventDefault();

  // Show confirmation dialog with SweetAlert
  Swal.fire({
    title: "Terms and Conditions",
    text: "Do you agree to the Terms and Conditions?",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceed only if the checkbox is checked
      if (agreeCheckbox.checked) {
        // Open terms.html in a new tab
        window.open("terms.html", "_blank");
      } else {
        // Show warning if checkbox is not checked
        Swal.fire({
          title: "Terms and Conditions",
          text: "Please check the Terms and Conditions box to proceed.",
          icon: "warning",
          confirmButtonText: "OK",
        });
      }
    } else {
      // Action cancelled (No button clicked)
      // Optionally display a message or perform other actions
      Swal.fire({
        title: "Action Cancelled",
        text: "You have cancelled the action.",
        icon: "info",
        confirmButtonText: "OK",
      });
    }
  });
}

// DOM elements
var firstNameInput = document.getElementById("first-name");
var lastNameInput = document.getElementById("last-name");
var contactNumberInput = document.getElementById("contact-number");
var addressInput = document.getElementById("address");
var emailInput = document.getElementById("email");
var passwordInput = document.getElementById("password");
var confirmPasswordInput = document.getElementById("confirm-password");
var roleInput = document.getElementById("role");
var idTypeInput = document.getElementById("id-type");
var serialInput = document.getElementById("serial-id");
var validInput = document.getElementById("valid-id");
var selfieInput = document.getElementById("selfie-id");
var agreeChecked = document.getElementById("agree-checkbox");

// Error elements
var firstNameError = document.getElementById("error-fname");
var lastNameError = document.getElementById("error-lname");
var contactNumberError = document.getElementById("error-contact");
var addressError = document.getElementById("error-address");
var emailError = document.getElementById("error-email");
var passwordError = document.getElementById("error-password");
var confirmPasswordError = document.getElementById("error-confirmpassword");
var roleError = document.getElementById("error-role");
var idTypeError = document.getElementById("error-type");
var serialError = document.getElementById("error-serial");
var validError = document.getElementById("error-valid");
var selfieError = document.getElementById("error-selfie");
var serialError = document.getElementById("error-serial");
var checkboxError = document.getElementById("error-checkmark");

// Form submission event listener
document
  .getElementById("register-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    // Clear previous error messages
    clearAllErrorMessages();

    // Get form data
    var formData = new FormData();
    formData.append("first-name", firstNameInput.value);
    formData.append("last-name", lastNameInput.value);
    formData.append("contact-number", contactNumberInput.value);
    formData.append("address", addressInput.value);
    formData.append("email", emailInput.value);
    formData.append("password", passwordInput.value);
    formData.append("confirm-password", confirmPasswordInput.value);
    formData.append("role", roleInput.value);
    formData.append("id-type", idTypeInput.value);
    formData.append("serial-id", serialInput.value);
    formData.append("agree-checkbox", agreeChecked.value);
    formData.append("valid-id", validInput.files[0]);
    formData.append("selfie-id", selfieInput.files[0]);

    // Validate form inputs
    if (!validateForm()) {
      return; // Stop further execution
    }

    // If all validations pass, submit the form
    fetch("register.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        // Check if there's an error
        console.log(data);
        if (data.error) {
          // Display server-side error
          displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
        } else if (data.success) {
          // Display success message
          displaySweetAlert(
            "Registration Success",
            data.success,
            "success",
            "#6EC6FF",
            "verification.php"
          );
        } else if (data.firstNameErr) {
          displayErrorMessage(firstNameError, data.firstNameErr);
        } else if (data.lastNameErr) {
          displayErrorMessage(lastNameError, data.lastNameErr);
        } else if (data.contactNumberErr) {
          displayErrorMessage(contactNumberError, data.contactNumberErr);
        } else if (data.addressErr) {
          displayErrorMessage(addressError, data.addressErr);
        } else if (data.emailErr) {
          displayErrorMessage(emailError, data.emailErr);
        } else if (data.passwordErr) {
          displayErrorMessage(passwordError, data.passwordErr);
        } else if (data.confirmPasswordErr) {
          displayErrorMessage(confirmPasswordError, data.confirmPasswordErr);
        } else if (data.roleErr) {
          displayErrorMessage(roleError, data.roleErr);
        } else if (data.idTypeErr) {
          displayErrorMessage(idTypeError, data.typeErr);
        } else if (data.serialErr) {
          displayErrorMessage(serialError, data.serialErr);
        } else if (data.validErr) {
          displayErrorMessage(validError, data.validErr);
        } else if (data.selfieErr) {
          displayErrorMessage(selfieError, data.selfieErr);
        } else if (data.agreeErr) {
          displayErrorMessage(checkboxError, data.agreeErr);
        }
      })
      .catch(console.error);
  });

// Function to clear all error messages
function clearAllErrorMessages() {
  var errorElements = document.querySelectorAll(".error-message");
  errorElements.forEach(function (element) {
    element.textContent = "";
  });
}

firstNameInput.addEventListener("input", function () {
  var firstName = firstNameInput.value;
  if (!firstName) {
    displayErrorMessage(firstNameError, "First Name is required.");
  } else {
    hideErrorMessage(firstNameError);
  }
});

lastNameInput.addEventListener("input", function () {
  var lastName = lastNameInput.value;
  if (!lastName) {
    displayErrorMessage(lastNameError, "Last Name is required.");
  } else {
    hideErrorMessage(lastNameError);
  }
});

contactNumberInput.addEventListener("input", function () {
  var contactNumber = contactNumberInput.value;
  if (!contactNumber) {
    displayErrorMessage(contactNumberError, "Contact Number is required.");
  } else {
    hideErrorMessage(contactNumberError);
  }
});

addressInput.addEventListener("input", function () {
  var address = addressInput.value;
  if (!address) {
    displayErrorMessage(addressError, "Address is required");
  } else {
    hideErrorMessage(addressError);
  }
});

emailInput.addEventListener("input", function () {
  var email = emailInput.value;
  if (!email) {
    displayErrorMessage(emailError, "Email is required");
  } else {
    hideErrorMessage(emailError);
  }
});

roleInput.addEventListener("input", function () {
  var role = roleInput.value;
  if (!role) {
    displayErrorMessage(roleError, "Role is required");
  } else {
    hideErrorMessage(roleError);
  }
});

idTypeInput.addEventListener("input", function () {
  var type = idTypeInput.value;
  if (!type) {
    displayErrorMessage(idTypeError, "Type of valid id is required");
  } else {
    hideErrorMessage(idTypeError);
  }
});

serialInput.addEventListener("input", function () {
  var serial = serialInput.value;
  if (!serial) {
    displayErrorMessage(
      serialError,
      "For security purposes, you must type your serial number"
    );
  } else {
    hideErrorMessage(serialError);
  }
});

passwordInput.addEventListener("input", function () {
  var password = passwordInput.value;
  if (!password) {
    displayErrorMessage(passwordError, "Password is required");
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

confirmPasswordInput.addEventListener("input", function () {
  var confirmPassword = confirmPasswordInput.value;
  var password = passwordInput.value;

  if (!confirmPassword) {
    displayErrorMessage(confirmPasswordError, "Confirm Password is required");
  } else if (password !== confirmPassword) {
    displayErrorMessage(confirmPasswordError, "Passwords do not match");
  } else if (confirmPassword.length < 8) {
    displayErrorMessage(
      confirmPasswordError,
      "Your password must be at least 8 characters long."
    );
  } else if (
    !/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(confirmPassword)
  ) {
    displayErrorMessage(
      confirmPasswordError,
      "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*)."
    );
  } else {
    hideErrorMessage(confirmPasswordError);
  }
});

validInput.addEventListener("input", function () {
  var valid = validInput.files[0];
  if (!valid) {
    displayErrorMessage(
      validError,
      "For security purposes, you must upload your valid id"
    );
  } else {
    hideErrorMessage(validError);
  }
});

selfieInput.addEventListener("input", function () {
  var selfie = validInput.files[0];
  if (!selfie) {
    displayErrorMessage(
      selfieError,
      "For security purposes, you must upload your selfie picture with your valid id"
    );
  } else {
    hideErrorMessage(selfieError);
  }
});

agreeChecked.addEventListener("input", function () {
  var agree = agreeChecked.checked;
  if (!agree) {
    displayErrorMessage(checkboxError, "Checkmark is required");
  } else {
    hideErrorMessage(checkboxError);
  }
});
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

  // Validate role
  if (!roleInput.value) {
    displayErrorMessage(roleError, "Role is required");
    isValid = false;
  }

  // Validate type of id
  if (!idTypeInput.value) {
    displayErrorMessage(idTypeError, "Type of valid i is required");
    isValid = false;
  }

  // Validate serial number
  if (!serialInput.value) {
    displayErrorMessage(
      serialError,
      "For security purposes, you must type your serial number"
    );
    isValid = false;
  }

  // Validate password
  var password = passwordInput.value;
  if (!password) {
    displayErrorMessage(passwordError, "Password is required");
    isValid = false;
  } else if (password.length < 8) {
    displayErrorMessage(
      passwordError,
      "Your password must be at least 8 characters long."
    );
    isValid = false;
  } else if (!/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(password)) {
    displayErrorMessage(
      passwordError,
      "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*)."
    );
    isValid = false;
  }

  // Validate password confirmation
  var confirmPassword = confirmPasswordInput.value;
  if (!confirmPassword) {
    displayErrorMessage(confirmPasswordError, "Confirm Password is required");
    isValid = false;
  } else if (confirmPassword.length < 8) {
    displayErrorMessage(
      confirmPasswordError,
      "Your password must be at least 8 characters long."
    );
    isValid = false;
  } else if (
    !/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])/.test(confirmPassword)
  ) {
    displayErrorMessage(
      confirmPasswordError,
      "Your password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*)."
    );
    isValid = false;
  }

  // Check if password matches confirmation
  if (passwordInput.value !== confirmPasswordInput.value) {
    displayErrorMessage(confirmPasswordError, "Passwords do not match");
    isValid = false;
  }

  // Validate valid id
  if (!validInput.files[0]) {
    displayErrorMessage(
      validError,
      "For security purposes, you must upload your valid id"
    );
    isValid = false;
  } else {
    // Validate file extension
    var allowedExtensions = ["jpg", "jpeg", "png", "gif", "jfif"];
    var fileExt = validInput.files[0].name.split(".").pop().toLowerCase();
    if (!allowedExtensions.includes(fileExt)) {
      displayErrorMessage(
        validError,
        "Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF, JFIF"
      );
      isValid = false;
    }
  }

  // Validate selfie id
  if (!selfieInput.files[0]) {
    displayErrorMessage(
      selfieError,
      "For security purposes, you must upload your selfie picture with your valid id"
    );
    isValid = false;
  } else {
    // Validate file extension
    var allowedExtensions = ["jpg", "jpeg", "png", "gif", "jfif"];
    var fileExt = selfieInput.files[0].name.split(".").pop().toLowerCase();
    if (!allowedExtensions.includes(fileExt)) {
      displayErrorMessage(
        selfieError,
        "Invalid file format. Accepted formats: JPG, JPEG, PNG, GIF, JFIF"
      );
      isValid = false;
    }
  }

  // Validate agreement checkbox
  if (!agreeChecked.checked) {
    displayErrorMessage(checkboxError, "Checkmark is required");
    isValid = false;
  }

  return isValid;
}

// Function to display error message
function displayErrorMessage(element, message) {
  element.innerHTML = '<span style="color: red;">' + message + "</span>";
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
    timer: 1500,
  }).then(() => {
    if (redirectUrl) {
      window.location.href = redirectUrl;
    }
  });
}