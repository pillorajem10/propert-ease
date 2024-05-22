mapboxgl.accessToken = 'pk.eyJ1IjoicHJvcGVydGVhc2UiLCJhIjoiY2xzaDF3bGcxMXE4ajJpcGMzajV6bG15MCJ9.NBAdRDSG_PNXxDIiuQW0bg';
    var coordinates = [<?php echo $longitude; ?>, <?php echo $latitude; ?>];

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/propertease/clsh1ng2500k001po5djpetqj',
        center: coordinates,
        zoom: 18
    });

    new mapboxgl.Marker()
    .setLngLat(coordinates)
    .setPopup(new mapboxgl.Popup().setHTML('<h5>Property Address</h5><p style="font-size: 12px; font-weight: bold; font-family: Arial, sans-serif;"><?php echo $completeAddressSentence; ?></p>'))
    .addTo(map);