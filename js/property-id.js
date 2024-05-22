function propertySelect(propertyId){
    fetch('property-select.php?id=' + propertyId, {
        method: 'GET',
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
            window.location.href = data.success;
        }   else if (data.login) {
            // Display success message
            displaySweetAlert("Login First!", data.login, "warning", "#6EC6FF", "login.html");
        }
      })
      .catch(error => console.error('Error:', error));
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