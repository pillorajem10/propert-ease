document.addEventListener('DOMContentLoaded', function () {
    var propertyCityRadios = document.querySelectorAll('input[name="property_location"]');
    propertyCityRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            handlePropertyLocationChange(this);
        });
    });

    // Load property list by default based on initial selection
    handlePropertyLocationChange(document.querySelector('input[name="property_location"]:checked'));
});

function handlePropertyLocationChange(selectedRadio) {
    if (selectedRadio && selectedRadio.value) {
        const selectedPropertyCity = selectedRadio.value;

        // Update the visual indication of selected property city
        const allCheckmarks = document.querySelectorAll('.checkCity');
        allCheckmarks.forEach(checkmark => {
            checkmark.classList.remove('checked');
        });
        selectedRadio.parentElement.querySelector('.checkCity').classList.add('checked');

        // Update the URL to reflect the selected property city without page reload
        const url = new URL(window.location.href);
        url.searchParams.set('property_location', selectedPropertyCity);
        window.history.pushState({ path: url.href }, '', url.href);

        // Fetch properties based on the selected city
        fetchPropertyData(selectedPropertyCity);
    }
}

function fetchPropertyData(propertyCity) {
    // Fetch property data using AJAX or Fetch API
    fetch(`/propert-ease/rental-list.php?property_location=${propertyCity}`)
    .then(response => response.text())
    .then(data => {
        // Update the property listings with the fetched data
        const parser = new DOMParser();
        const doc = parser.parseFromString(data, 'text/html');
        const newProperties = doc.querySelectorAll('.property');
        const propertyList = document.querySelector('.ltn__product-slider .row');
        
        // Clear existing properties
        propertyList.innerHTML = '';
        
        // Append new properties
        newProperties.forEach(newProperty => {
            propertyList.appendChild(newProperty);
        });

        // Show/Hide properties based on the city
        const properties = document.querySelectorAll('.property');
        properties.forEach(property => {
            const propertyCity = property.dataset.city;
            if (propertyCity.toLowerCase() === selectedPropertyCity.toLowerCase()) {
                property.classList.add('visible');
            } else {
                property.classList.remove('visible');
            }
        });
    })
    .catch(error => {
        console.error('Error fetching property data:', error);
    });
}