document.addEventListener("DOMContentLoaded", function () {
  mapboxgl.accessToken =
    "pk.eyJ1IjoicHJvcGVydGVhc2UiLCJhIjoiY2xzaDF3bGcxMXE4ajJpcGMzajV6bG15MCJ9.NBAdRDSG_PNXxDIiuQW0bg";

  $(document).ready(function () {
    function updateMap() {
      var address = $("#address").val();
      var barangay = $("#barangay").val();
      var city = $("#city").val();
      var state = $("#state").val();
      var zipCode = $("#zipCode").val();

      if (!address && !barangay && !city && !state && !zipCode) {
        if (map) {
          map.remove();
        }

        var map = new mapboxgl.Map({
          container: "map",
          style: "mapbox://styles/propertease/clsh1ng2500k001po5djpetqj",
          center: [120.9842, 14.5995],
          zoom: 18,
        });

        return;
      }

      var locationQuery = encodeURIComponent(
        address + ", " + barangay + ", " + city + ", " + state + ", " + zipCode
      );

      $.ajax({
        url:
          "https://api.mapbox.com/geocoding/v5/mapbox.places/" +
          locationQuery +
          ".json",
        method: "GET",
        data: {
          access_token: mapboxgl.accessToken,
        },
        success: function (response) {
          var coordinates = response.features[0].geometry.coordinates;

          if (map) {
            map.remove();
          }

          var completeAddress =
            address +
            ", " +
            barangay +
            ", " +
            city +
            ", " +
            state +
            ", " +
            zipCode;

          var map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/propertease/clsh1ng2500k001po5djpetqj",
            center: coordinates,
            zoom: 18,
          });

          new mapboxgl.Marker()
            .setLngLat(coordinates)
            .setPopup(
              new mapboxgl.Popup().setHTML(
                '<h5>Property Address</h5><p style="font-size: 12px; font-weight: bold; font-family: Arial, sans-serif;">' +
                  completeAddress +
                  "</p>"
              )
            )
            .addTo(map);
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);
        },
      });
    }

    $("#address, #barangay, #city, #state, #zipCode").on("input", updateMap);

    updateMap();
  });
});