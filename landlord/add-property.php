<?php
session_start();
require_once('../connect.php');
require_once('includes/addproperty-function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propert-Ease</title>
    <!-- Include Bootstrap CSS, jQuery, and Popper.js -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- logo icon image/x-icon  -->
	<link rel="icon" href="img/icon.png" type="image/x-icon">
    <!-- Font Icons css -->
    <link rel="stylesheet" href="../css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="css/plugins.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/add-property.css">
    <link rel="stylesheet" href="css/alert.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <!-- Header with hamburger menu button -->
    <div class="header">
        <i id="sidebarCollapse" class="fas fa-bars" onclick="toggleSidebar()"></i>
        <h1 id="header"></h1>
    </div>

    <!-- Side menu bar -->
    <?php
    require_once 'sidemenu.php';
    ?>

    <!-- Main Content -->
    <main id="container" class="col-12">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h2 class="form-title mb-4">Add Listing Form</h2>
                    <!-- Property Listing Form -->
                    <form id="addPropertyForm" method="POST" enctype="multipart/form-data">
                        <!-- Property Details Section -->
                        <div class="mb-4">
                            <h5>Property Details</h5>
                            <div class="form-group">
                                <label for="title">Property Title:</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                                <div id="error-title" class="error-message" style ="display: none;"></div>
                            </div>
                            <div class="form-group">
                                <label for="description">Property Description:</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Enter Description" rows="4"></textarea>
                                <div id="error-description" class="error-message" style ="display: none;"></div>
                            </div>
                        </div>

                        <!-- Property Price Section -->
                        <div class="mb-4">
                            <h5>Property Price</h5>
                            <div class="form-group">
                                <div class="col">
                                    <label for="price">Price in ₱:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="number" class="form-control" id="price" name="price" min=1>
                                        <div id="error-price" class="error-message" style ="display: none;"></div>
                                    </div>
                                </div>
                                <div class="col mt-2">
                                    <label for="dueDate">Due Date:</label>
                                    <div class="input-group">
                                    <select class="form-control" id="dueDate" name="dueDate">
                                        <option value="30">30 days</option>
                                        <option value="15">15 days</option>
                                    </select>
                                    <div id="error-due" class="error-message" style ="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Select Category (Rental Type) Section -->
                        <div class="mb-4">
                            <h5>Select Category</h5>
                            <div class="form-group">
                                <label for="rentalType">Rental Type:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    </div>
                                    <select class="custom-select" id="rentalType" name="rentalType">
                                        <option value="house">House</option>
                                        <option value="apartment">Apartment</option>
                                    </select>
                                    <div id="error-type" class="error-message" style ="display: none;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Number of Occupancy Section -->
                        <div class="mb-4">
                            <h5>Number of Occupancy</h5>
                            <div class="form-group">
                                <label for="occupancy">Number of Occupancy:</label>
                                <input type="number" class="form-control" id="occupancy" name="occupancy" min=1>
                                <div id="error-occupancy" class="error-message" style ="display: none;"></div>
                            </div>
                        </div>

                        <!-- Listing Media Section -->
                        <div class="mb-4">
                            <h5>Listing Media</h5>
                            <div class="form-group">
                                <label for="propertyImage">Listing Image:</label>
                                <input type="file" class="form-control-file" id="propertyImage" name="propertyImage[]" accept="image/*" multiple onchange="showImages()">
                                <div id="error-image" class="error-message" style="display: none;"></div>
                                <ul id="imageList">
                                    <li class="form-text text-muted">
                                        <label>Image Requirement:</label>
                                        <p>At least 1 image is required for a valid submission. Minimum size is 500/500px.</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label for="propertyVideo">Listing Video:</label>
                                <input type="file" class="form-control-file" id="propertyVideo" name="propertyVideo" accept="video/*" onchange="showVideos()">
                                <div id="error-video" class="error-message" style ="display: none;"></div>
                                <ul id="videoList">
                                    <li class="form-text text-muted"><label>Video Requirement:</label><p>At least 1 video is required for a valid submission. Minimum resolution is 720p.</p></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Listing Location Section -->
                        <div class="mb-4">
                            <h5>Listing Location</h5>
                            <div class="form-row">
                                <div class="col">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                                    <div id="error-address" class="error-message" style ="display: none;"></div>
                                </div>
                                <div class="col">
                                    <label for="barangay">Barangay:</label>
                                    <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Enter Barangay">
                                    <div id="error-barangay" class="error-message" style ="display: none;"></div>
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col">
                                    <label for="city">City:</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter City">
                                    <div id="error-city" class="error-message" style ="display: none;"></div>
                                </div>
                                <div class="col">
                                    <label for="state">State/Province:</label>
                                    <input type="text" class="form-control" id="state" name="state" placeholder="Enter State/Province">
                                    <div id="error-province" class="error-message" style ="display: none;"></div>
                                </div>
                                <div class="col">
                                    <label for="zipCode">Zip Code:</label>
                                    <input type="text" class="form-control" id="zipCode" name="zipCode" placeholder="Enter Zip Code">
                                    <div id="error-code" class="error-message" style ="display: none;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Google Maps Section -->
                        <div class="mb-4">
                            <h5>Google Maps</h5>
                            <div id="map" style="height: 400px;"></div>
                        </div>

                        <!-- Proof of Ownership Section -->
                        <div class="mb-4">
                            <h5>Proof of Ownership</h5>
                            <div class="form-group">
                                <label for="ownershipDocument">Proof of Ownership Document:</label>
                                <input type="file" class="form-control-file" id="ownershipDocument" name="ownershipDocument" accept=".pdf, .doc, .docx" onchange="showDocuments()">
                                <div id="error-document" class="error-message" style ="display: none;"></div>
                                <ul id="documentList">
                                    <li class="form-text text-muted"><label>Document Type:</label><p>Property title or deed, with your name as the owner.</p></li>
                                    <li class="form-text text-muted"><label>Document Validity:</label><p>Current and not expired or revoked.</p></li>
                                    <li class="form-text text-muted"><label>Legibility:</label><p>Clear, legible, and free from alterations.</p></li>
                                    <li class="form-text text-muted"><label>File Format:</label><p>Uploaded in PDF format.</p></li>
                                    <li class="form-text text-muted"><label>File Size:</label><p>Does not exceed 10 MB.</p></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="text-center">
                            <button class="btn btn-primary text-uppercase px-4 py-2 mr-2" type="submit">Submit</button>
                            <button class="btn btn-secondary text-uppercase px-4 py-2" type="button" onclick="cancelForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<!-- All JS Plugins -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/function.js"></script>
    <script src="js/add-map.js"></script>
    <script src="js/add-property.js"></script>
    <script src="js/property-sweetalert.js"></script>
    <script src="js/sw-function.js"></script>
</html>