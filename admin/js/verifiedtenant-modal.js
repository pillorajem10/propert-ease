// Sample data for the modal (replace with your actual data)
var verifiedTenantModalData = {
    type: "Valid ID",
    serialNum: "1234",
    pictureId: "img/tenant-id.jpg",
    selfiePicId: "img/tenant-id.jpg",
};

// Function to populate the modal with data
function showVerifiedTenant() {
    document.getElementById('tenantProofType').innerText = verifiedTenantModalData.type;
    document.getElementById('tenantSerialNum').innerText = verifiedTenantModalData.serialNum;

    // Set the picture of id dynamically
    var tenantPicId = document.getElementById('tenantPicId');
    tenantPicId.src = verifiedTenantModalData.pictureId;
    tenantPicId.alt = verifiedTenantModalData.type + ' tenantPicId';

    // Set the selfie picture of id dynamically
    var tenantSelfieId = document.getElementById('tenantSelfieId');
    tenantSelfieId.src = verifiedTenantModalData.selfiePicId;
    tenantSelfieId.alt = verifiedTenantModalData.type + ' tenantSelfieId';
}

// Event listener for modal close
$('#verifiedTenantModal').on('hidden.bs.modal', function () {
    // Blur the images when the modal is closed
    document.getElementById('tenantPicId').style.filter = "blur(10px)";
    document.getElementById('tenantSelfieId').style.filter = "blur(10px)";
    // Show the view buttons
    document.getElementById('viewTenantIdButton').style.display = "inline-block";
    document.getElementById('viewTenantSelfieButton').style.display = "inline-block";
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