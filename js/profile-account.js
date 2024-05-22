document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;

    // Check if there's already an 'editProfileSectionOpen' value in localStorage
    const isEditProfileSectionOpen = localStorage.getItem('editProfileSectionOpen');
    const editProfileSection = document.getElementById("editProfileSection");

    // Modify the modal display based on the 'editProfileSectionOpen' value
    if (isEditProfileSectionOpen === "true") {
        openEditProfileSection();
    }

    // Event listener for the "Edit Information" button
    const editProfileBtn = document.getElementById("editProfileBtn");
    editProfileBtn.addEventListener("click", function (event) {
        openEditProfileSection();
        event.preventDefault();
    });

    // Event listener for canceling the edit
    const cancelEditBtn = document.getElementById("cancelEditBtn");
    cancelEditBtn.addEventListener("click", function () {
        localStorage.setItem('editProfileSectionOpen', "false");
        closeEditProfileSection();
    });

    function openEditProfileSection() {
        localStorage.setItem('editProfileSectionOpen', "true");
        editProfileSection.style.display = "block";
        body.classList.add('modal-open');
    }

    function closeEditProfileSection() {
        localStorage.setItem('editProfileSectionOpen', "false");
        editProfileSection.style.display = "none";
        body.classList.remove('modal-open');
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const uploadImageButton = document.getElementById("upload-photo-button");
    const profileImageInput = document.getElementById("edit-profile-image");
    const uploadedImage = document.getElementById("uploaded-image");

    // Add event listener to the upload button
    uploadImageButton.addEventListener("click", function () {
        profileImageInput.click(); // Trigger click on file input
    });

    // Add event listener to the file input field
    profileImageInput.addEventListener("change", function () {
        displayProfilePicture(); // Call the displayProfilePicture function
    });
});

function displayProfilePicture() {
    const input = document.getElementById('edit-profile-image');
    const uploadedImage = document.getElementById('uploaded-image');

    const file = input.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            uploadedImage.src = e.target.result;
            uploadedImage.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        uploadedImage.src = '#';
        uploadedImage.style.display = 'none';
    }
}