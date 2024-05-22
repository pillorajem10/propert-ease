// Function to show a specific section and hide others
function showSection(sectionId) {
    const sections = document.querySelectorAll('.container');
    sections.forEach(section => {
        if (section.id === sectionId) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });

    // Store the current section ID in localStorage
    localStorage.setItem('currentSection', sectionId);
}

// Retrieve the last viewed section from localStorage on page load
document.addEventListener('DOMContentLoaded', () => {
    const currentSection = localStorage.getItem('currentSection');
    if (currentSection) {
        showSection(currentSection);
    } else {
        // Default to showing the first section if no stored section found
        showSection('container1');
    }
});

function showSection(containerId, navId) {
    // Function to hide all sections and show the one corresponding to the clicked nav section
    document.querySelectorAll('.container').forEach(section => {
        section.style.display = 'none'; // Hide all sections
    });
    document.getElementById(containerId).style.display = 'block'; // Show the selected section

    // Update the appearance of all navigation items
    document.querySelectorAll('.nav-section').forEach(nav => {
        nav.classList.remove('active', 'btn-primary');
        nav.classList.add('btn-light');
    });

    var activeNav = document.getElementById(navId);
    activeNav.classList.add('active', 'btn-primary');
    activeNav.classList.remove('btn-light');
}