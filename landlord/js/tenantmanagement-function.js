function filterPaidTenants() {
    // Get the input value and convert to lowercase
    var input = document.getElementById("searchInput").value.toLowerCase().trim();

    // Get all table rows (tenant records)
    var rows = document.querySelectorAll("#paidTenantList tbody tr");

    // Loop through each row
    rows.forEach(function(row) {
        // Get the tenant name from the row and convert to lowercase
        var tenantName = row.querySelector(".tenant-name").textContent.toLowerCase();

        // Check if the tenant name contains the input value
        var display = tenantName.includes(input) ? "table-row" : "none";
        row.style.display = display;
    });

    // Show/hide "No Results Found" message based on matching rows
    var noResultsMessage = document.getElementById("noResultsMessage");
    noResultsMessage.style.display = (document.querySelectorAll("#paidTenantList tbody tr[style*='display: table-row']").length === 0) ? "block" : "none";
}

// Event listener for input change
document.getElementById("searchInput").addEventListener("input", filterPaidTenants);