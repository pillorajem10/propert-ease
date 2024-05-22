document.getElementById("gcash-paid").addEventListener("submit", function (event) {
    event.preventDefault();


    Swal.fire({
        title: 'Confirm Payment?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            fetch('gcash-process.php', {
                method: 'PUT',
                })
                .then(response => response.json())
                .then(data => {
                    // Check if there's an error
                    if (data.error) {
                        // Display server-side error
                        displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
                    }else if (data.success) {
                      displaySweetAlert("Success", data.success, "success", "#6EC6FF", "payment-management.php");
                    }
                })
                .catch(error => {
                    displaySweetAlert("Error", error, "error", "#6EC6FF", null);
                });
        } 
    });
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