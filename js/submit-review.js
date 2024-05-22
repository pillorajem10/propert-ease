
    var reviewDescriptionInput = document.getElementById("reviewDescription");
    var tenantIdInput = document.getElementById("tenantId");
    var propertyIdInput = document.getElementById("propertyId");
    // var reviewDescriptionError = document.getElementById("error-description");

    document.getElementById("review-form").addEventListener("submit", function(event) {
        event.preventDefault();



        // Validate form inputs

        // Get form data
        var formData = new FormData(this); // 'this' refers to the form element
        formData.append('reviewDescription', reviewDescriptionInput.value);
        formData.append('tenant_id', tenantIdInput.value);
        formData.append('property_id', propertyIdInput.value);

        // If all validations pass, submit the form
        Swal.fire({
            target: "body",
            icon: "question",
            title: "Confirmation",
            text: "Submit Review?",
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('review.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Check if there's an error
                    if (data.error) {
                        // Display server-side error
                        displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
                    } else if (data.success) {
                        // Display success message
                        displaySweetAlert("Review added successfully", data.success, "success", "#6EC6FF", "property-details.php");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    displaySweetAlert("Error", "An error occurred. Please try again.", "error", "#6EC6FF", null);
                });
            }
        });
    });

    // // Function to clear all error messages
    // function clearAllErrorMessages() {
    //     reviewDescriptionError.innerHTML = "";
    //     reviewDescriptionError.style.display = "none";
    // }

    // // Function to validate form inputs
    // function validateForm() {
    //     var isValid = true;

    //     // Validate review description
    //     if (!reviewDescriptionInput.value.trim()) {
    //         displayErrorMessage(reviewDescriptionError, "Your review of the property is required.");
    //         isValid = false;
    //     }

    //     return isValid;
    // }

    // // Function to display error message
    // function displayErrorMessage(element, message) {
    //     element.innerHTML = '<span style="color: red;">' + message + '</span>';
    //     element.style.display = "block"; // Show the error message
    // }

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