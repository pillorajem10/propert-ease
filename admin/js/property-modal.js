function openPropertyModal (propertyId){
    fetch('property_modal.php?id='+ propertyId, {
        method : 'GET',
    })
    .then(response => response.text())
    .then(data =>{
        console.log(data);
        $(".ownership-image").html(data);
        $("#propertyReviewModal").modal("show");
    })

}

// Event listener for modal close
$('#propertyModal').on('hidden.bs.modal', function () {
    // Blur the file when the modal is closed
    document.getElementById('fileAttachment').style.filter = "blur(20px)";
    // Show the view buttons
    document.getElementById('viewFileButton').style.display = "inline-block";
});

const viewDocu = document.getElementById('viewFileButton');

viewDocu.addEventListener('click', viewFileProperty());

// Function to view the file
function viewFileProperty(fileId, buttonId) {
    const file = document.getElementById(fileId);
    const viewButton = document.getElementById(buttonId);

    // Unblur the file
    file.style.filter = "blur(0)";

    // Hide the view button
    viewButton.style.display = "none";
}

function hideFileProperty(fileId, buttonId) {
    const file = document.getElementById(fileId);
    const viewButton = document.getElementById(buttonId);

    // Unblur the file
    file.style.filter = "blur(20px)";

    // Hide the view button
    viewButton.style.display = "inline-block";
}