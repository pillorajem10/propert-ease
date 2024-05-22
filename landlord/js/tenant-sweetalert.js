// Function to show SweetAlert for kicking a tenant
function exitTenant(tenantId) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Kick Tenant',
        text: 'Are you sure you want to accept exit request?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            fetch('exit-tenant.php?id=' + tenantId, {
                method: 'PUT',
                })
                .then(response => response.json())
                .then(data => {
                    // Check if there's an error
                    if (data.error) {
                        // Display server-side error
                        displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
                    } else if (data.success) {
                        // Display success message
                        displaySweetAlert("Exit Success", data.success, "success", "#6EC6FF", "dashboard.php");
                    }
                })
                .catch(error => {
                    displaySweetAlert("Error", error, "error", "#6EC6FF", null);
                });
        } 
    });
}

// Function to show SweetAlert for kicking a tenant
function kickTenant(tenantId) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Kick Tenant',
        text: 'Are you sure you want to kick this tenant?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, kick them!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            fetch('kick-tenant.php?id=' + tenantId, {
                method: 'PUT',
                })
                .then(response => response.json())
                .then(data => {
                    // Check if there's an error
                    if (data.error) {
                        // Display server-side error
                        displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
                    } else if (data.success) {
                        // Display success message
                        displaySweetAlert("Tenant Kicked", data.success, "success", "#6EC6FF", "dashboard.php");
                    }
                })
                .catch(error => {
                    displaySweetAlert("Error", error, "error", "#6EC6FF", null);
                });
        } 
    });
}



// Function to show SweetAlert for rejecting a tenant
function rejectTenant(pendingId) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Reject Tenant',
        text: 'Are you sure you want to reject this tenant?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, reject them!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            fetch('reject-tenant.php?id=' + pendingId, {
                method: 'DELETE',
                })
                .then(response => response.json())
                .then(data => {
                    // Check if there's an error
                    if (data.error) {
                        // Display server-side error
                        displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
                    } else if (data.success) {
                        // Display success message
                        displaySweetAlert("Tenant Rejected", data.success, "success", "#6EC6FF", "dashboard.php");
                    }
                })
                .catch(error => {
                    displaySweetAlert("Error", error, "error", "#6EC6FF", null);
                });
        } 
    });
}

// Function to show SweetAlert for accepting a tenant
function acceptTenant(pendingId) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Accept Tenant',
        text: 'Are you sure you want to accept this tenant?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, accept them!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            fetch('accept-tenant.php?id='+pendingId, {
                method: 'PUT',
                })
                .then(response => response.json())
                .then(data => {
                    // Check if there's an error
                    if (data.error) {
                        // Display server-side error
                        displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
                    } else if (data.success) {
                        // Display success message
                        displaySweetAlert("Tenant Accepted", data.success, "success", "#6EC6FF", "dashboard.php");
                    } else if (data.warning) {
                        displaySweetAlert("Warning", data.warning, "warning", "#6EC6FF", null);
                    }
                })
                .catch(error => {
                    displaySweetAlert("Error", error, "error", "#6EC6FF", null);
                });
        } 
    });
}

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