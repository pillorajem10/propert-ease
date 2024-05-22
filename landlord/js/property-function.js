function filterProperties() {
    // Get the input value
    var input = document.getElementById("searchInput").value.toLowerCase();

    // Get all table rows (property records)
    var rows = document.querySelectorAll("#propertyList tbody tr");

    // Flag to check if any matching property is found
    var found = false;

    // Loop through each row
    rows.forEach(function(row) {
        // Get the property name from the row
        var propertyName = row.querySelector(".card-title").textContent.toLowerCase();

        // Get the rental type from the row
        var rentalType = row.querySelector(".card-type").textContent.toLowerCase();

        // Check if the property name contains the input value
        if (propertyName.includes(input)) {
            // Show the row if it matches
            row.style.display = "table-row";
            found = true; // Set flag to true if at least one match is found
        } else {
            // Hide the row if it doesn't match
            row.style.display = "none";
        }

        // Check if the rental type contains the input value
        if (rentalType.includes(input)) {
            // Show the row if it matches
            row.style.display = "table-row";
            found = true; // Set flag to true if at least one match is found
        } else {
            // Hide the row if it doesn't match
            row.style.display = "none";
        }
    });

    // Display "No Results Found" message if no matching properties are found
    var noResultsMessage = document.getElementById("noResultsMessage");
    if (!found) {
        noResultsMessage.style.display = "block";
    } else {
        noResultsMessage.style.display = "none";
    }
}

// Event listener for input change
document.getElementById("searchInput").addEventListener("input", filterProperties);