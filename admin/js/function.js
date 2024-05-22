function filterLandlords() {
    // Get the input value
    var input = document.getElementById('searchInput1').value.toLowerCase();

    // Get all landlord cards
    var cards = document.querySelectorAll('#landlordList .card');

    // Flag to check if any matching landlord is found
    var found = false;

    // Loop through each card
    cards.forEach(function(card) {
        // Get the landlord name from the card
        var landlordName = card.querySelector('.card-title').textContent.toLowerCase();

        // Get the landlord image
        var landlordImage = card.querySelector('.landlord-img');

        // Check if the landlord name contains the input value
        if (landlordName.includes(input)) {
            // Show the card if it matches
            card.style.display = 'block';
            landlordImage.style.display = 'block'; // Show the landlord image
            found = true; // Set flag to true if at least one match is found
        } else {
            // Hide the card if it doesn't match
            card.style.display = 'none';
            landlordImage.style.display = 'none'; // Hide the landlord image
        }
    });

    // Display "No Results Found" message if no matching landlords are found
    var noResultsMessage = document.getElementById('noResultsMessage1');
    if (!found) {
        noResultsMessage.style.display = 'block';
    } else {
        noResultsMessage.style.display = 'none';
    }
}

// Event listener for input change
document.getElementById('searchInput1').addEventListener('input', filterLandlords);

function filterTenants() {
    // Get the input value
    var input = document.getElementById('searchInput2').value.toLowerCase();

    // Get all tenant cards
    var cards = document.querySelectorAll('#tenantList .card');

    // Flag to check if any matching tenant is found
    var found = false;

    // Loop through each card
    cards.forEach(function(card) {
        // Get the tenant name from the card
        var tenantName = card.querySelector('.card-title').textContent.toLowerCase();

        // Get the tenant image
        var tenantImage = card.querySelector('.tenant-img');

        // Check if the tenant name contains the input value
        if (tenantName.includes(input)) {
            // Show the card if it matches
            card.style.display = 'block';
            tenantImage.style.display = 'block'; // Show the tenant image
            found = true; // Set flag to true if at least one match is found
        } else {
            // Hide the card if it doesn't match
            card.style.display = 'none';
            tenantImage.style.display = 'none'; // Hide the tenant image
        }
    });

    // Display "No Results Found" message if no matching tenants are found
    var noResultsMessage = document.getElementById('noResultsMessage2');
    if (!found) {
        noResultsMessage.style.display = 'block';
    } else {
        noResultsMessage.style.display = 'none';
    }
}

// Event listener for input change
document.getElementById('searchInput2').addEventListener('input', filterTenants);

function filterProperties() {
    // Get the input value
    var input = document.getElementById('searchInput3').value.toLowerCase();

    // Get all property cards
    var cards = document.querySelectorAll('#propertyList .card');

    // Flag to check if any matching property is found
    var found = false;

    // Loop through each card
    cards.forEach(function(card) {
        // Get the property name from the card
        var propertyName = card.querySelector('.card-title').textContent.toLowerCase();

        // Get the property image
        var propertyImage = card.querySelector('.property-img');

        // Check if the property name contains the input value
        if (propertyName.includes(input)) {
            // Show the card if it matches
            card.style.display = 'block';
            propertyImage.style.display = 'block'; // Show the property image
            found = true; // Set flag to true if at least one match is found
        } else {
            // Hide the card if it doesn't match
            card.style.display = 'none';
            propertyImage.style.display = 'none'; // Hide the property image
        }
    });

    // Display "No Results Found" message if no matching properties are found
    var noResultsMessage = document.getElementById('noResultsMessage3');
    if (!found) {
        noResultsMessage.style.display = 'block';
    } else {
        noResultsMessage.style.display = 'none';
    }
}

// Event listener for input change
document.getElementById('searchInput3').addEventListener('input', filterProperties);

function openRejectModal(tenantId) {
  document.getElementById("tenantId").value = tenantId;
  $("#rejectModal").modal("show");
}