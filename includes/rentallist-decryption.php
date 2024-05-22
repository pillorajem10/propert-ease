<?php
$encryptionKey1 = $property['encryption_key'];
$propertyName = decryptData($property['property_name'], $encryptionKey1);
$propertyDescription = decryptData($property['property_description'], $encryptionKey1);
$propertyPrice = decryptData($property['property_price'], $encryptionKey1);
$propertyDue = $property['property_due'];
$propertyOccupancy = decryptData($property['property_occupancy'], $encryptionKey1);
$propertyAddress = decryptData($property['property_address'], $encryptionKey1);
$propertyBrgy = decryptData($property['property_brgy'], $encryptionKey1);
$propertyCity = decryptData($property['property_city'], $encryptionKey1);
$propertyProvince = decryptData($property['property_province'], $encryptionKey1);
$propertyZipcode = $property['property_zipcode'];
// $propertyType = decryptData($property['property_type'], $encryptionKey1);
$propertyImg = decryptData($property['property_img'], $encryptionKey1);
$propertyStatus = $property['property_status'];
$directory = 'img/';
$path = $directory . $propertyImg;
$propertyId = $property['property_id'];
$propertyDocu = decryptData($property['property_docu'], $encryptionKey1);
$directoryDoc = 'documents/';
$pathDoc =  $directoryDoc . $propertyDocu;
$dateProperty = $property['property_verifiedAt'];
$propertyVid = decryptData($property['property_vid'] , $encryptionKey1);
$directoryVid = 'vid/' ; 
$pathVid = $directoryVid . $propertyVid;
?>