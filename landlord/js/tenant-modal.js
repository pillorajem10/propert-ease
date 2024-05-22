// Function to populate the modal with data
function showPendingTenantDetails(pendingId) {
  fetch('pending_modal.php?id='+ pendingId, {
    method : 'GET',
})
  .then(response => response.text())
  .then(data =>{

      $("#tenant-review").html(data);
      $("#pendingModal").modal("show");
  })
}

function openRejectModal(pendingId) {
  document.getElementById('pendingId').value = pendingId;
  $('#rejectModal').modal('show');
}