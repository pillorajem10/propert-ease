function verifyLandlord(button) {
    // Check if the button is already verified
    if (!button.classList.contains('verified')) {
        // Toggle the 'verified' class on the button
        button.classList.toggle('verified');

        console.log('Landlord Verified:', button.classList.contains('verified'));
        
        // Update the button text to "Verified"
        button.textContent = 'Verified';
    }
}

function verifyTenant(button) {
    // Check if the button is already verified
    if (!button.classList.contains('verified')) {
        // Toggle the 'verified' class on the button
        button.classList.toggle('verified');

        console.log('Tenant Verified:', button.classList.contains('verified'));
        
        // Update the button text to "Verified"
        button.textContent = 'Verified';
    }
}

function verifyProperty(propertyId) {
    Swal.fire({
        target: "body",
        icon: "question",
        title: "Confirmation",
        text: "Are you sure you want to verify this property?",
        showCancelButton: true,
        confirmButtonText: "Confirm",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('verify-property.php?id=' + propertyId, {
                method: 'PUT',
              })
              .then(response => response.json())
              .then(data => {
                if (data.error) {
                    // Display server-side error
                    displaySweetAlert("Error", data.error, "error", "#6EC6FF", null);
                } else if (data.warning) {
                    // Display server-side warning
                    displaySweetAlert("Warning", data.warning, "warning", "#6EC6FF", null);
                } else if (data.success) {
                    // Display success message
                    displaySweetAlert("Success", data.success, "success", "#6EC6FF", "property-management.php");
                }
              })
              .catch(error => console.error('Error:', error));
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