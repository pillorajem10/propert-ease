<?php
require_once('../connect.php');

if(isset($_POST["emp_id"]))  
{ 
    // $query = "SELECT * FROM landlord_tbl WHERE id = '".$_POST["emp_id"]."'";  
    // $result = mysqli_query($connect, $query);  
    $tenantId = $_POST['emp_id'];
    $stmt2 = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id =?");
    $stmt2->execute([$tenantId]);
    $tenant = $stmt2->fetch(PDO::FETCH_ASSOC); 


    
    echo '<div class="mb-3">';
    echo '    <label for="proofType" class="form-label">Type of Proof of Identification:</label>';
    echo '    <span id="proofType">'.$tenant['tenant_idType'].'</span>';
    echo '</div>';
    echo '<div class="mb-3">';
    echo '    <label for="serialNum" class="form-label">Serial Number/License Number:</label>';
    echo '    <span id="serialNum">'.$tenant['tenant_serial'].'</span>';
    echo '</div>';
    echo '<div class="mb-3">';
    echo '    <label for="idPicture" class="form-label">Uploaded Picture of ID:</label>';
    echo '    <br>';
    echo '    <div class="image-container">';
    echo '        <img id="idPicture" alt="ID Image" class="id-image"  src="../img/id_pics/'.$tenant['tenant_idPic'].'">';
    // echo '        <button id="viewIdButton" class="view-photo-btn" onclick="viewPhoto(\'idPicture\', \'viewIdButton\')">View Photo</button>';
    echo '    </div>';
    echo '</div>';
    echo '<div class="mb-3">';
    echo '    <label for="selfieId" class="form-label">Uploaded Selfie Picture with ID:</label>';
    echo '    <br>';
    echo '    <div class="image-container">';
    echo '        <img id="selfieId" alt="Selfie with ID" class="id-image" src="../img/selfies/'.$tenant['tenant_selfie'].'" >';
    // echo '        <button id="viewSelfieButton" class="view-photo-btn" onclick="viewPhoto(\'selfieId\', \'viewSelfieButton\')">View Photo</button>';
    // style="filter: blur(10px);"
    echo '    </div>';
    echo '</div>';


  








}