<?php
$accessToken = 'pk.eyJ1IjoicHJvcGVydGVhc2UiLCJhIjoiY2xzaDF3bGcxMXE4ajJpcGMzajV6bG15MCJ9.NBAdRDSG_PNXxDIiuQW0bg';
$jsFunction = "
document.addEventListener('DOMContentLoaded', function() {
    var mapboxgl = window.mapboxgl;
    var accessToken = '" . $accessToken . "';

    mapboxgl.accessToken = accessToken;

    function initializeMap() {
        var officeAddressElement = document.getElementById('officeAddress');
        var officeAddress = officeAddressElement.textContent.trim();

        var savedCoordinates = localStorage.getItem('mapCoordinates');
        var savedZoom = localStorage.getItem('mapZoom');

        if (savedCoordinates && savedZoom) {
            savedCoordinates = JSON.parse(savedCoordinates);
            var coordinates = savedCoordinates;
            var zoom = parseFloat(savedZoom);
        } else {
            fetch('https://api.mapbox.com/geocoding/v5/mapbox.places/' + encodeURIComponent(officeAddress) + '.json?access_token=' + accessToken)
                .then(response => response.json())
                .then(data => {
                    if (data && data.features && data.features.length > 0) {
                        var coordinates = data.features[0].center;

                        // Save coordinates to local storage
                        localStorage.setItem('mapCoordinates', JSON.stringify(coordinates));

                        var map = new mapboxgl.Map({
                            container: 'map',
                            style: 'mapbox://styles/mapbox/streets-v11',
                            center: coordinates,
                            zoom: 15
                        });

                        new mapboxgl.Marker()
                            .setLngLat(coordinates)
                            .setPopup(new mapboxgl.Popup({
                                offset: 25,
                                closeButton: true,
                                closeOnClick: true
                            })
                            .setHTML(
                                '<div style=\"width: 200px; padding: 10px; background-color: #ffffff; border-radius: 5px; box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.15);\">' +
                                    '<h5 style=\"font-size: 16px; font-weight: bold; margin-bottom: 5px;\">Office Address</h5>' +
                                    '<p style=\"font-size: 14px; margin-bottom: 10px; color: #333;\">" . "' + officeAddress + '" . "</p>' +
                                '</div>'
                            ))
                            .addTo(map);

                    } else {
                        console.error('No coordinates found for the given address:', officeAddress);
                    }
                })
                .catch(error => {
                    console.error('Error fetching coordinates:', error);
                });
        }

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: coordinates,
            zoom: zoom
        });
    }

    // Call the function to initialize the map
    initializeMap();
});
";

$encodedFunction = base64_encode($jsFunction);

echo "<script>";
echo "eval(atob('" . $encodedFunction . "'));";
echo "</script>";
?>