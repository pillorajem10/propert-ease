<?php
require_once('connect.php');
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted data
    $review_description = $_POST['review_description'];
    $tenant_id= $_SESSION['tenant_id'];
    $landlord_id = $_POST['landlord_id'];
    $property_id = $_POST['property_id'];

    // Perform validation
    if (empty($review_description)) {
        // If review description is empty, show an error message and redirect back
        echo '<script>alert("Please provide a review description.");</script>';
        header("Location: property-details.php?id=$property_id");
        exit;
    }
    $stmt = $pdo->prepare("SELECT * FROM landlordreview_tbl WHERE tenant_id = ?");
    $stmt->execute([$tenant_id]); 

    if ($stmt->rowCount() > 0) {

        // Insert the review into the database
        $stmt = $pdo->prepare("UPDATE landlordreview_tbl SET review_description =?, landlord_id=?, property_id=? where tenant_id=?");
        $stmt->execute([$review_description, $landlord_id, $property_id, $tenant_id]);

        // Display an alert
        echo '<script>alert("Review submitted successfully!");</script>';

        // Optionally, you can redirect the user to a thank you page or back to the property details page
        header("Location: property-details.php");
    exit;
    } else {
        $stmt = $pdo->prepare("INSERT INTO landlordreview_tbl (review_description, landlord_id, property_id, tenant_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$review_description, $landlord_id, $property_id, $tenant_id]);

        // Display an alert
        echo '<script>alert("Review submitted successfully!");</script>';

        // Optionally, you can redirect the user to a thank you page or back to the property details page
        header("Location: property-details.php");
    exit;
    }
} else {
    // If the form is not submitted via POST method, redirect the user to the property details page
    header("Location: property-details.php?id=$property_id");
    exit;
}
?>