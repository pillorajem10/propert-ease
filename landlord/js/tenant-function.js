function filterCurrentTenants() {
    // Get the input value
    var input = document.getElementById('searchInput1').value.toLowerCase();

    // Get all current tenant cards
    var cards = document.querySelectorAll('#currenttenantList .card');

    // Flag to check if any matching tenant is found
    var found = false;

    // Loop through each card
    cards.forEach(function(card) {
        // Get the tenant name from the card
        var tenantName = card.querySelector('.card-title').textContent.toLowerCase();

        // Check if the tenant name contains the input value
        if (tenantName.includes(input)) {
            // Show the card if it matches
            card.style.display = 'block';
            found = true; // Set flag to true if at least one match is found
        } else {
            // Hide the card if it doesn't match
            card.style.display = 'none';
        }
    });

    // Display "No Results Found" message if no matching tenants are found
    var noResultsMessage = document.getElementById('noResultsMessage1');
    if (!found) {
        noResultsMessage.style.display = 'block';
    } else {
        noResultsMessage.style.display = 'none';
    }
}

// Event listener for input change
document.getElementById('searchInput1').addEventListener('input', filterCurrentTenants);

function filterPendingTenants() {
    // Get the input value
    var input = document.getElementById('searchInput2').value.toLowerCase();

    // Get all pending tenant cards
    var cards = document.querySelectorAll('#pendingtenantList .card');

    // Flag to check if any matching tenant is found
    var found = false;

    // Loop through each card
    cards.forEach(function(card) {
        // Get the tenant name from the card
        var tenantName = card.querySelector('.card-title').textContent.toLowerCase();

        // Check if the tenant name contains the input value
        if (tenantName.includes(input)) {
            // Show the card if it matches
            card.style.display = 'block';
            found = true; // Set flag to true if at least one match is found
        } else {
            // Hide the card if it doesn't match
            card.style.display = 'none';
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
document.getElementById('searchInput2').addEventListener('input', filterPendingTenants);