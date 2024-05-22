function confirmUnBanLandlord(landlordId) {
    Swal.fire({
        target: "body",
        title: "Are you sure?",
        text: "You are about to Unban this landlord. ",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Unban it!"
    }).then((result) => {
        if (result.isConfirmed) {
            unBanLandlord(landlordId);
        }
    });
}

function unBanLandlord(landlordId) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "unBanLandlord.php?landlordId=" + landlordId, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.error) {
                Swal.fire({
                    title: "Error!",
                    text: response.error,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            } else if (response.success) {
                Swal.fire({
                    title: "Unbanned!",
                    text: response.success,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "history-logs.php";
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while processing the request.',
                    icon: 'error',
                    confirmButtonColor: '#6EC6FF',
                });
            }
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Failed to process the request. Status code: ' + xhr.status,
                icon: 'error',
                confirmButtonColor: '#6EC6FF',
            });
        }
    };
    xhr.onerror = function () {
        Swal.fire({
            title: 'Error',
            text: 'Failed to send the request.',
            icon: 'error',
            confirmButtonColor: '#6EC6FF',
        });
    };
    xhr.send();
}