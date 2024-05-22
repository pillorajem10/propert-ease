<?php
require_once('../connect.php');
require_once('includes/security.php');
require_once('includes/propertymanagement-function.php');
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
    <link rel="stylesheet" href="css/property-management.css">
    <link rel="stylesheet" href="css/propertymanagement-button.css">
    <link rel="stylesheet" href="css/propertymanagement-card.css">
    <link rel="stylesheet" href="css/dropdown-menu.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <!-- Header with hamburger menu button -->
    <div class="header">
        <i id="sidebarCollapse" class="fas fa-bars" onclick="toggleSidebar()"></i>
        <h1 id="header">Property Management</h1>
    </div>

    <!-- Side menu bar -->
    <?php
    require_once 'sidemenu.php';
    ?>

    <!-- Main Content -->
    <main id="content" class="col-12">
        <div class="container-fluid bg-light py-2">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="card shadow">
                        <nav class="nav nav-pills nav-justified">
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav1" href="#" onclick="showSection('container1', 'nav1'); return false;">Landlords</a>
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav2" href="#" onclick="showSection('container2', 'nav2'); return false;">Tenants</a>
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav3" href="#" onclick="showSection('container3', 'nav3'); return false;">Properties</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container1">
            <div class="input-group mb-3">
                <input type="text" id="searchInput1" class="form-control" placeholder="Search landlords..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterLandlords()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
                <div class="card" style="border: none; background-color: #f8f9fa;">
                    <h2 class="card-header" style="background-color: #343a40; color: #fff;">Landlords</h2>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-3" id="landlordList">
                            <?php
                            // Determine current page number
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;

                            // Number of records per page
                            $recordsPerPage = 3;

                            // Calculate for the SQL LIMIT clause
                            $start = ($page - 1) * $recordsPerPage;

                            // Fetch landlords data from the database with pagination
                            $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_role != 'banned' LIMIT :start, :limit");
                            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                            $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                            $stmt->execute();
                            $landlords = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Get total number of landlords
                            $stmt = $pdo->prepare("SELECT COUNT(*) FROM landlord_tbl WHERE landlord_role != 'banned'");
                            $stmt->execute();
                            $totalLandlords = $stmt->fetchColumn();

                            // Calculate total pages
                            $totalPages = ceil($totalLandlords / $recordsPerPage);

                            function decryptData1($data, $key)
                            {
                                $data = base64_decode($data);
                                $iv = substr($data, 0, 16);
                                $encryptedData = substr($data, 16);
                                return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
                            }

                            if ($landlords) {
                                foreach ($landlords as $landlord) {
                                    $landlordId = $landlord['landlord_id'];
                                    $stmt = $pdo->prepare("SELECT * FROM report_tbl WHERE landlord_id = ?");
                                    $stmt->execute([$landlordId]);
                                    $landlordReports = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Decrypt relevant fields from the $landlord array using encryption key
                                    $decryptProfile = decryptData1($landlord['landlord_dp'], $landlord['encryption_key']);
                                    $decryptFname = decryptData1($landlord['landlord_fname'], $landlord['encryption_key']);
                                    $decryptLname = decryptData1($landlord['landlord_lname'], $landlord['encryption_key']);

                                    // Construct the image source path using the decrypted profile picture filename
                                    $profilePictureDirectory = '../img/profile/';
                                    $imagePath = $profilePictureDirectory . $decryptProfile;
                                    ?>
                                    <div class="card1 col-6 col-sm-4 mb-4">
                                        <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                            <img src="<?= $imagePath ?>" class="card-img-top landlord-img mx-auto mt-3" alt="Landlord Profile" style="width: 150px; height: auto; border-radius: 50%;">
                                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                                <h5 class="card-title text-center"><?= $decryptFname . ' ' . $decryptLname ?></h5>
                                                <div class="card-footer">
                                                    <div class="row action-buttons text-center">
                                                        <!-- <div class="col-md-6 col-12 mb-3">
                                                            <button class="btn btn-primary btn-block review-button" data-toggle="modal" data-target="#landlordModal" data-landlord-id="<?= $landlordId ?>">Review</button>
                                                        </div> -->
                                                        <div class="col-md-6 col-12 mb-3">
                                                            <button class="btn btn-primary btn-block btn-sm landlordreview-button" data-toggle="modal" data-target="#landlordReviewReportModal" data-landlord-data="<?= htmlspecialchars(json_encode($landlord), ENT_QUOTES, 'UTF-8') ?>">Details</button>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <?php if ($landlord['landlord_verifiedAt'] === null) { ?>
                                                                <a href="verifyLandlord.php?id=<?= $landlord['landlord_id'] ?>" class="btn btn-success btn-block verify-button">Verify</a>
                                                            <?php } else { ?>
                                                                <button class="btn btn-block verify-button verified-button" style="background-color: grey;" disabled>Verified</button>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <?php if ($landlord['landlord_verifiedAt'] === null) { ?>
                                                                <button class="btn btn-block reject-button" onclick="rejectLandlord(<?= $landlordId ?>)">Reject</button>
                                                            <?php } else { ?>
                                                                <a href="banLandlord.php?landlordId=<?= $landlord['landlord_id'] ?>" class="btn btn-block ban-button">Ban</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<div class="col-12"><p class="text-center">No landlords found</p></div>';
                            }
                            ?>
                        </div>
                    </div>
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
                                    <a class="page-link" href="property-management.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="property-management.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="property-management.php?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Modal for Landlord Details -->
            <div class="modal fade" id="landlordModal" tabindex="-1" role="dialog" aria-labelledby="landlordModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h2 class="modal-title text-dark p-3" id="landlordModalLabel">Account Information:</h2>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card mb-3">
                                <?php
                                function decryptData2($data, $key)
                                {
                                    $data = base64_decode($data);
                                    $iv = substr($data, 0, 16);
                                    $encryptedData = substr($data, 16);
                                    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
                                }

                                if (isset($_POST["landlord_id"]))  
                                { 
                                    $landlordId = $_POST['landlord_id'];
                                    $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
                                    $stmt->execute([$landlordId]);
                                    $landlord = $stmt->fetch(PDO::FETCH_ASSOC); 

                                    if ($landlord) {
                                        $encryptionKey = $landlord['encryption_key'];

                                        $decryptedFullName = decryptData2($landlord['landlord_fname'], $encryptionKey) . ' ' . decryptData($landlord['landlord_lname'], $encryptionKey);
                                        $decryptedAddress = decryptData2($landlord['landlord_address'], $encryptionKey);
                                        $decryptedContactNumber = decryptData2($landlord['landlord_contact'], $encryptionKey);
                                        $decryptedEmail = decryptData2($landlord['landlord_email'], $encryptionKey);
                                        $decryptedProfile = decryptData2($landlord['landlord_dp'], $encryptionKey);
                                        $profilePictureUrl = '../img/profile/' . $decryptedProfile;
                                        ?>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="landlordProfilePicture" class="form-label">Profile Picture:</label>
                                                <div class="image-container">
                                                    <img id="landlordProfile" alt="Profile Picture" class="profile-picture" style="filter: blur(10px);" src="<?= $profilePictureUrl ?>">
                                                    <button id="viewLandlordIdButton" class="view-photo-btn" onclick="viewPhoto('landlordProfile', 'viewLandlordProfileButton')">View Photo</button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="landlordName" class="form-label">Fullname:</label>
                                                <span id="landlordNameSpan"><?= $decryptedFullName ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="landlordAddress" class="form-label">Address:</label>
                                                <span id="landlordAddressSpan"><?= $decryptedAddress ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="landlordContactNumber" class="form-label">Contact Number:</label>
                                                <span id="landlordContactNumberSpan"><?= $decryptedContactNumber ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="landlordEmail" class="form-label">Email:</label>
                                                <span id="landlordEmailSpan"><?= $decryptedEmail ?></span>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                        // Display a message if landlord details are not found
                                        ?>
                                        <div class="card-body">
                                            <p>Landlord details not found.</p>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Landlord Review Report -->
            <div class="modal fade" id="landlordReviewReportModal" tabindex="-1" role="dialog" aria-labelledby="landlordReviewReportModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h3 class="modal-title text-dark p-3" id="landlordReviewReportModalLabel">Landlord Report</h3>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php if ($landlordReports): ?>
                                <?php foreach ($landlordReports as $report): ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">Report ID: <?= $report['report_id'] ?></h5>
                                            <p class="card-text"><?= $report['report_description'] ?></p>
                                        </div>
                                        <div class="card-footer text-muted">
                                            From Tenant: 
                                            <?php
                                            if(isset($report['tenant_id'])) {
                                                $tenantId = $report['tenant_id'];
                                                $stmt = $pdo->prepare("SELECT tenant_fname, tenant_lname, encryption_key FROM tenant_tbl WHERE tenant_id = ?");
                                                $stmt->execute([$tenantId]);

                                                $tenant = $stmt->fetch(PDO::FETCH_ASSOC);

                                                if($tenant) {
                                                    $encryptionKey = $tenant['encryption_key'];

                                                    function decryptedData1($data, $key)
                                                    {
                                                        $data = base64_decode($data);
                                                        $iv = substr($data, 0, 16);
                                                        $encryptedData = substr($data, 16);
                                                        return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
                                                    }

                                                    // Decrypt relevant fields from the $tenant array using encryption key
                                                    $decryptedFname = decryptedData1($tenant['tenant_fname'], $encryptionKey);
                                                    $decryptedLname = decryptedData1($tenant['tenant_lname'], $encryptionKey);

                                                    echo $decryptedFname . ' ' . $decryptedLname;
                                                } else {
                                                    echo 'Unknown Tenant';
                                                }
                                            } else {
                                                echo 'Unknown Tenant';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">No reports found for this landlord.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container2">
            <div class="input-group mb-3">
                <input type="text" id="searchInput2" class="form-control" placeholder="Search tenants..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterTenants()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">Tenants</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="tenantList">
                        <?php
                        // Determine current page number
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Number of records per page
                        $recordsPerPage = 3;

                        // Calculate for the SQL LIMIT clause
                        $start = ($page - 1) * $recordsPerPage;

                        // Fetch tenants data from the database with pagination
                        $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_role != 'banned' LIMIT :start, :limit");
                        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                        $stmt->execute();
                        $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        // Get total number of tenants
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tenant_tbl WHERE tenant_role != 'banned'");
                        $stmt->execute();
                        $totalTenants = $stmt->fetchColumn();

                        // Calculate total pages
                        $totalPages = ceil($totalTenants / $recordsPerPage);

                        if ($tenants) {
                            foreach ($tenants as $tenant) {
                                require('includes/tenant-decryption.php');
                        ?>
                            <div class="card2 col-6 col-sm-4 mb-4">
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <img src="<?= $tenantDp ?>" class="card-img-top tenant-img mx-auto mt-3" alt="Tenant Profile" style="width: 150px; height: auto; border-radius: 50%;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="card-title text-center"><?= $tenantFname . ' ' . $tenantLname ?></h5>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row action-buttons text-center">
                                            <!-- <div class="col-md-6 col-12 mb-3">
                                                <button class="btn btn-primary btn-block review-button" data-toggle="modal" data-target="#tenantModal" data-tenant-data="<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>">Review</button>
                                            </div> -->
                                            <div class="col-md-6 col-12 mb-3">
                                                <?php if ($tenant['tenant_verifiedAt'] === null) { ?>
                                                    <a href="verifyTenant.php?id=<?= $tenant['tenant_id'] ?>" class="btn btn-success btn-block verify-button">Verify</a>
                                                <?php } else { ?>
                                                    <button class="btn btn-block verify-button verified-button" style="background-color: grey;" disabled>Verified</button>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <?php if ($tenant['tenant_verifiedAt'] === null) { ?>
                                                    <button class="btn btn-block reject-button" onclick="openRejectModal(<?= $tenant['tenant_id'] ?>)">Reject</button>
                                                <?php } else { ?>
                                                    <a href="#" class="btn btn-block ban-button" onclick="confirmBanTenant(<?= $tenantId ?>)">Ban</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-center">No tenants found</p></div>';
                        }
                        ?>
                    </div>
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
                                <a class="page-link" href="property-management.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="property-management.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages) : ?>
                            <li class="page-item">
                                <a class="page-link" href="property-management.php?page=<?= $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- Modal for Tenant Details -->
            <div class="modal fade" id="tenantModal" tabindex="-1" role="dialog" aria-labelledby="tenantModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h2 class="modal-title text-dark p-3" id="tenantModalLabel">Account Information:</h2>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="tenantProfilePicture" class="form-label">Profile Picture:</label>
                                        <div class="image-container">
                                            <img id="tenantProfile" alt="Profile Picture" class="profile-picture" style="filter: blur(10px);">
                                            <button id="viewTenantIdButton" class="view-photo-btn" onclick="viewPhoto('tenantProfile', 'viewTenantProfileButton')">View Photo</button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tenantName" class="form-label">Fullname:</label>
                                        <span id="tenantName"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tenantAddress" class="form-label">Address:</label>
                                        <span id="tenantAddress"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tenantContactNumber" class="form-label">Contact Number:</label>
                                        <span id="tenantContactNumber"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tenantEmail" class="form-label">Email:</label>
                                        <span id="tenantEmail"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Rejecting Tenant -->
            <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h3 class="modal-title text-dark p-3" id="rejectModalLabel">Reject Tenant</h3>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <form id="rejectForm" action="reject-tenant.php" method="POST">
                                        <input type="hidden" id="tenantId" name="tenantId">
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter remarks">
                                        </div>
                                        <div class="form-group">
                                            <label for="reason">Reason</label>
                                            <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter reason"></textarea>
                                        </div>
                                        <div class="input-group-append justify-content-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container3">
            <div class="input-group mb-3">
                <input type="text" id="searchInput3" class="form-control" placeholder="Search properties..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterProperties()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">Properties</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="propertyList">
                        <?php
                        // Determine current page number
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Number of records per page
                        $recordsPerPage = 3;

                        // Calculate for the SQL LIMIT clause
                        $start = ($page - 1) * $recordsPerPage;

                        // Fetch properties data from the database with pagination
                        $stmt = $pdo->prepare("SELECT * FROM property_tbl LIMIT :start, :limit");
                        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                        $stmt->execute();
                        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get total number of properties
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM property_tbl");
                        $stmt->execute();
                        $totalProperties = $stmt->fetchColumn();

                        // Calculate total pages
                        $totalPages = ceil($totalProperties / $recordsPerPage);

                        if ($properties) {
                            foreach ($properties as $property) {
                                require('includes/property-decryption.php');
                        ?>
                            <div class="card3 col-6 col-sm-4 mb-4">
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <img src="<?= $path?>" class="card-img-top property-img mx-auto" style="object-fit: cover; width: 100%; height: 300px;" alt="Property Image">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="card-title" style="font-weight: bold;">Property:&nbsp;<span style="font-weight: normal; text-transform: capitalize;"><?= $propertyName ?></span></h5>
                                        <p class="card-text" style="font-weight: bold;">Location:&nbsp;<span style="font-weight: normal; text-transform: capitalize;"><?= $propertyCity ?></span></p>
                                        <p class="card-text card-status"><strong>Status:&nbsp;</strong>
                                            <?php
                                            if ($propertyStatus === 'Active') {
                                                echo '<span class="badge badge-success" style="font-size: 80%; width: 20%; height: 10%; padding: 5px 5px 5px 5px;">' . $propertyStatus . '</span>';
                                            } elseif ($propertyStatus === 'Pending') {
                                                echo '<span class="badge badge-warning" style="font-size: 80%; width: 20%; height: 10%; padding: 5px 5px 5px 5px;">' . $propertyStatus . '</span>';
                                            } elseif ($propertyStatus === 'Removing') {
                                                echo '<span class="badge badge-info" style="font-size: 80%; width: 20%; height: 10%; padding: 5px 5px 5px 5px;">' . $propertyStatus . '</span>';
                                            } else {
                                                echo '<span class="badge badge-danger" style="font-size: 80%; width: 20%; height: 10%; padding: 5px 5px 5px 5px;">' . $propertyStatus . '</span>';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row action-buttons text-center">
                                            <div class="col-md-6 col-12 mb-3">
                                            <button name="property_modal"class="btn btn-block review-button" onclick="openPropertyModal(<?=$propertyId?>)">Review</button>
                                            <?php
                                            if ($propertyStatus == 'Active') {
                                                echo '<button class="btn btn-block verify-button verified-button" style="background-color: grey;" disabled>Verified</button>';
                                            } elseif ($propertyStatus == 'Pending') {
                                            ?>  
                                                <button class="btn btn-block verify-button mb-2" onclick="verifyProperty(<?=$propertyId?>)">Verify</button>                                                    
                                                <button class="btn btn-block reject-button mb-2" onclick="rejectProperty(<?=$propertyId?>)">Reject</button>
                                            <?php
                                            } elseif ($propertyStatus == 'Removing') {
                                                echo '<a href="reject-removal.php?id=' . $propertyId . '" class="btn btn-block verify-button mb-2">Accept</a>';
                                                echo '<a href="reject-removal.php?id=' . $propertyId . '" class=""btn btn-block reject-button mb-2">Reject</a>';
                                            } 
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-center">No properties found</p></div>';
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
                                    <a class="page-link" href="property-management.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="property-management.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="property-management.php?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Modal for Property Review -->
            <div class="modal fade" id="propertyReviewModal" tabindex="-1" role="dialog" aria-labelledby="propertyReviewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h3 class="modal-title text-dark p-3" id="propertyReviewModalLabel">Property Review</h3>
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
    </main>

    <!-- All JS Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/dropdown.js"></script>
    <script src="js/review-modal.js"></script>
    <script src="js/landlord-modal.js"></script>
    <script src="js/tenant-modal.js"></script>
    <script src="js/property-modal.js"></script>
    <!-- <script src="js/sweetalert.js"></script> -->
    <script src="js/verify.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/banlandlord.js"></script>
    <script src="js/banTenant.js"></script>
    <script src="js/function.js"></script>
    <script src="js/logout-function.js"></script>
    <script src="js/pagination.js"></script>
    <script src="js/view-page.js"></script>
</body>
</html>