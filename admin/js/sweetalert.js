function banLandlord(landlordId) {
    Swal.fire({
        title: 'Ban Landlord',
        text: 'Are you sure you want to ban this landlord?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'YES',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.value) {
            window.location.href = 'banLandlord.php?landlordId=' + landlordId;
        } else {
            Swal.fire(
                'Cancelled',
                'The banning operation has been cancelled.',
                'error'
            );
        }
    });
}


// Function to show SweetAlert for banning a tenant
function banTenant(button) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Ban Tenant',
        text: 'Are you sure you want to ban this tenant?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'YES',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.value) {
            // If the admin clicks "YES", display success message
            Swal.fire(
                'Banned!',
                'The tenant has been banned successfully.',
                'success'
            );
            var row = button.closest('tr'); // Get the closest row to the button
            row.parentNode.removeChild(row); // Remove the row from the table
        } else {
            // If the admin clicks "NO", display cancellation message
            Swal.fire(
                'Cancelled',
                'The banned operation has been cancelled.',
                'error'
            );
        }
    });
}

// Function to show SweetAlert for rejecting a landlord
function rejectLandlord(button) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Reject Landlord',
        text: 'Are you sure you want to reject this landlord?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'YES',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.value) {
            // If the admin clicks "YES", display success message
            Swal.fire(
                'Rejected!',
                'The landlord has been rejected successfully.',
                'success'
            );
            var row = button.closest('tr'); // Get the closest row to the button
            row.parentNode.removeChild(row); // Remove the row from the table
        } else {
            // If the admin clicks "NO", display cancellation message
            Swal.fire(
                'Cancelled',
                'The banning operation has been cancelled.',
                'error'
            );
        }
    });
}

// Function to show SweetAlert for rejecting a tenant
function rejectTenant(button) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Reject Tenant',
        text: 'Are you sure you want to reject this tenant?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'YES',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.value) {
            // If the admin clicks "YES", display success message
            Swal.fire(
                'Rejected!',
                'The tenant has been rejected successfully.',
                'success'
            );
            var row = button.closest('tr'); // Get the closest row to the button
            row.parentNode.removeChild(row); // Remove the row from the table
        } else {
            // If the admin clicks "NO", display cancellation message
            Swal.fire(
                'Cancelled',
                'The banning operation has been cancelled.',
                'error'
            );
        }
    });
}

// Function to show SweetAlert for rejecting a property
function rejectProperty(button) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Reject Property',
        text: 'Are you sure you want to reject this property?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'YES',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.value) {
            // If the admin clicks "YES", display success message
            Swal.fire(
                'Rejected!',
                'The property has been rejected successfully.',
                'success'
            );
            var row = button.closest('tr'); // Get the closest row to the button
            row.parentNode.removeChild(row); // Remove the row from the table
        } else {
            // If the admin clicks "NO", display cancellation message
            Swal.fire(
                'Cancelled',
                'The banning operation has been cancelled.',
                'error'
            );
        }
    });
}