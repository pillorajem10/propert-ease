var receipt = document.getElementById("receiptInput");
var onhandreceipt = document.getElementById("onhandReceipt");

document.getElementById("onhandPaymentForm").addEventListener("submit", function (event) {
    event.preventDefault();

    var formData = new FormData();
    formData.append('onhandReceipt', onhandreceipt.files[0]);
    formData.append('method', 'onhand');

    document.getElementById("paymentReceiptModal").style.display = 'none';

    Swal.fire({
        title: 'Proceed to Payment',
        text: 'Are you sure you want to proceed',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            fetch('onhand-process.php', {
                method: 'POST',
                body: formData
                })
                .then(response => response.json())
                .then(data => {
                  console.log(data)
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

document.getElementById("gcashPaymentForm").addEventListener("submit", function (event) {
  event.preventDefault();

  var formData = new FormData();
  formData.append('receipt', receipt.files[0]);
  formData.append('method', 'gcash');

  document.getElementById("paymentReceiptModal").style.display = 'none';

  Swal.fire({
      title: 'Proceed to Payment',
      text: 'Are you sure you want to proceed',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Confirm',
      cancelButtonText: 'Cancel'
  }).then((result) => {
      if (result.value) {
          fetch('gcash-process.php', {
              method: 'POST',
              body: formData
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
