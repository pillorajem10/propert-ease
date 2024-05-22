<?php
$accessToken = 'pk.eyJ1IjoicHJvcGVydGVhc2UiLCJhIjoiY2xzaDF3bGcxMXE4ajJpcGMzajV6bG15MCJ9.NBAdRDSG_PNXxDIiuQW0bg';
$coordinates = '[' . htmlspecialchars($longitude, ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars($latitude, ENT_QUOTES, 'UTF-8') . ']';
$encodedAddress = htmlspecialchars($completeAddressSentence, ENT_QUOTES, 'UTF-8');
$mapboxUrl = htmlspecialchars($mapboxUrl, ENT_QUOTES, 'UTF-8');

$jsFunction = "
(function() {
function initializeMap() {
var mapboxgl = window.mapboxgl;
var accessToken = atob('" . base64_encode($accessToken) . "');
var coordinates = " . $coordinates . ";
var encodedAddress = atob('" . base64_encode($encodedAddress) . "');
var mapboxUrl = atob('" . base64_encode($mapboxUrl) . "');

mapboxgl.accessToken = accessToken;

var map = new mapboxgl.Map({container:'map',style:'mapbox://styles/propertease/clsh1ng2500k001po5djpetqj',center:coordinates,zoom:18});var marker=new mapboxgl.Marker().setLngLat(coordinates).setPopup(new mapboxgl.Popup().setHTML('<h5>Property Address</h5><p style=\"font-size:12px;font-weight:bold;font-family:Arial,sans-serif;\">'+encodedAddress+'</p>'));var mapboxIframe=document.getElementById('mapboxIframe');mapboxIframe.src=mapboxUrl;mapboxIframe.addEventListener('load',function(){var iframeWindow=mapboxIframe.contentWindow;var mapData={accessToken:accessToken,coordinates:coordinates,encodedAddress:encodedAddress};iframeWindow.postMessage(mapData,'*');marker.addTo(map);});}document.addEventListener('DOMContentLoaded',initializeMap);})()";

echo "<script>";
echo "eval(atob('" . base64_encode($jsFunction) . "'));";
echo "</script>";
?>