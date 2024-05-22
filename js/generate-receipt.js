// Function to fetch and display receipt in modal
function generateReceipt() {
    fetch('generate-receipt.php', { method: 'GET' })
    .then(response => response.json())
    .then(data => {
        if (data.pdfContent) {
            document.querySelector('#pdfIframe').src = `data:application/pdf;base64,${data.pdfContent}`;
            document.getElementById('viewReceiptModal').style.display = 'block';
        } else if (data.error){
            console.log(data.error);
        } else {
            console.error('Error: PDF content not received.');
        }
    })
    .catch(error => console.error('Error fetching receipt:', error));
}

// Function to trigger receipt download using iframe source
function downloadReceipt() {
    var iframeSrc = $('#pdfIframe').attr('src');
    if (iframeSrc) {
        var downloadLink = document.getElementById('downloadBtn');
        downloadLink.href = iframeSrc;
        downloadLink.download = 'payment-receipt.pdf';
        downloadLink.click();
    } else {
        console.error('Error: PDF source not found.');
    }
}

