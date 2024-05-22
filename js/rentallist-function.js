document.addEventListener("DOMContentLoaded", function () {
    var rentalTypeRadios = document.querySelectorAll('input[name="rental_type"]');
    rentalTypeRadios.forEach(function (radio) {
        radio.addEventListener("click", function () {
            filterProperties(this.value);
            handleRentalTypeChange(this.value);
        });
    });

    // Load property list by default
    filterProperties("");
    handleRentalTypeChange("");
});

function filterProperties(type) {
    var propertyListItems = document.querySelectorAll(".property");
    propertyListItems.forEach(function (property) {
        if (type === "" || property.classList.contains(type)) {
            property.style.display = "block";
        } else {
            property.style.display = "none";
        }
    });
}

function updatePriceRange() {
    var minPrice = parseInt(document.getElementById("min_price").value);
    var maxPrice = parseInt(document.getElementById("max_price").value);

    // Limit the price range to 0-5000
    minPrice = Math.min(5000, Math.max(0, minPrice));
    
    // Ensure maxPrice is greater than minPrice
    if (maxPrice <= minPrice) {
        maxPrice = minPrice + 1;
        document.getElementById("max_price").value = maxPrice;
    } else {
        maxPrice = Math.min(5000, Math.max(0, maxPrice));
    }

    document.getElementById("price_range").textContent =
        "₱" + minPrice + " - ₱" + maxPrice;

    var properties = document.querySelectorAll(".property");

    for (var i = 0; i < properties.length; i++) {
        var propertyPrice = parseInt(
            properties[i]
            .querySelector(".price-data-filter strong")
            .textContent.replace("₱", "")
            .replace(" per month", "")
            .replace(",", "")
        );
        if (propertyPrice >= minPrice && propertyPrice <= maxPrice) {
            properties[i].style.display = "block";
        } else {
            properties[i].style.display = "none";
        }
    }

    console.log('MinPrice:'+minPrice,'MaxPrice:'+maxPrice);
}

document.getElementById("min_price").addEventListener("input", function () {
    filterProperties();
    updatePriceRange();
});

document.getElementById("max_price").addEventListener("input", function () {
    filterProperties();
    updatePriceRange();
});

function handleRentalTypeChange(selectedRadio) {
    const selectedRentalType = selectedRadio.value;

    // Update the visual indication of selected rental type
    const allCheckmarks = document.querySelectorAll('.checkType');
    allCheckmarks.forEach(checkmark => {
        checkmark.classList.remove('checked');
    });
    selectedRadio.parentElement.querySelector('.checkType').classList.add('checked');

    // Update the URL to reflect the selected rental type without page reload
    const url = new URL(window.location.href);
    url.searchParams.set('rental_type', selectedRentalType);
    window.history.pushState({ path: url.href }, '', url.href);

    // Update the UI directly based on the selected rental type
    const properties = document.querySelectorAll('.property');
    properties.forEach(property => {
        const propertyType = property.dataset.type;
        if (propertyType === selectedRentalType.toLowerCase()) {
            property.style.display = 'block'; // Show the property if it matches the selected type
        } else {
            property.style.display = 'none'; // Hide the property if it doesn't match the selected type
        }
    });

    // Update the displayed rental type text
    const selectedRentalTypeElement = document.getElementById('selected_rental_type');
    selectedRentalTypeElement.textContent = `Showing ${selectedRentalType}`;
}

// Function to fetch property data based on rental type
function fetchPropertyData(rentalType) {
    // Fetch property data using AJAX or fetch
    fetch(`/propert-ease/rental-list.php?rental_type=${rentalType}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            // Update the property listings with the fetched data
            const properties = document.querySelectorAll('.property');
            properties.forEach(property => {
                property.innerHTML = data; // Update the content of each property
            });
        })
        .catch(error => {
            console.error('Error fetching property data:', error);
        });
}

// Initial setup to handle existing selected rental type on page load
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const showingType = urlParams.get('rental_type');

    // Select the appropriate radio button and fetch property data based on URL parameter
    if (showingType) {
        const selectedRadio = document.querySelector(`input[name="rental_type"][value="${showingType}"]`);
        if (selectedRadio) {
            selectedRadio.checked = true;
            handleRentalTypeChange(selectedRadio);
        }
    }
});