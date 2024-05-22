function filterTransactionRecords() {
    // Get the input value
    var input = document.getElementById("searchInput").value.trim().toLowerCase();

    // Get all table rows (property records)
    var rows = document.querySelectorAll("#propertyList tbody tr");

    // Loop through each row
    rows.forEach(function(row) {
        // Get the data from the row
        var transactionDate = row.querySelector(".date").textContent.toLowerCase();
        var landlordName = row.querySelector(".landlord-name").textContent.toLowerCase();
        var tenantName = row.querySelector(".tenant-name").textContent.toLowerCase();
        var price = row.querySelector(".price").textContent.toLowerCase();
        var status = row.querySelector(".status-cell").textContent.toLowerCase();

        // Determine if the row should be shown based on any match
        var showRow =
            transactionDate.includes(input) ||
            landlordName.includes(input) ||
            tenantName.includes(input) ||
            price.includes(input) ||
            status.includes(input);

        // Toggle row visibility
        row.style.display = showRow ? "table-row" : "none";
    });

    // Check if any rows are visible
    var visibleRows = Array.from(rows).some(function(row) {
        return row.style.display !== "none";
    });

    // Display "No Results Found" message if no rows are visible
    var noResultsMessage = document.getElementById("noResultsMessage");
    noResultsMessage.style.display = visibleRows ? "none" : "block";
}

// Event listener for input change
document.getElementById("searchInput").addEventListener("input", filterTransactionRecords);