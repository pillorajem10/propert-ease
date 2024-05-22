// Function to populate the modal with data
function showReviewDetails(tenantId) {
    fetch('review_modal.php?id='+ tenantId, {
      method : 'GET',
  })
  .then(response => response.text())
  .then(data =>{
      $("#review-card").html(data);
      $("#tenantReviewModal").modal("show");
  })
  }