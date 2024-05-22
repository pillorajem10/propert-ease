function deleteRow(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Once deleted, you will not be able to recover this data!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            // If the user clicks "Yes," proceed with deletion
            var row = button.parentNode.parentNode; // Get the row element
            row.parentNode.removeChild(row); // Remove the row from the table

            // Display success message
            Swal.fire(
                'Deleted!',
                'The data has been deleted successfully.',
                'success'
            );
        } else {
            // If the user clicks "Cancel," display cancellation message
            Swal.fire(
                'Cancelled',
                'The operation has been cancelled.',
                'error'
            );
        }
    });
}