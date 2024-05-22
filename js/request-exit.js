function requestExit() {
  Swal.fire({
    title: "Do you want to exit?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      // Send an AJAX request to delete_review.php with the review_id
      fetch('request-exit.php', {
          method: 'PUT',
      })
      .then(response => response.json())
      .then(data => {
            if (data.error) {
                // Display server-side error
                displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
            } else if (data.success) {
                // Display success message
                displaySweetAlert("Success", data.success, "success", "#6EC6FF", "payment-management.php");
            }
      })
      .catch(error => {
          console.error('Error:', error);
          Swal.fire('Error!', 'An unexpected error occurred.', 'error');
      });
  }
  });
}

function cancelExit() {
  Swal.fire({
    title: "Do you want to cancel exit request?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('cancel-exit.php', {
          method: 'PUT',
      })
      .then(response => response.json())
      .then(data => {
            if (data.error) {
                // Display server-side error
                displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
            } else if (data.success) {
                // Display success message
                displaySweetAlert("Success", data.success, "success", "#6EC6FF", "payment-management.php");
            }
      })
      .catch(error => {
          console.error('Error:', error);
          Swal.fire('Error!', 'An unexpected error occurred.', 'error');
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