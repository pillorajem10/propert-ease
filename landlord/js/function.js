document.addEventListener('DOMContentLoaded', function() {
    var roleElement = document.getElementById('role');
    var roleText = roleElement.textContent;
    roleElement.textContent = roleText.charAt(0).toUpperCase() + roleText.slice(1);
});