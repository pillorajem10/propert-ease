// Event listener for modal close
$('#landlordModal').on('hidden.bs.modal', function () {
  // Blur the images when the modal is closed
  document.getElementById('landlordProfile').style.filter = "blur(10px)";
  // Show the view button
  document.getElementById('viewLandlordProfileButton').style.display = "inline-block";
});

// Function to view the photo
function viewPhoto(imageId, buttonId) {
  const image = document.getElementById(imageId);
  const viewButton = document.getElementById(buttonId);

  // Unblur the image
  image.style.filter = "blur(0)";

  // Hide the view button
  viewButton.style.display = "none";
}

$(document).ready(function(){
    $('button[name="landlord_modal"]').click(function(){
  id_emp = $(this).attr('id')
        $.ajax({url: "landlord_modal.php",
        method:'post',
        data:{emp_id:id_emp},
         success: function(result){
    $(".modal-body").html(result);
  }});


        $('#landlordModal').modal("show");
    })
})