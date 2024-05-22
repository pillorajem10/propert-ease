function filterProperties() {
    // Get the input value
    var input = document.getElementById('searchInput').value.toLowerCase();

    // Get all property cards
    var cards = document.querySelectorAll('.row .card');

    // Flag to check if any matching property is found
    var found = false;

    // Loop through each card
    cards.forEach(function(card) {
        // Get the property name from the card
        var propertyName = card.querySelector('.card-title').textContent.toLowerCase();
        // Get the property location from the card
        var propertyLocation = card.querySelector('.location').textContent.toLowerCase();
        // Get the property image from the card
        var propertyImage = card.querySelector('.card-img-top');

        // Check if the property name or location contains the input value
        if (propertyName.includes(input) || propertyLocation.includes(input)) {
            // Show the card and its content if it matches
            card.style.display = 'block';
            if (propertyImage) propertyImage.style.display = 'block';
            found = true; // Set flag to true if at least one match is found
        } else {
            // Hide the card and its content if it doesn't match
            card.style.display = 'none';
            if (propertyImage) propertyImage.style.display = 'none';
        }
    });

    // Display "No Results Found" message if no matching properties are found
    var noResultsMessage = document.getElementById('noResultsMessage');
    if (!found) {
        noResultsMessage.style.display = 'block';
    } else {
        noResultsMessage.style.display = 'none';
    }
}

// Event listener for input change
document.getElementById('searchInput').addEventListener('input', filterProperties);