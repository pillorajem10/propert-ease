<?php
// Replace this with logic to fetch latest message previews for each landlord from your database
// Sample response data
$previews = array(
    'Landlord 1' => 'Latest message preview 1...',
    'Landlord 2' => 'Latest message preview 2...',
    // Add more landlords and their previews as needed
);

echo json_encode($previews);
?>