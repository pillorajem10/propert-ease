<?php
session_start(); 


unset($_SESSION['landlord_id']);


header("Location: login.html");
exit();
?>