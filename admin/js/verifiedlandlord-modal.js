// Sample data for the modal (replace with your actual data)
var verifiedLandlordModalData = {
    type: "Valid ID",
    serialNum: "1234",
    pictureId: "img/landlord-id.jpg",
    selfiePicId: "img/landlord-id.jpg",
};

// Function to populate the modal with data
function showVerifiedLandlord() {
    document.getElementById('proofType').innerText = verifiedLandlordModalData.type;
    document.getElementById('serialNum').innerText = verifiedLandlordModalData.serialNum;

    // Set the picture of id dynamically
    var idPicture = document.getElementById('idPicture');
    idPicture.src = verifiedLandlordModalData.pictureId;
    idPicture.alt = verifiedLandlordModalData.type + ' pictureId';

    // Set the selfie picture of id dynamically
    var selfieId = document.getElementById('selfieId');
    selfieId.src = verifiedLandlordModalData.selfiePicId;
    selfieId.alt = verifiedLandlordModalData.type + ' selfieId';
}

// Event listener for modal close
$('#verifiedLandlordModal').on('hidden.bs.modal', function () {
    // Blur the images when the modal is closed
    document.getElementById('idPicture').style.filter = "blur(10px)";
    document.getElementById('selfieId').style.filter = "blur(10px)";
    // Show the view buttons
    document.getElementById('viewIdButton').style.display = "inline-block";
    document.getElementById('viewSelfieButton').style.display = "inline-block";
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