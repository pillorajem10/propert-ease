document.addEventListener("DOMContentLoaded", function () {
  var rentalTypeRadios = document.querySelectorAll('input[name="rental_type"]');
  rentalTypeRadios.forEach(function (radio) {
      radio.addEventListener("click", function () {
          filterProperties(this.value);
          updateRentalType();
      });
  });

  // Load property list by default
  filterProperties("");
  updateRentalType();
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
  var properties = document.getElementsByClassName("col-xl-6");
  // Limit the price range to 0-5000
  minPrice = Math.min(5000, Math.max(0, minPrice));
  maxPrice = Math.min(5000, Math.max(0, maxPrice));
  document.getElementById("price_range").textContent =
      "₱" + minPrice + " - ₱" + maxPrice;

  for (var i = 0; i < properties.length; i++) {
      var propertyPrice = parseInt(
          properties[i]
              .querySelector(".card-body .card-text:last-child")
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
}

function updateRentalType() {
  var selectedRentalType = document.querySelector(
      'input[name="rental_type"]:checked'
  ).value;
  document.getElementById("selected_rental_type").textContent =
      selectedRentalType;
}

document.getElementById("min_price").addEventListener("input", function () {
  filterProperties();
  updatePriceRange();
});

document.getElementById("max_price").addEventListener("input", function () {
  filterProperties();
  updatePriceRange();
});