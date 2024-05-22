// Function to handle opening the edit review modal
function editReview(reviewId) {
    var currentDescription = $(`#reviewDescription_${reviewId}`).text().trim();

    // Populate the modal fields with the current review data
    $(`#updatedDescription`).val(currentDescription);
    $(`#reviewIdInput_${reviewId}`).val(reviewId);

    // Show the modal
    $(`#editReviewModal_${reviewId}`).modal('show');
}

    function submitUpdatedReview(event, reviewId) {
        event.preventDefault(); // Prevent default form submission
        var reviewDescriptionInput = document.getElementById("updatedDescription");

        var formData = new FormData(); // 'this' refers to the form element
        formData.append('updated_description', reviewDescriptionInput.value);
                // Perform Fetch API request to delete review
                fetch('edit-review.php?id='+ reviewId, {
                    method:'POST',
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
                        displaySweetAlert("Review edited successfully", data.success, "success", "#6EC6FF", "property-details.php");
                        
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    displaySweetAlert("Error", "An error occurred. Please try again.", "error", "#6EC6FF", null);
                });



        // Perform AJAX request to update the review

    }

function confirmDelete(reviewId) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform Fetch API request to delete review
            fetch('delete-review.php?id='+ reviewId, {
                method: 'DELETE',
            })
            .then(response => response.json())
            .then(data => {
                // Check if there's an error
                if (data.error) {
                    // Display server-side error
                    displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
                } else if (data.success) {
                    // Display success message
                    displaySweetAlert("Review deleted successfully", data.success, "success", "#6EC6FF", "property-details.php");
                    
                }
            })
            .catch(error => {
                console.error('Error:', error);
                displaySweetAlert("Error", "An error occurred. Please try again.", "error", "#6EC6FF", null);
            });
        }
    });
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