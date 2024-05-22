function showImages() {
    var imageInput = document.getElementById('propertyImage');
    var imageList = document.getElementById('imageList');
    var images = imageInput.files;

    // Clear previous images
    imageList.innerHTML = '<li class="form-text text-muted"><label>Image Requirement:</label><p>At least 1 image is required for a valid submission. Minimum size is 500/500px.</p></li>';

    // Display new images
    for (var i = 0; i < images.length; i++) {
        var imageItem = document.createElement('li');
        imageItem.className = 'form-text text-muted';
        var image = document.createElement('img');
        image.src = URL.createObjectURL(images[i]);
        image.alt = 'Image ' + (i + 1);
        image.style.maxWidth = '200px';  // Set a max width to prevent large images
        image.style.maxHeight = '200px'; // Set a max height to prevent large images
        image.style.margin = '10px'; // Add some margin for better spacing

        var label = document.createElement('label');
        label.textContent = 'Image ' + (i + 1) + ':';

        imageItem.appendChild(label);
        imageItem.appendChild(image);
        imageList.appendChild(imageItem);
    }
}

function showVideos() {
    var videoInput = document.getElementById('propertyVideo');
    var videoList = document.getElementById('videoList');
    var videos = videoInput.files;

    // Clear previous videos
    videoList.innerHTML = '<label for="propertyVideo">Listing Video:</label>';

    // Display new videos
    for (var i = 0; i < videos.length; i++) {
        var videoItem = document.createElement('li');
        videoItem.className = 'form-text text-muted';
        var video = document.createElement('video');
        video.width = 320;
        video.height = 240;
        video.controls = true;
        var source = document.createElement('source');
        source.src = URL.createObjectURL(videos[i]);
        source.type = 'video/mp4';
        video.appendChild(source);
        video.textContent = 'Your browser does not support the video tag.';
        videoItem.appendChild(document.createElement('label')).textContent = 'Video ' + (i + 1) + ':';
        videoItem.appendChild(video);
        videoList.appendChild(videoItem);
    }
}

function showDocuments() {
    var documentInput = document.getElementById('ownershipDocument');
    var documentList = document.getElementById('documentList');
    var documents = documentInput.files;

    // Clear previous documents
    documentList.innerHTML = '<label for="ownershipDocument">Proof of Ownership Document:</label>';

    // Display new documents
    for (var i = 0; i < documents.length; i++) {
        var documentItem = document.createElement('li');
        documentItem.className = 'form-text text-muted';
        var documentLink = document.createElement('a');
        documentLink.href = URL.createObjectURL(documents[i]);
        documentLink.textContent = 'Document ' + (i + 1);
        documentItem.appendChild(document.createElement('label')).textContent = 'Document ' + (i + 1) + ':';
        documentItem.appendChild(documentLink);
        documentList.appendChild(documentItem);
    }
}

// Function to display SweetAlert
function displaySweetAlert(title, text, icon, confirmButtonColor, redirectUrl) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonColor: confirmButtonColor,
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}

function cancelForm() {
    window.location.href = 'property-list.php';
}

// DOM elements
var titleInput = document.getElementById("title");
var descriptionInput = document.getElementById("description");
var priceInput = document.getElementById("price");
var dueDateInput = document.getElementById("dueDate");
var rentalTypeInput = document.getElementById("rentalType");
var occupancyInput = document.getElementById("occupancy");
var propertyImageInput = document.getElementById("propertyImage");
var propertyVideoInput = document.getElementById("propertyVideo");
var addressInput = document.getElementById("address");
var barangayInput = document.getElementById("barangay");
var cityInput = document.getElementById("city");
var stateInput = document.getElementById("state");
var zipCodeInput= document.getElementById("zipCode");
var ownershipDocumentInput= document.getElementById("ownershipDocument");

// Error elements
var titleError = document.getElementById("error-title");
var descriptionError = document.getElementById("error-description");
var priceError = document.getElementById("error-price");
var typeError = document.getElementById("error-type");
var dueError = document.getElementById("error-due");
var occupancyError = document.getElementById("error-occupancy");
var imageError = document.getElementById("error-image");
var videoError = document.getElementById("error-video");
var addressError = document.getElementById("error-address");
var barangayError = document.getElementById("error-barangay");
var cityError = document.getElementById("error-city");
var provinceError = document.getElementById("error-province");
var codeError = document.getElementById("error-code");
var documentError = document.getElementById("error-document");

document.getElementById("addPropertyForm").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData();

    formData.append('title', titleInput.value);
    formData.append('description', descriptionInput.value);
    formData.append('price', priceInput.value);
    formData.append('dueDate', dueDateInput.value);
    formData.append('rentalType', rentalTypeInput.value);
    formData.append('occupancy', occupancyInput.value);
    formData.append('propertyImage', propertyImageInput.files[0]);
    formData.append('propertyVideo', propertyVideoInput.files[0]);
    formData.append('address', addressInput.value);
    formData.append('barangay', barangayInput.value);
    formData.append('city', cityInput.value);
    formData.append('state', stateInput.value);
    formData.append('zipCode', zipCodeInput.value);
    formData.append('ownershipDocument', ownershipDocumentInput.files[0]);

    for (const value of formData.values()) {
        console.log(value);
      }

      fetch('add-property-process.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        // Check if there's an error
        if (data.error) {
            // Display server-side error
            displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
        } else if (data.warning) {
            // Display server-side warning
            displaySweetAlert("Warning", data.warning, "warning", "#6EC6FF", null);
        } else if (data.success) {
            // Display success message
            displaySweetAlert("Success", data.success, "success", "#6EC6FF", "property-list.php");
        }
      })
      .catch(console.error);
});

