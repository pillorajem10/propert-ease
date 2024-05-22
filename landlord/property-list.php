<?php
session_start();
require_once('../connect.php');
require_once('includes/propertylist-function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propert-Ease</title>
    <!-- Include Bootstrap CSS, jQuery, and Popper.js -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <link rel="stylesheet" href="css/property-listing.css">
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
            <div class="card" id="card">
                <div class="card-header">
                    <h2 class="card-title">Property Rental List</h2>
                    <div class="float-right">
                        <div class="input-group mb-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search properties..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="filterProperties()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <a href="add-property.php" class="btn btn-add ml-2">Add Listing</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="propertyList">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Property Details</th>
                                    <th>Location Details</th>
                                    <th>Rental Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Pagination and Search
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $perPage = 5;
                                $start = ($page - 1) * $perPage;
                                
                                $filteredProperties = $properties;
                                
                                // Apply search filter if search term is provided
                                if (isset($_GET['search']) && !empty($_GET['search'])) {
                                    $searchTerm = $_GET['search'];
                                    $filteredProperties = array_filter($properties, function($property) use ($searchTerm) {
                                        return stripos($property['property_name'], $searchTerm) !== false;
                                    });
                                }
                                
                                $totalProperties = count($filteredProperties);
                                $totalPages = ceil($totalProperties / $perPage);
                                
                                // Limit properties based on pagination
                                $paginatedProperties = array_slice($filteredProperties, $start, $perPage);

                                function decryptedData($data, $key)
                                {
                                    $data = base64_decode($data);
                                    $iv = substr($data, 0, 16);
                                    $encryptedData = substr($data, 16);
                                    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
                                }
                                
                                // Display paginated properties
                                foreach ($paginatedProperties as $index => $property) {
                                    require('includes/property-decryption.php');
                                    ?>
                                    <tr>
                                        <td><?= $start + $index + 1 ?></td>
                                        <td>
                                            <!-- Property Details -->
                                            <div class="card-title"><strong>Property Title:</strong> <?= $propertyName ?><br></div>
                                            <strong>Property Description:</strong> <?= $propertyDescription ?><br>
                                            <strong>Property Price:</strong>₱<?= $propertyPrice ?><br>
                                            <strong>Due Date:</strong> <?= $propertyDue ?> days<br>
                                            <strong>Number of Occupancy:</strong> <?= $propertyOccupancy ?>
                                        </td>
                                        <td>
                                            <!-- Location Details -->
                                            <strong>Address:</strong> <?= $propertyAddress ?><br>
                                            <strong>Barangay/LGU:</strong> <?= $propertyBrgy ?><br>
                                            <strong>Municipality/City:</strong> <?= $propertyCity ?><br>
                                            <strong>State/Province:</strong> <?= $propertyProvince ?><br>
                                            <strong>Zip Code:</strong> <?= $propertyZipcode ?>
                                        </td>
                                        <td class="rental-type-cell">
                                            <p class="card-type"><?= $propertyType ?></p>
                                        </td>
                                        <td class="status-cell">
                                            <?php
                                            $propertyStatus = $property['property_status'];
                                            if ($propertyStatus === 'Active') {
                                                echo '<p class="status-active">' . $property['property_status'] . '</p>';
                                            } elseif ($propertyStatus === 'Pending') {
                                                echo '<p class="status-pending">' . $property['property_status'] . '</p>';
                                            } elseif ($propertyStatus === 'Removing') {
                                                echo '<p class="status-removing">' . $property['property_status'] . '</p>';
                                            } else {
                                                echo '<p class="status-rejected">' . $property['property_status'] . '</p>';
                                            } 
                                            ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <!-- "Preview" Button with data-toggle and data-target attributes -->
                                                <a href="#" class="btn btn-preview" data-toggle="modal" data-target="#propertyModal<?= $property['property_id'] ?>">Preview</a>
                                                <a href="edit-property.php?id=<?= $property['property_id'] ?>" class="btn btn-edit">Edit</a>
                                                <?php if ($propertyStatus === 'Rejected' || $propertyStatus === 'Pending'): ?>
                                                    <a href="delete-value.php?id=<?= $property['property_id'] ?>" class="btn btn-delete">Delete</a>
                                                <?php else:?>
                                                    <a href="delete-property.php?id=<?= $property['property_id'] ?>" class="btn btn-delete">Delete</a>
                                                    <a href="tenant-management.php?id=<?= $property['property_id'] ?>" class="btn btn-view">View Tenants</a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Modal for Property Details -->
                                    <?php if ($property): ?>
                                        <div class="modal fade" id="propertyModal<?= $property['property_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="propertyModalLabel<?= $property['property_id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                        <h2 class="modal-title text-dark p-3" id="propertyModalLabel<?= $property['property_id'] ?>">Property Details</h2>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <!-- Display Property Image -->
                                                                    <img src="<?= $path ?>" class="img-fluid" alt="Property Image">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- Display Property Details -->
                                                                    <h4><strong>Title:</strong> <?= $propertyName ?></h4>
                                                                    <p><strong>Location:</strong> <?= $propertyAddress ?>, <?= $propertyBrgy ?>, <?= $propertyCity ?>, <?= $propertyProvince ?>, <?= $propertyZipcode ?></p>
                                                                    <p><strong>Description:</strong> <?= $propertyDescription ?></p>
                                                                    <p><strong>Price (₱):</strong> <?= $propertyPrice ?></p>
                                                                    <p><strong>No. of Tenants:</strong> <?= $property['property_tenants'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="modal fade" id="propertyModal" tabindex="-1" role="dialog" aria-labelledby="propertyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                        <h2 class="modal-title text-dark p-3" id="propertyModalLabel<?= $property['property_id'] ?>">Property Details</h2>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                <p>Sorry, no property data was found.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php $page - 1; ?>" tabindex="-1" aria-disabled="true" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                                <li class="page-item <?= ($page == $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <!-- Modal for Property Details -->
    <div class="modal fade" id="propertyModal" tabindex="-1" role="dialog" aria-labelledby="propertyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2 class="modal-title text-dark p-3" id="propertyModalLabel">Property Details</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Display Property Image -->
                                <img id="modalImage" src="<?= $path ?>" class="img-fluid" alt="Property Image">
                            </div>
                            <div class="col-md-6">
                                <!-- Display Property Details -->
                                <h4><strong>Title:</strong> <span id="modalTitle"><?= $propertyName ?></span></h4>
                                <p><strong>Location:</strong> <span id="modalLocation"><?= $propertyAddress ?>, <?= $propertyBrgy ?>, <?= $propertyCity ?>, <?= $propertyProvince ?>, <?= $propertyZipcode ?></span></p>
                                <p><strong>Description:</strong> <span id="modalDescription"><?= $propertyDescription ?></span></p>
                                <p><strong>Price (₱):</strong> <span id="modalRate"><?= $propertyPrice ?></span></p>
                                <p><strong>No. of Tenants:</strong> <span id="modalNumber"><?= $property['property_tenants'] ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CHAT AREA START -->
    <?php
    require_once 'chat-support.php';
    ?>
    <!-- CHAT AREA END -->

    <!-- All JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/sidebar.js"></script>
    <!-- <script src="js/property-modal.js"></script> -->
    <script src="js/property-function.js"></script>
    <script src="js/function.js"></script>
    <script src="js/location.js"></script>
    <script src="js/property-sweetalert.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/sw-function.js"></script>
</body>
</html>