// Function to populate the modal with data
function showReceivePaymentDetails(tenantId) {
    fetch('receive_modal.php?id='+ tenantId, {
      method : 'GET',
  })
  .then(response => response.text())
  .then(data =>{
      $("#receive-card").html(data);
      $("#receiveModal").modal("show");
  })
  }

  function showPaymentForm() {
    document.getElementById('gcash-form').style.display = 'none';
    document.getElementById('payment-form').style.display = 'block';
}

function confirmPayment(tenantId) {


    Swal.fire({
        title: 'Proceed to Payment',
        text: 'Are you sure you want to proceed',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
    fetch('receive-process.php?id='+ tenantId, {
        method : 'PUT',
    })
    .then(response => response.json())
    .then(data =>{
        if (data.error) {
            // Display server-side error
            displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
        } else if (data.warning) {
            // Display server-side warning
            displaySweetAlert("Warning", data.warning, "warning", "#6EC6FF", null);
        } else if (data.success) {
            // Display success message
            displaySweetAlert("Success", data.success, "success", "#6EC6FF", 'dashboard.php');
            // setTimeout(function() {
            //     // window.close();
            // }, 1500);
        }
    })
} 
});
}

function cancelPayment(){
    displaySweetAlert("Transaction Canceled", "Returning to Dashboard", "error", "#6EC6FF", "dashboard.php");
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