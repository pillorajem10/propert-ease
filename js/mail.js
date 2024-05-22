var nameInput = document.getElementById("tenant-name");
var emailInput = document.getElementById("tenant-email");
var dateInput = document.getElementById("tenant-date");
var messageInput = document.getElementById("tenant-message");

document.getElementById("booking-form").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData();

    formData.append('yourname', nameInput.value); 
    formData.append('youremail', emailInput.value);
    formData.append('booking_date', dateInput.value);
    formData.append('booking_message', messageInput.value);

    Swal.fire({
        target: "body",
        icon: "question",
        title: "Confirmation",
        text: "Are you sure you want to book this property?",
        showCancelButton: true,
        confirmButtonText: "Confirm",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
                fetch('mail.php', {
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
                            displaySweetAlert("Booking Success", data.success, "success", "#6EC6FF", "property-details.php");
                        }
                    })
                    .catch(console.error);
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