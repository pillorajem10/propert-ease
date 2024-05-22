function showLogoutConfirmation(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure you want to logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Logout Successfully!!!',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then(() => {
                sessionStorage.clear();
                window.location.href = 'logout.php';
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Logout Cancelled', '', 'error');
        }
    });
}