// Function to handle form submission and fetch property list
function fetchPropertyList(city, rentalType) {
    const url = `/propert-ease/rental-list.php?city=${encodeURIComponent(city)}&rental_type=${encodeURIComponent(rentalType)}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            const propertyItems = document.querySelectorAll('.property');
            propertyItems.forEach(property => {
                const propertyType = property.dataset.type;
                if (propertyType === rentalType.toLowerCase()) {
                    property.style.display = 'block'; // Show the property if it matches the selected type
                    property.innerHTML = data; // Update the property content with fetched data
                } else {
                    property.style.display = 'none'; // Hide the property if it doesn't match the selected type
                }
            });
        })
        .catch(error => {
            console.error('Error fetching property data:', error);
        });
}

function handleFindNow(event) {
    event.preventDefault(); // Prevent default form submission behavior

    const citySelect = document.querySelector('select[name="city"]');
    const rentalTypeSelect = document.querySelector('select[name="rental_type"]');
    const selectedCity = citySelect.value;
    const selectedRentalType = rentalTypeSelect.value;

    fetchPropertyList(selectedCity, selectedRentalType); // Fetch and update property listings
}

const propertySearchForm = document.getElementById('propertySearchForm');
propertySearchForm.addEventListener('submit', handleFindNow);