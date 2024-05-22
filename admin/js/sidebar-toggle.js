document.addEventListener("DOMContentLoaded", function() {
    var sidebarToggle = document.querySelector('.sidebar-toggle');
    var sidebar = document.getElementById('sidebar');
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
    });
});