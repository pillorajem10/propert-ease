const toggleCurrentPassword = document.querySelector("#toggleCurrentPassword");
const currentPassword = document.querySelector("#current-password");
const toggleNewPassword = document.querySelector("#toggleNewPassword");
const newPassword = document.querySelector("#new-password");
const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
const confirmPassword = document.querySelector("#confirm-newpassword");

toggleCurrentPassword.addEventListener("click", function () {
    const type =
        currentPassword.getAttribute("type") === "password" ? "text" : "password";
    currentPassword.setAttribute("type", type);
    const icon = this.querySelector("i");
    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
});

toggleNewPassword.addEventListener("click", function () {
    const type =
        newPassword.getAttribute("type") === "password" ? "text" : "password";
    newPassword.setAttribute("type", type);
    const icon = this.querySelector("i");
    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
});

toggleConfirmPassword.addEventListener("click", function () {
    const type =
        confirmPassword.getAttribute("type") === "password" ? "text" : "password";
    confirmPassword.setAttribute("type", type);
    const icon = this.querySelector("i");
    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
});