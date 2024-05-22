<?php
session_start(); 


unset($_SESSION['tenant_id']);


header("Location: index.php");
exit();
?>