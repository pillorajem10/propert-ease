document.addEventListener("DOMContentLoaded", function () {
    const payNowBtn = document.getElementById("payNowBtn");
    const viewReceiptBtn = document.getElementById("viewReceiptBtn");
    const paymentReceiptModal = document.getElementById("paymentReceiptModal");
    // const viewReceiptModal = document.getElementById("viewReceiptModal");
    const pdfIframe = document.getElementById("pdfIframe");
    const exitBtn = document.getElementById("exitBtn");
    const exitReceiptBtn = document.getElementById("exitBtn");
    const downloadBtn = document.getElementById("downloadBtn");

    viewReceiptBtn.addEventListener("click", function () {
        // Display the payment receipt modal
        showModal('viewReceiptModal');

        // Load the PDF into the iframe
        loadPDF();
    });

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

    exitReceiptBtn.addEventListener("click", function () {
        // Hide the modal when the "Exit" button is clicked
        viewReceiptModal.style.display = "none";
    });

    downloadBtn.addEventListener("click", function () {
        // Trigger the download by setting the iframe source as a data URI
        downloadBtn.href = pdfIframe.src;
    });

    


});

function showModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function showPaymentDetailsSection() {
    hideAllSections();
    document.getElementById('paymentDetailsSection').classList.add('show-section');
}

function showPaymentConfirmationSection() {
    hideAllSections();
    document.getElementById('paymentConfirmationSection').classList.add('show-section');
}

function showPaymentSuccessfulSection() {
    hideAllSections();
    document.getElementById('paymentSuccessfulSection').classList.add('show-section');
}

function showPaymentReceiptSection() {
    hideAllSections();
    document.getElementById('paymentReceiptSection').classList.add('show-section');
}

function hideAllSections() {
    var sections = document.getElementsByClassName('modal-section');
    for (var i = 0; i < sections.length; i++) {
        sections[i].classList.remove('show-section');
    }
}

function selectPaymentMethod(paymentMethod) {
    // Hide the payment method selection and show the corresponding payment details section
    hideAllSections();
    document.getElementById(paymentMethod + 'DetailsSection').classList.add('show-section');
}

function cancelPayment() {
    // Hide the modal when the "Cancel" button is clicked
    closeModal('paymentReceiptModal');
    
    // Redirect back to payment-management.php
    window.location.href = 'payment-management.php';
}

function loadPDF(pdfUrl) {
    const pdfIframe = document.getElementById("pdfIframe");

    // Set the source of the iframe to load the PDF
    pdfIframe.src = pdfUrl;
}

function showPDFPreview1() {
    var fileInput = document.getElementById('receiptInput');
    var file = fileInput.files[0];
    var pdfPreview = document.getElementById('pdfPreview');
    var pdfViewer = document.getElementById('pdfViewer');
    var alertMessage = document.getElementById('alertMessage');
    var submitButton = document.getElementById('submitButton');

    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function() {
                var MAX_WIDTH = 250;
                var MAX_HEIGHT = 235;
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                var width = img.width;
                var height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }

                canvas.width = width;
                canvas.height = height;

                ctx.drawImage(img, 0, 0, width, height);

                pdfViewer.src = canvas.toDataURL('image/jpeg', 0.7);
                pdfPreview.style.display = 'block';
                pdfPreview.style.textAlign = 'center';
                pdfPreview.style.display = 'flex';
                pdfPreview.style.justifyContent = 'center';
                alertMessage.style.display = 'none';
                submitButton.style.marginTop = '-8rem';
            };
        };

        reader.readAsDataURL(file);
    } else {
        pdfPreview.style.display = 'none';
        alertMessage.style.display = 'block'; // Show alert message if no file is selected

        // Remove margin bottom from the button container
        submitButton.style.marginBottom = '0';
    }
}

function showPDFPreview2() {
    var fileInput = document.getElementById('receiptInput');
    var file = fileInput.files[0];
    var pdfPreview = document.getElementById('pdfPreview');
    var pdfViewer = document.getElementById('pdfViewer');
    var alertMessage = document.getElementById('alertMessage');
    var submitButton = document.getElementById('submitButton');

    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function() {
                var MAX_WIDTH = 250;
                var MAX_HEIGHT = 235;
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                var width = img.width;
                var height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }

                canvas.width = width;
                canvas.height = height;

                ctx.drawImage(img, 0, 0, width, height);

                pdfViewer.src = canvas.toDataURL('image/jpeg', 0.7);
                pdfPreview.style.display = 'block';
                pdfPreview.style.textAlign = 'center';
                pdfPreview.style.display = 'flex';
                pdfPreview.style.justifyContent = 'center';
                alertMessage.style.display = 'none';
                submitButton.style.marginTop = '-8rem';
            };
        };

        reader.readAsDataURL(file);
    } else {
        pdfPreview.style.display = 'none';
        alertMessage.style.display = 'block'; // Show alert message if no file is selected

        // Remove margin bottom from the button container
        submitButton.style.marginBottom = '0';
    }
}

function uploadReceipt(event) {
    var fileInput = document.getElementById('receiptInput');
    var file = fileInput.files[0];

    if (!file) {
        // Prevent form submission if no file is selected
        event.preventDefault();
        var alertMessage = document.getElementById('alertMessage');
        alertMessage.style.display = 'block'; // Show alert message if no file is selected
    }
}