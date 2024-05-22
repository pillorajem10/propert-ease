document.addEventListener("DOMContentLoaded", function () {
  const payNowBtn = document.getElementById("payNowBtn");
  const paymentReceiptModal = document.getElementById("paymentReceiptModal");
  const pdfIframe = document.getElementById("pdfIframe");
  const exitBtn = document.getElementById("exitBtn");

  payNowBtn.addEventListener("click", function () {
      // Display the modal
      paymentReceiptModal.style.display = "block";

      // Load the PDF into the iframe
      loadPDF();
  });

  exitBtn.addEventListener("click", function () {
      // Hide the modal when the "Exit" button is clicked
      paymentReceiptModal.style.display = "none";
  });

  function loadPDF() {
      // Use AJAX to fetch the PDF content from generate-receipt.php
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
              // Parse the JSON response
              const response = JSON.parse(xhr.responseText);

              // Set the PDF content to the iframe source
              pdfIframe.src = 'data:application/pdf;base64,' + response.pdfContent;
          }
      };

      // Make a POST request to generate-receipt.php
      xhr.open("POST", "generate-receipt.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      // Replace this with the actual form data you want to send
      const formData = new FormData();
      formData.append('order_btn', 1);
      formData.append('fullname', 'John');
      formData.append('location', 'Some Location');
      formData.append('pay_rate', '$50.00/hour');
      formData.append('due_date', '2023-12-01');
      formData.append('sub_total', '$800.00');
      formData.append('vat', '$80.00');
      formData.append('total_amount', '$880.00');
      formData.append('method', 'CreditCard');

      xhr.send(formData);
  }
});