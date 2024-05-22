function displayValidId() {
    const input = document.getElementById('valid-id');
    const preview = document.getElementById('preview-valid-id');

    const file = input.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        preview.src = 'img/white-background.jpg';
        preview.style.display = 'none';
    }
}

function displaySelfieId() {
    const input = document.getElementById('selfie-id');
    const preview = document.getElementById('preview-selfie-id');

    const file = input.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        preview.src = 'img/white-background.jpg';
        preview.style.display = 'none';
    }
}