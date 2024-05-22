function showButtons() {
    var checkbox = document.getElementById("agree-checkbox");
    var buttonContainer = document.getElementById("button-container");
    if (checkbox.checked) {
        buttonContainer.style.display = "flex";
    } else {
        buttonContainer.style.display = "none";
    }
}

function agreeTerms() {
    window.location.href = 'register.html';
}

function cancelAgreement() {
    var checkbox = document.getElementById("agree-checkbox");
    var buttonContainer = document.getElementById("button-container");
    checkbox.checked = false;
    buttonContainer.style.display = "none";
}