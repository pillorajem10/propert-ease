<?php
session_start();
if(isset($_SESSION['payment_data'])){
    $property = $_SESSION['payment_data']['propertyName'];
    $subTotal = $_SESSION['payment_data']['subtotal'];
    $tenantName = $_SESSION['payment_data']['fullname'];
}else{
    header('location:payment-management.php');
}
?>