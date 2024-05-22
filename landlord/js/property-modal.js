// Sample data for the modal (replace with your actual data)
var propertyModalData = {
    image: "img/property1.png",
    title: "Property #1",
    location: "Manila City",
    description: "This property offers three bedrooms, two bathrooms, and a spacious living area spanning approximately 5,000 square feet.",
    rate: "₱10,000",
    number: "5"
};

// Function to populate the modal with data
function populateModal() {
    document.getElementById('modalTitle').innerText = propertyModalData.property_name;
    document.getElementById('modalLocation').innerText = propertyModalData.property_city;
    document.getElementById('modalDescription').innerText = propertyModalData.property_description;
    document.getElementById('modalRate').innerText = propertyModalData.property_rate;
    document.getElementById('modalNumber').innerText = propertyModalData.propert_tenants;

    // Set the property image dynamically
    var modalImage = document.getElementById('modalImage');
    modalImage.src = propertyModalData.image;
    modalImage.alt = propertyModalData.title + ' Image';
}