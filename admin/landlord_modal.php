<?php
// Connect to the database
require_once('../connect.php');
require_once('dashboard.php');

// Check if emp_id is set via POST
if (isset($_POST["emp_id"]))  
{ 
    // Get the landlord ID from POST data
    $landlordId = $_POST['emp_id'];

    // Prepare and execute SQL query to fetch landlord details
    $stmt2 = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
    $stmt2->execute([$landlordId]);
    $landlord = $stmt2->fetch(PDO::FETCH_ASSOC); 

    // Check if landlord details are found
    if ($landlord) {
        // Decrypt the encrypted fields using the encryption key
        $encryptionKey = $landlord['encryption_key']; // Assuming the encryption key is stored in the database

        $decryptedFullName = decryptData1($landlord['landlord_fname'], $encryptionKey) . ' ' . decryptData1($landlord['landlord_lname'], $encryptionKey);
        $decryptedAddress = decryptData1($landlord['landlord_address'], $encryptionKey);
        $decryptedContactNumber = decryptData1($landlord['landlord_contact'], $encryptionKey);
        $decryptedEmail = decryptData1($landlord['landlord_email'], $encryptionKey);

        // Construct the URL for the profile picture
        $profilePictureUrl = '../img/profile/' . $landlord['landlord_dp'];

        // Display the decrypted landlord details in the HTML structure
        echo '<div class="card-body">';
        echo '    <div class="mb-3">';
        echo '        <label for="landlordProfilePicture" class="form-label">Profile Picture:</label>';
        echo '        <div class="image-container">';
        echo '            <img id="landlordProfile" alt="Profile Picture" class="profile-picture" style="filter: blur(10px);" src="' . $profilePictureUrl . '">';
        echo '            <button id="viewLandlordIdButton" class="view-photo-btn" onclick="viewPhoto(\'landlordProfile\', \'viewLandlordProfileButton\')">View Photo</button>';
        echo '        </div>';
        echo '    </div>';
        echo '    <div class="mb-3">';
        echo '        <label for="landlordName" class="form-label">Fullname:</label>';
        echo '        <span id="landlordNameSpan">' . $decryptedFullName . '</span>';
        echo '    </div>';
        echo '    <div class="mb-3">';
        echo '        <label for="landlordAddress" class="form-label">Address:</label>';
        echo '        <span id="landlordAddressSpan">' . $decryptedAddress . '</span>';
        echo '    </div>';
        echo '    <div class="mb-3">';
        echo '        <label for="landlordContactNumber" class="form-label">Contact Number:</label>';
        echo '        <span id="landlordContactNumberSpan">' . $decryptedContactNumber . '</span>';
        echo '    </div>';
        echo '    <div class="mb-3">';
        echo '        <label for="landlordEmail" class="form-label">Email:</label>';
        echo '        <span id="landlordEmailSpan">' . $decryptedEmail . '</span>';
        echo '    </div>';
        echo '</div>';
    } else {
        // Display a message if landlord details are not found
        echo '<div class="card-body">';
        echo '    <p>Landlord details not found.</p>';
        echo '</div>';
    }
}
?>