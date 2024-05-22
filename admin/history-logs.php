<?php
session_start();
require_once('../connect.php');
require_once('includes/security.php');
require_once('includes/history-function.php')
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
    <link rel="stylesheet" href="css/history-logs.css">
    <link rel="stylesheet" href="css/historylogs-card.css">
    <link rel="stylesheet" href="css/historylogs-button.css">
    <link rel="stylesheet" href="css/dropdown-menu.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <!-- Header with hamburger menu button -->
    <div class="header">
        <i id="sidebarCollapse" class="fas fa-bars" onclick="toggleSidebar()"></i>
        <h1 id="header">History Logs</h1>
    </div>

    <!-- Side menu bar -->
    <?php
    require_once 'sidemenu.php';
    ?>

    <!-- Main Content -->
    <main id="content" class="col-12">
        <div class="container-fluid bg-light py-2">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <nav class="nav nav-pills nav-justified">
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav1" href="#" onclick="showSection('container1', 'nav1'); return false;">Verified Properties</a>
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav2" href="#" onclick="showSection('container2', 'nav2'); return false;">Verified Landlords</a>
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav3" href="#" onclick="showSection('container3', 'nav3'); return false;">Verified Tenants</a>
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav4" href="#" onclick="showSection('container4', 'nav4'); return false;">Banned Landlords</a>
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav5" href="#" onclick="showSection('container5', 'nav5'); return false;">Banned Tenants</a>
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav6" href="#" onclick="showSection('container6', 'nav6'); return false;">Paid Tenants</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container1">
            <div class="input-group mb-3">
                <input type="text" id="searchInput1" class="form-control" placeholder="Search verified properties..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterVerifiedProperties()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">History of Verified Properties</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="verifiedpropertyList">
                        <?php
                        // Determine current page number
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Number of records per page
                        $recordsPerPage = 3;

                        // Calculate for the SQL LIMIT clause
                        $start = ($page - 1) * $recordsPerPage;

                        // Fetch verified properties data from the database with pagination
                        $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_verifiedAt IS NOT NULL LIMIT :start, :limit");
                        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                        $stmt->execute();
                        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get total number of verified properties
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM property_tbl WHERE property_verifiedAt IS NOT NULL");
                        $stmt->execute();
                        $totalProperties = $stmt->fetchColumn();

                        // Calculate total pages
                        $totalPages = ceil($totalProperties / $recordsPerPage);

                        if ($properties) {
                            foreach ($properties as $property) {
                                require('includes/property-decryption.php');
                            ?>
                            <div class="card1 col-6 col-sm-4 mb-4">
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <img src="<?= $path ?>" class="card-img-top property-img mx-auto" style="object-fit: cover; width: 100%; height: 300px;" alt="Property Image">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="card-title" style="font-weight: bold;">Property: <span style="font-weight: normal; text-transform: capitalize;"><?= $propertyName ?></span></h5>
                                        <p class="card-text" style="font-weight: bold;">Location: <span style="font-weight: normal; text-transform: capitalize;"><?= $propertyCity ?></span></p>
                                        <p class="card-text" style="font-weight: bold;">Date: <span style="font-weight: normal; text-transform: capitalize;">
                                        <?php
                                        // Check if the date exists and is not empty
                                        if (isset($propertyDate) && !empty($propertyDate)) {
                                            // Format the date
                                            $formattedDate = date('F j, Y', strtotime($propertyDate));
                                            // Output the formatted date
                                            echo '<span class="mb-0">' . $formattedDate . '</span>';
                                        } else {
                                            // If the date is not available or empty, display a default message
                                            echo '<span class="text-muted mb-0">Date not available</span>';
                                        }
                                        ?>
                                        </span></p>
                                    </div>
                                    <div class="card-footer w-100">
                                        <div class="row action-buttons text-center">
                                            <div class="col-md-6 col-12 mb-3">
                                                <button name="property_modal"class="btn btn-primary btn-block review-button" onclick="openPropertyModal(<?=$propertyId?>)">Proof of Ownership</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-center">No verified properties found</p></div>';
                        }
                        ?>
                    </div>
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage1" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <div class="card-footer" style="background-color: #f8f9fa; color: #333; border-top: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                                        <label for="recordsRange" class="mb-0"><strong>Records:</strong></label>
                                        <input type="text" id="recordsRange" class="form-control form-control-sm record-range" value="<?= $start + 1 ?> - <?= min($start + $recordsPerPage, $totalProperties) ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="totalRecords" class="mb-0"><strong>Total Records:</strong></label>
                                        <input type="text" id="totalRecords" class="form-control form-control-sm total-record" value="<?= $totalProperties ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="pageSelect"><strong>Page:</strong></label>
                                            </div>
                                            <select class="custom-select" id="pageSelect" style="background-color: #fff; color: #333;">
                                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                                    <option value="<?= $i ?>" <?= ($page == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="limitSelect"><strong>Limit:</strong></label>
                                            </div>
                                            <select class="custom-select" id="limitSelect" style="background-color: #fff; color: #333;">
                                                <option value="3" <?= ($recordsPerPage == 3) ? 'selected' : '' ?>>3</option>
                                                <option value="6" <?= ($recordsPerPage == 6) ? 'selected' : '' ?>>6</option>
                                                <option value="12" <?= ($recordsPerPage == 12) ? 'selected' : '' ?>>12</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="pagination justify-content-center mt-2" style="background-color: #fff; border-radius: 20px;">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="history-logs.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="history-logs.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="history-logs.php?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Modal for Modal for Proof of Ownership -->
            <div class="modal fade" id="verifiedPropertyModal" tabindex="-1" role="dialog" aria-labelledby="verifiedPropertyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h3 class="modal-title text-dark p-3" id="verifiedPropertyModalLabel">Proof of Ownership:</h3>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-body">
                            <div class="mb-3">
                                <label for="file" class="form-label">Uploaded File Attachment:</label>
                                <br>
                                <div class="image-container" id="image-container">
                                    <div id="fileAttachment" class="ownership-image">
                                    </div>               
                                    <button id="viewFileButton" class="view-file-btn" onclick="viewFileProperty('fileAttachment', 'viewFileButton')">View File</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container2">
            <div class="input-group mb-3">
                <input type="text" id="searchInput2" class="form-control" placeholder="Search verified landlords..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterVerifiedLandlords()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">History of Verified Landlords</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="verifiedlandlordList">
                        <?php
                        // Determine current page number
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Number of records per page
                        $recordsPerPage = 3;

                        // Calculate for the SQL LIMIT clause
                        $start = ($page - 1) * $recordsPerPage;

                        // Fetch verified landlords data from the database with pagination
                        $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_verifiedAt LIMIT :start, :limit");
                        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                        $stmt->execute();
                        $landlords = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get total number of verified landlords
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM landlord_tbl WHERE landlord_verifiedAt");
                        $stmt->execute();
                        $totalLandlords = $stmt->fetchColumn();

                        // Calculate total pages
                        $totalPages = ceil($totalLandlords / $recordsPerPage);

                        if ($landlords) {
                            foreach ($landlords as $landlord) {
                                require('includes/landlord-decryption.php');
                            ?>
                            <div class="card2 col-6 col-sm-4 mb-4">
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <img src="<?= $imagePath ?>" class="card-img-top landlord-img mx-auto mt-3" alt="Landlord Profile" style="width: 150px; height: auto; border-radius: 50%;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="card-title text-center"><?= $landlordFname . ' ' . $landlordLname ?></h5>
                                        <div class="card-footer w-100">
                                            <p class="card-text date" style="font-weight: bold;">Verified Date:<br><span style="font-weight: normal">
                                            <?php
                                            // Check if the date exists and is not empty
                                            if (isset($landlordDate) && !empty($landlordDate)) {
                                                // Format the date
                                                $formattedDate = date('F j, Y', strtotime($landlordDate));
                                                // Output the formatted date
                                                echo '<span class="mb-0">' . $formattedDate . '</span>';
                                            } else {
                                                // If the date is not available or empty, display a default message
                                                echo '<span class="text-muted mb-0">Date not available</span>';
                                            }
                                            ?>
                                            </span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-center">No verified landlords found</p></div>';
                        }
                        ?>
                    </div>
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage2" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <div class="card-footer" style="background-color: #f8f9fa; color: #333; border-top: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                                        <label for="recordsRange" class="mb-0"><strong>Records:</strong></label>
                                        <input type="text" id="recordsRange" class="form-control form-control-sm record-range" value="<?= $start + 1 ?> - <?= min($start + $recordsPerPage, $totalLandlords) ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="totalRecords" class="mb-0"><strong>Total Records:</strong></label>
                                        <input type="text" id="totalRecords" class="form-control form-control-sm total-record" value="<?= $totalLandlords ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="pageSelect"><strong>Page:</strong></label>
                                            </div>
                                            <select class="custom-select" id="pageSelect" style="background-color: #fff; color: #333;">
                                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                                    <option value="<?= $i ?>" <?= ($page == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="limitSelect"><strong>Limit:</strong></label>
                                            </div>
                                            <select class="custom-select" id="limitSelect" style="background-color: #fff; color: #333;">
                                                <option value="3" <?= ($recordsPerPage == 3) ? 'selected' : '' ?>>3</option>
                                                <option value="6" <?= ($recordsPerPage == 6) ? 'selected' : '' ?>>6</option>
                                                <option value="12" <?= ($recordsPerPage == 12) ? 'selected' : '' ?>>12</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="pagination justify-content-center mt-2" style="background-color: #fff; border-radius: 20px;">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="histpry-logs.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="history-logs.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="history-logs.php?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container3">
            <div class="input-group mb-3">
                <input type="text" id="searchInput3" class="form-control" placeholder="Search verified tenants..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterVerifiedTenants()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">History of Verified Tenants</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="verifiedtenantList">
                        <?php
                        // Determine current page number
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Number of records per page
                        $recordsPerPage = 3;

                        // Calculate for the SQL LIMIT clause
                        $start = ($page - 1) * $recordsPerPage;

                        // Fetch verified tenants data from the database with pagination
                        $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_verifiedAt LIMIT :start, :limit");
                        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                        $stmt->execute();
                        $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get total number of verified tenants
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tenant_tbl WHERE tenant_verifiedAt");
                        $stmt->execute();
                        $totalTenants = $stmt->fetchColumn();

                        // Calculate total pages
                        $totalPages = ceil($totalTenants / $recordsPerPage);

                        if ($tenants) {
                            foreach ($tenants as $tenant) {
                                require('includes/tenant-decryption.php');
                            ?>
                            <div class="card3 col-6 col-sm-4 mb-4">
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <img src="<?= $tenantDp ?>" class="card-img-top tenant-img mx-auto mt-3" alt="Tenant Profile" style="width: 150px; height: auto; border-radius: 50%;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="card-title text-center"><?= $tenantFname . ' ' . $tenantLname ?></h5>
                                        <div class="card-footer w-100">
                                            <p class="card-text date" style="font-weight: bold;">Verified Date:<br><span style="font-weight: normal">
                                            <?php
                                            // Check if the date exists and is not empty
                                            if (isset($tenantDate) && !empty($tenantDate)) {
                                                // Format the date
                                                $formattedDate = date('F j, Y', strtotime($tenantDate));
                                                // Output the formatted date
                                                echo '<span class="mb-0">' . $formattedDate . '</span>';
                                            } else {
                                                // If the date is not available or empty, display a default message
                                                echo '<span class="text-muted mb-0">Date not available</span>';
                                            }
                                            ?>
                                            </span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-center">No verified tenants found</p></div>';
                        }
                        ?>
                    </div>
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage3" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <div class="card-footer" style="background-color: #f8f9fa; color: #333; border-top: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                                        <label for="recordsRange" class="mb-0"><strong>Records:</strong></label>
                                        <input type="text" id="recordsRange" class="form-control form-control-sm record-range" value="<?= $start + 1 ?> - <?= min($start + $recordsPerPage, $totalTenants) ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="totalRecords" class="mb-0"><strong>Total Records:</strong></label>
                                        <input type="text" id="totalRecords" class="form-control form-control-sm total-record" value="<?= $totalTenants ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="pageSelect"><strong>Page:</strong></label>
                                            </div>
                                            <select class="custom-select" id="pageSelect" style="background-color: #fff; color: #333;">
                                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                                    <option value="<?= $i ?>" <?= ($page == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="limitSelect"><strong>Limit:</strong></label>
                                            </div>
                                            <select class="custom-select" id="limitSelect" style="background-color: #fff; color: #333;">
                                                <option value="3" <?= ($recordsPerPage == 3) ? 'selected' : '' ?>>3</option>
                                                <option value="6" <?= ($recordsPerPage == 6) ? 'selected' : '' ?>>6</option>
                                                <option value="12" <?= ($recordsPerPage == 12) ? 'selected' : '' ?>>12</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="pagination justify-content-center mt-2" style="background-color: #fff; border-radius: 20px;">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="history-logs.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="history-logs.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="history-logs.php?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container4">
            <div class="input-group mb-3">
                <input type="text" id="searchInput4" class="form-control" placeholder="Search banned landlords..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterBannedLandlords()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">History of Banned Landlords</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="bannedlandlordList">
                        <?php
                        // Determine current page number
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Number of records per page
                        $recordsPerPage = 3;

                        // Calculate for the SQL LIMIT clause
                        $start = ($page - 1) * $recordsPerPage;

                        // Fetch banned landlords data from the database with pagination
                        $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_role = 'banned' AND landlord_bannedAt IS NULL LIMIT :start, :limit");
                        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                        $stmt->execute();
                        $landlords = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get total number of banned landlords
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM landlord_tbl WHERE landlord_role = 'banned' AND landlord_bannedAt IS NULL");
                        $stmt->execute();
                        $totalLandlords = $stmt->fetchColumn();

                        // Calculate total pages
                        $totalPages = ceil($totalLandlords / $recordsPerPage);

                        if ($landlords) {
                            foreach ($landlords as $landlord) {
                                $landlordDate = date('F j, Y', strtotime($landlord['landlord_bannedAt']));
                                require_once('includes/landlord-decryption.php');
                            ?>
                            <div class="card4 col-6 col-sm-4 mb-4">
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <img src="<?= $imagePath ?>" class="card-img-top landlord-img mx-auto mt-3" alt="Landlord Profile" style="width: 150px; height: auto; border-radius: 50%;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="card-title text-center"><?= $landlordFname . ' ' . $landlordLname ?></h5>
                                        <div class="card-footer w-100">
                                            <p class="card-text date" style="font-weight: bold;">Banned Date:<br><span style="font-weight: normal">
                                            <?php
                                            // Check if the date exists and is not empty
                                            if (isset($landlordDate) && !empty($landlordDate)) {
                                                // Format the date
                                                $formattedDate = date('F j, Y', strtotime($landlordDate));
                                                // Output the formatted date
                                                echo '<span class="mb-0">' . $formattedDate . '</span>';
                                            } else {
                                                // If the date is not available or empty, display a default message
                                                echo '<span class="text-muted mb-0">Date not available</span>';
                                            }
                                            ?>
                                            </span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-center">No banned landlords found</p></div>';
                        }
                        ?>
                    </div>
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage4" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <div class="card-footer" style="background-color: #f8f9fa; color: #333; border-top: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                                        <label for="recordsRange" class="mb-0"><strong>Records:</strong></label>
                                        <input type="text" id="recordsRange" class="form-control form-control-sm record-range" value="<?= $start + 1 ?> - <?= min($start + $recordsPerPage, $totalLandlords) ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="totalRecords" class="mb-0"><strong>Total Records:</strong></label>
                                        <input type="text" id="totalRecords" class="form-control form-control-sm total-record" value="<?= $totalLandlords ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="pageSelect"><strong>Page:</strong></label>
                                            </div>
                                            <select class="custom-select" id="pageSelect" style="background-color: #fff; color: #333;">
                                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                                    <option value="<?= $i ?>" <?= ($page == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="limitSelect"><strong>Limit:</strong></label>
                                            </div>
                                            <select class="custom-select" id="limitSelect" style="background-color: #fff; color: #333;">
                                                <option value="3" <?= ($recordsPerPage == 3) ? 'selected' : '' ?>>3</option>
                                                <option value="6" <?= ($recordsPerPage == 6) ? 'selected' : '' ?>>6</option>
                                                <option value="12" <?= ($recordsPerPage == 12) ? 'selected' : '' ?>>12</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="pagination justify-content-center mt-2" style="background-color: #fff; border-radius: 20px;">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="history-logs.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="history-logs.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="history-logs.php?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container5">
            <div class="input-group mb-3">
                <input type="text" id="searchInput5" class="form-control" placeholder="Search banned tenants..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterBannedTenants()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">History of Banned Tenants</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="bannedtenantList">
                        <?php
                        // Determine current page number
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Number of records per page
                        $recordsPerPage = 3;

                        // Calculate for the SQL LIMIT clause
                        $start = ($page - 1) * $recordsPerPage;

                        // Fetch banned tenants data from the database with pagination
                        $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_role = 'banned' AND tenant_bannedAt IS NULL LIMIT :start, :limit");
                        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                        $stmt->execute();
                        $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get total number of banned tenants
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tenant_tbl WHERE tenant_role = 'banned' AND tenant_bannedAt IS NULL");
                        $stmt->execute();
                        $totalTenants = $stmt->fetchColumn();

                        // Calculate total pages
                        $totalPages = ceil($totalTenants / $recordsPerPage);

                        if ($tenants) {
                            foreach ($tenants as $tenant) {
                                $tenantDate = date('F j, Y', strtotime($tenant['tenant_bannedAt']));
                                require_once('includes/tenant-decryption.php');
                            ?>
                            <div class="card5 col-6 col-sm-4 mb-4">
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <img src="<?= $tenantDp ?>" class="card-img-top tenant-img mx-auto mt-3" alt="Tenant Profile" style="width: 150px; height: auto; border-radius: 50%;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="card-title text-center"><?= $tenantFname . ' ' . $tenantLname ?></h5>
                                        <div class="card-footer w-100">
                                            <p class="card-text date" style="font-weight: bold;">Banned Date:<br><span style="font-weight: normal">
                                            <?php
                                            // Check if the date exists and is not empty
                                            if (isset($tenantDate) && !empty($tenantDate)) {
                                                // Format the date
                                                $formattedDate = date('F j, Y', strtotime($tenantDate));
                                                // Output the formatted date
                                                echo '<span class="mb-0">' . $formattedDate . '</span>';
                                            } else {
                                                // If the date is not available or empty, display a default message
                                                echo '<span class="text-muted mb-0">Date not available</span>';
                                            }
                                            ?>
                                            </span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-center">No banned tenants found</p></div>';
                        }
                        ?>
                    </div>
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage5" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <div class="card-footer" style="background-color: #f8f9fa; color: #333; border-top: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                                        <label for="recordsRange" class="mb-0"><strong>Records:</strong></label>
                                        <input type="text" id="recordsRange" class="form-control form-control-sm record-range" value="<?= $start + 1 ?> - <?= min($start + $recordsPerPage, $totalTenants) ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="totalRecords" class="mb-0"><strong>Total Records:</strong></label>
                                        <input type="text" id="totalRecords" class="form-control form-control-sm total-record" value="<?= $totalTenants ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="pageSelect"><strong>Page:</strong></label>
                                            </div>
                                            <select class="custom-select" id="pageSelect" style="background-color: #fff; color: #333;">
                                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                                    <option value="<?= $i ?>" <?= ($page == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="limitSelect"><strong>Limit:</strong></label>
                                            </div>
                                            <select class="custom-select" id="limitSelect" style="background-color: #fff; color: #333;">
                                                <option value="3" <?= ($recordsPerPage == 3) ? 'selected' : '' ?>>3</option>
                                                <option value="6" <?= ($recordsPerPage == 6) ? 'selected' : '' ?>>6</option>
                                                <option value="12" <?= ($recordsPerPage == 12) ? 'selected' : '' ?>>12</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="pagination justify-content-center mt-2" style="background-color: #fff; border-radius: 20px;">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="history-logs.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="history-logs.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="history-logs.php?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container6">
            <div class="input-group mb-3">
                <input type="text" id="searchInput6" class="form-control" placeholder="Search paid tenants...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterPaidTenants()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">History of Paid Tenants</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="paidtenantList">
                        <?php
                        // Determine current page number
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Number of records per page
                        $recordsPerPage = 3;

                        // Calculate for the SQL LIMIT clause
                        $start = ($page - 1) * $recordsPerPage;

                        // Fetch paid tenants data from the database with pagination
                        $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_status = 'paid' AND tenant_dueDate IS NOT NULL LIMIT :start, :limit");
                        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                        $stmt->execute();
                        $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get total number of paid tenants
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tenant_tbl WHERE tenant_status = 'paid' AND tenant_dueDate IS NOT NULL");
                        $stmt->execute();
                        $totalTenants = $stmt->fetchColumn();

                        // Calculate total pages
                        $totalPages = ceil($totalTenants / $recordsPerPage);

                        if ($tenants) {
                            foreach ($tenants as $tenant) {
                                require('includes/tenant-decryption.php');
                            ?>
                            <div class="card5 col-6 col-sm-4 mb-4">
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <img src="<?= $tenantDp ?>>" class="card-img-top tenant-img mx-auto mt-3" alt="Tenant Profile" style="width: 150px; height: auto; border-radius: 50%;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="card-title text-center mb-4"><?= $tenantFname . ' ' . $tenantLname ?></h5>
                                        <p class="card-text date text-center" style="font-weight: bold;">
                                            Due Date:<br>
                                            <span style="font-weight: normal">
                                                <?php
                                                // Check if the date exists and is not empty
                                                if (isset($tenantDue) && !empty($tenantDue)) {
                                                    // Format the date
                                                    $formattedDate = date('F j, Y', strtotime($tenantDue));
                                                    // Output the formatted date
                                                    echo '<span class="mb-0">' . $formattedDate . '</span>';
                                                } else {
                                                    // If the date is not available or empty, display a default message
                                                    echo '<span class="text-muted mb-0">Date not available</span>';
                                                }
                                                ?>
                                            </span>
                                        </p>
                                        <div class="card-footer w-100">
                                            <p class="card-text text-center">
                                                <strong>Status:</strong>
                                                <?php
                                                if ($tenantStatus === 'paid') {
                                                    echo '<span class="badge badge-success text-capitalize">' . $tenantStatus . '</span>';
                                                } else {
                                                    echo '<span class="badge badge-info text-capitalize">' . $tenantStatus . '</span>';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-center">No paid tenants found</p></div>';
                        }
                        ?>
                    </div>
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage6" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <div class="card-footer" style="background-color: #f8f9fa; color: #333; border-top: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                                        <label for="recordsRange" class="mb-0"><strong>Records:</strong></label>
                                        <input type="text" id="recordsRange" class="form-control form-control-sm record-range" value="<?= $start + 1 ?> - <?= min($start + $recordsPerPage, $totalTenants) ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="totalRecords" class="mb-0"><strong>Total Records:</strong></label>
                                        <input type="text" id="totalRecords" class="form-control form-control-sm total-record" value="<?= $totalTenants ?>" readonly style="background-color: #fff; color: #333;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="pageSelect"><strong>Page:</strong></label>
                                            </div>
                                            <select class="custom-select" id="pageSelect" style="background-color: #fff; color: #333;">
                                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                                    <option value="<?= $i ?>" <?= ($page == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="limitSelect"><strong>Limit:</strong></label>
                                            </div>
                                            <select class="custom-select" id="limitSelect" style="background-color: #fff; color: #333;">
                                                <option value="6" <?= ($recordsPerPage == 6) ? 'selected' : '' ?>>6</option>
                                                <option value="12" <?= ($recordsPerPage == 12) ? 'selected' : '' ?>>12</option>
                                                <option value="18" <?= ($recordsPerPage == 18) ? 'selected' : '' ?>>18</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="pagination justify-content-center mt-2" style="background-color: #fff; border-radius: 20px;">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="logs.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="logs.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="logs.php?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- All JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/dropdown.js"></script>
    <script src="js/verifiedproperty-modal.js"></script>
    <script src="js/sweetalert.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/unBanLandlord.js"></script>
    <script src="js/unBanTenant.js"></script>
    <script src="js/logs-function.js"></script>
    <script src="js/logout-function.js"></script>
    <script src="js/pagination.js"></script>
</body>
</html>