<?php
if (isset($_GET['url'])) {
    $encodedUrl = $_GET['url'];
    $targetUrl = base64_decode(urldecode($encodedUrl));
    header("Location: $targetUrl");
    exit;
} else {
    // Handle error if 'url' parameter is missing
    echo "Invalid URL.";
}
?>