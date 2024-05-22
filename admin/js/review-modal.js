// Sample data for the modal (replace with your actual data)
var landlordReviewReportModalData = {
    comment: "Raising rent without notice.",
};

// Function to populate the modal with data
function showLandlordReviewReport() {
    document.getElementById('comment').innerText = landlordReviewReportModalData.comment;
}