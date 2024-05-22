<?php
session_start();
    require_once('connect.php');
    
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $propertyId = $_GET['id'];
                $_SESSION['property_id'] = $propertyId;        
                if (isset($_SESSION['property_id'] )&& !empty($_SESSION['property_id'])) {
                    if (isset($_SESSION['tenant_id'])){
                        $response = array('success' => 'property-details.php');
                    }else{
                        $response = array('login' => 'Login to View Property');
                    }
                    
                } else {
                    $response = array('error' => 'Property not Found');
                }        
            } else {
                $response = array('error' => 'Property not Found.');
            }
        } else {
            http_response_code(405);
            $response = array('error' => 'Method Not Allowed.');
        }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
    
?>