// Function to clear all error messages
function clearAllErrorMessages() {
    var errorElements = document.querySelectorAll(".error-message");
    errorElements.forEach(function(element) {
        element.textContent = "";
    });
}

    // Validate title
    titleInput.addEventListener("input", function () {
        var title = titleInput.value;
        if (!title) {
            displayErrorMessage(titleError, "Title is required");
        } else {
            hideErrorMessage(titleError);
        }
    });

    // Validate description
    descriptionInput.addEventListener("input", function () {
        var description = descriptionInput.value;
        if (!description) {
            displayErrorMessage(descriptionError, "Description is required");
        } else {
            hideErrorMessage(descriptionError);
        }
    });

    // Validate price
    priceInput.addEventListener("input", function () {
        var price = priceInput.value;
        if (!price) {
            displayErrorMessage(priceError, "Price is required");
        } else {
            hideErrorMessage(priceError);
        }
    });

    // Validate rental type
    rentalTypeInput.addEventListener("change", function () {
        var rentalType = rentalTypeInput.value;
        if (!rentalType) {
            displayErrorMessage(typeError, "Rental Type is required");
        } else {
            hideErrorMessage(typeError);
        }
    });

    // Validate occupancy
    occupancyInput.addEventListener("input", function () {
        var occupancy = occupancyInput.value;
        if (!occupancy) {
            displayErrorMessage(occupancyError, "Occupancy is required");
        } else {
            hideErrorMessage(occupancyError);
        }
    });

    // Validate address
    addressInput.addEventListener("input", function () {
        var address = addressInput.value;
        if (!address) {
            displayErrorMessage(addressError, "Address is required");
        } else {
            hideErrorMessage(addressError);
        }
    });

    // Validate barangay
    barangayInput.addEventListener("input", function () {
        var barangay = barangayInput.value;
        if (!barangay) {
            displayErrorMessage(barangayError, "Barangay is required");
        } else {
            hideErrorMessage(barangayError);
        }
    });

    // Validate city
    cityInput.addEventListener("input", function () {
        var city = cityInput.value;
        if (!city) {
            displayErrorMessage(cityError, "City is required");
        } else {
            hideErrorMessage(cityError);
        }
    });

    // Validate state
    stateInput.addEventListener("input", function () {
        var state = stateInput.value;
        if (!state) {
            displayErrorMessage(stateError, "State is required");
        } else {
            hideErrorMessage(stateError);
        }
    });

    // Validate ZIP code
    zipCodeInput.addEventListener("input", function () {
        var zipCode = zipCodeInput.value;
        if (!zipCode) {
            displayErrorMessage(zipCodeError, "ZIP Code is required");
        } else {
            hideErrorMessage(zipCodeError);
        }
    });

    // Validate property image
    propertyImageInput.addEventListener("change", function () {
        var propertyImage = propertyImageInput.value;
        if (!propertyImage) {
            displayErrorMessage(imageError, "Property Image is required");
        } else {
            hideErrorMessage(imageError);
        }
    });

    // Validate property video
    propertyVideoInput.addEventListener("change", function () {
        var propertyVideo = propertyVideoInput.value;
        if (!propertyVideo) {
            displayErrorMessage(videoError, "Property Video is required");
        } else {
            hideErrorMessage(videoError);
        }
    });

    // Validate ownership document
    ownershipDocumentInput.addEventListener("change", function () {
        var ownershipDocument = ownershipDocumentInput.value;
        if (!ownershipDocument) {
            displayErrorMessage(documentError, "Ownership Document is required");
        } else {
            hideErrorMessage(documentError);
        }
    });
  

// Function to validate form inputs
function validateForm() {
    var isValid = true;

    // Perform individual validations
    if (!titleInput.value) {
        displayErrorMessage(titleError, "Title is required");
        isValid = false;
    }

    if (!descriptionInput.value) {
        displayErrorMessage(descriptionError, "Description is required");
        isValid = false;
    }

    if (!priceInput.value) {
        displayErrorMessage(priceError, "Price is required");
        isValid = false;
    }

    if (!rentalTypeInput.value) {
        displayErrorMessage(typeError, "Rental Type is required");
        isValid = false;
    }

    if (!occupancyInput.value) {
        displayErrorMessage(occupancyError, "Occupancy is required");
        isValid = false;
    }

    if (!addressInput.value) {
        displayErrorMessage(addressError, "Address is required");
        isValid = false;
    }

    if (!barangayInput.value) {
        displayErrorMessage(barangayError, "Barangay is required");
        isValid = false;
    }

    if (!cityInput.value) {
        displayErrorMessage(cityError, "City is required");
        isValid = false;
    }

    if (!stateInput.value) {
        displayErrorMessage(stateError, "State is required");
        isValid = false;
    }

    if (!zipCodeInput.value) {
        displayErrorMessage(zipCodeError, "ZIP Code is required");
        isValid = false;
    }

    if (!propertyImageInput.value) {
        displayErrorMessage(imageError, "Property Image is required");
        isValid = false;
    }

    if (!propertyVideoInput.value) {
        displayErrorMessage(videoError, "Property Video is required");
        isValid = false;
    }

    if (!ownershipDocumentInput.value) {
        displayErrorMessage(documentError, "Ownership Document is required");
        isValid = false;
    }

    return isValid;
}

// Function to display error message
function displayErrorMessage(element, message) {
    element.innerHTML = '<span style="color: red;">' + message + '</span>';
    element.style.display = "block"; // Show the error message
}

function hideErrorMessage(element) {
    element.innerHTML = "";
    element.style.display = "none"; // Hide the error message
  }


// Function to display SweetAlert
function displaySweetAlert(title, text, icon, confirmButtonColor, redirectUrl) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonColor: confirmButtonColor,
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}