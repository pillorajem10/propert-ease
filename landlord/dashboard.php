<?php
session_start();
require_once('../connect.php');
require_once('includes/dashboard-function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="300">
    <title>Propert-Ease</title>
    <!-- Include Bootstrap CSS, jQuery, and Popper.js -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>

    <!-- logo icon image/x-icon  -->
	<link rel="icon" href="img/icon.png" type="image/x-icon">
    <!-- Font Icons css -->
    <link rel="stylesheet" href="../css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="css/plugins.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/dashboard-button.css">
    <link rel="stylesheet" href="css/dashboard-style.css">
    <link rel="stylesheet" href="css/dashboard-card.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <!-- Header with hamburger menu button and dropdown -->
    <div class="header">
        <i id="sidebarCollapse" class="fas fa-bars" onclick="toggleSidebar()"></i>
        <h1 id="header">Dashboard</h1>
    </div>

    <!-- Side menu bar -->
    <?php
    require_once 'sidemenu.php';
    ?>

    <!-- Main Content -->
    <main id="container" class="col-12">
        <div class="container-fluid bg-light py-2">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="card shadow">
                        <nav class="nav nav-pills nav-justified">
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav1" href="#" onclick="showSection('container1', 'nav1'); return false;">Current Tenants</a>
                            <a class="nav-item nav-section btn-light pt-2 pb-2 flex-grow-1" id="nav2" href="#" onclick="showSection('container2', 'nav2'); return false;">Pending Tenants</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container1">
            <div class="input-group mb-3">
                <input type="text" id="searchInput1" class="form-control" placeholder="Search current tenants..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterCurrentTenants()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">Current Tenants</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="currenttenantList">
                    <?php
                    // Determine current page number
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;

                    // Number of records per page
                    $recordsPerPage = 3;

                    // Calculate for the SQL LIMIT clause
                    $start = ($page - 1) * $recordsPerPage;

                    // Fetch tenants data from the database with pagination
                    $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE landlord_id = :landlord_id LIMIT :start, :limit");
                    $stmt->bindParam(':landlord_id', $landlordId, PDO::PARAM_INT);
                    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                    $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                    $stmt->execute();

                    // Get total number of tenants
                    $stmtTotalTenants = $pdo->prepare("SELECT COUNT(*) FROM tenant_tbl WHERE tenant_role != 'banned' and landlord_id = ?" );
                    $stmtTotalTenants->execute([$landlordId]);
                    $totalTenants = $stmtTotalTenants->fetchColumn();

                    // Fetch all tenants
                    $stmtTenants = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_role != 'banned'");
                    $stmtTenants->execute();
                    $tenants = $stmtTenants->fetchAll(PDO::FETCH_ASSOC);

                    // Calculate total pages
                    $totalPages = ceil($totalTenants / $recordsPerPage);

                    // Check if there are properties for the landlord
                    if ($stmt->rowCount() > 0) 
                    {
                        while ($tenant = $stmt->fetch(PDO::FETCH_ASSOC)) 
                        {
                            require('includes/tenant-decryption.php');
                            // Your further logic here
                            ?>
                            <div class="card1 col-6 col-sm-4 mb-4">
                                <!-- Card for each tenant -->
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <img src="<?= $tenantDp ?>" class="card-img-top tenant-img mx-auto mt-3" alt="Tenant Profile" style="width: 150px; height: auto; border-radius: 50%;">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="card-title text-center"><?= $tenantFname . ' ' . $tenantLname ?></h5>
                                        <p class="card-text"><strong>Status:</strong>
                                            <?php
                                            if ($tenantStatus === 'paid') {
                                                echo '<span class="badge badge-success text-capitalize">' . ucfirst($tenantStatus) . '</span>';
                                            } else {
                                                echo '<span class="badge badge-info text-capitalize">' . ucfirst($tenantStatus) . '</span>';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row action-buttons text-center">
                                            <div class="col-md-12 col-12 mb-3">
                                            <?php if($tenant['unique_id']):?>
                                                <button name="receive_modal" id="<?= $tenant['tenant_id'] ?>" class="btn btn-block review-button mb-2" data-toggle="modal" data-target="#receiveModal" onclick="showReceivePaymentDetails(<?= $tenant['tenant_id'] ?>)">Receive Payment</button>
                                            <?php endif;?>
                                                <a href="#" class="btn btn-block review-button mb-2" data-toggle="modal" data-target="#tenantReviewModal" onclick="showReviewDetails(<?= $tenant['tenant_id'] ?>)">View</a>
                                                <?php if($tenant['tenant_status']!= 'Requesting Exit'):?>
                                                <a href="#" class="btn btn-block kick-button mb-2" onclick="kickTenant(<?= $tenant['tenant_id'] ?>)">Kick</a>
                                                 <?php else:?>
                                                 <a href="#" class="btn btn-block kick-button mb-2" onclick="exitTenant(<?= $tenant['tenant_id'] ?>)">Accept Exit</a>
                                                 <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                    } else {
                        // No properties for tenants
                        echo '<div class="col-md-12"><p class="text-center">No Tenants Yet</p></div>';
                    }
                    ?>
                    </div>
                </div>
                <div class="card-footer" style="background-color: #f8f9fa; color: #333; border-top: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6 col-md-3 mb-2 mb-md-0">
                                    <label for="recordsRange" class="mb-0"><strong>Records:</strong></label>
                                    <input type="text" id="recordsRange" class="form-control form-control-sm record-range" value="<?= $start + 1 ?> - <?= min($start + $recordsPerPage, $totalPaidTenants) ?>" readonly style="background-color: #fff; color: #333;">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label for="totalRecords" class="mb-0"><strong>Total Records:</strong></label>
                                    <input type="text" id="totalRecords" class="form-control form-control-sm total-record" value="<?= $totalPaidTenants ?>" readonly style="background-color: #fff; color: #333;">
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
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage1" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <ul class="pagination justify-content-center mt-2" style="background-color: #fff; border-radius: 20px;">
                        <?php if ($page > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="dashboard.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="dashboard.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages) : ?>
                            <li class="page-item">
                                <a class="page-link" href="dashboard.php?page=<?= $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- Modal for Payment Details -->
            <div class="modal fade" id="receiveModal" tabindex="-1" role="dialog" aria-labelledby="receivePaymentModalLabel<?= $tenant['unique_id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h3 class="modal-title text-dark p-3" id="receivePaymentModalLabel<?= $tenant['unique_id'] ?>">Payment Details:</h3>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <div class="card mb-3">
                                <div class="card-body" id="receive-card">
                                    <!-- Payment details content will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Tenant Review -->
            <div class="modal fade" id="tenantReviewModal" tabindex="-1" role="dialog" aria-labelledby="tenantReviewModalLabel<?= $tenant['tenant_id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h3 class="modal-title text-dark p-3" id="tenantReviewModalLabel<?= $tenant1['tenant_id'] ?>">Review from <?= $tenant1['tenant_fname'] ?> <?= $tenant1['tenant_lname'] ?></h3>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card mb-3">
                                <div class="card-body" id = "review-card">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4" id="container2">
            <div class="input-group mb-3">
                <input type="text" id="searchInput2" class="form-control" placeholder="Search pending tenants..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterPendingTenants()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card" style="border: none; background-color: #f8f9fa;">
                <h2 class="card-header" style="background-color: #343a40; color: #fff;">Pending Tenants</h2>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3" id="pendingtenantList">
                        <?php
                        // Determine current page number
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Number of records per page
                        $recordsPerPage = 3;

                        // Calculate for the SQL LIMIT clause
                        $start = ($page - 1) * $recordsPerPage;

                        // Fetch pending tenants data from the database with pagination
                        $stmt = $pdo->prepare("SELECT * FROM pending_tbl WHERE landlord_id = :landlord_id LIMIT :start, :limit");
                        $stmt->bindParam(':landlord_id', $landlordId, PDO::PARAM_INT);
                        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                        $stmt->execute();

                        // Get total number of pending tenants
                        $landlordId = $_SESSION['landlord_id'];
                        $totalPendingTenantsStmt = $pdo->prepare("SELECT COUNT(*) FROM pending_tbl WHERE landlord_id = :landlordId");
                        $totalPendingTenantsStmt->execute(['landlordId' => $landlordId]);
                        $totalPendingTenants = $totalPendingTenantsStmt->fetchColumn();

                        // Calculate total pages
                        $totalPages = ceil($totalPendingTenants / $recordsPerPage);

                        // Fetching pending tenants
                        $pendingStmt = $pdo->prepare("SELECT * FROM pending_tbl WHERE landlord_id = :landlordId");
                        $pendingStmt->execute(['landlordId' => $landlordId]);
                        $pendingTenants = $pendingStmt->fetchAll();
                        $pendingCount = 1;

                        if ($stmt->rowCount() > 0) {
                            while ($pending = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                // Retrieve tenant details
                                $tenantId = $pending['tenant_id'];
                                $tenantStmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
                                $tenantStmt->execute([$tenantId]);
                                $tenant = $tenantStmt->fetch(PDO::FETCH_ASSOC);

                                require('includes/tenant-decryption.php');

                                // Retrieve property details
                                $propertyId = $pending['property_id'];
                                $propertyStmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
                                $propertyStmt->execute([$propertyId]);
                                $property = $propertyStmt->fetch(PDO::FETCH_ASSOC);
                                require('includes/property-decryption.php');
                                ?>
                            <div class="card2 col-6 col-sm-4 mb-4">
                                <div class="card" style="border: none; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                    <?php if(isset($tenant['tenant_dp'])): ?>
                                    <img src="<?=$tenantDp?>" class="card-img-top tenant-img mx-auto mt-3" alt="Tenant Profile" style="width: 150px; height: auto; border-radius: 50%;">
                                    <?php endif; ?>
                                    <div class="card-body card-body d-flex flex-column justify-content-center align-items-center">
                                        <?php if(isset($tenant['tenant_fname'], $tenant['tenant_lname'])): ?>
                                        <h5 class="card-title text-center"><?= $tenantFname . ' ' . $tenantLname ?></h5>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row action-buttons text-center">
                                            <div class="col-md-6 col-12 mb-3">
                                                <button name="review_modal" id="<?= $pending['tenant_id'] ?>" class="btn btn-block review-button mb-2"  onclick="showPendingTenantDetails(<?= $pending['pending_id'] ?>)">Check</button>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <a href="#" class="btn btn-block accept-button mb-2" onclick="acceptTenant(<?= $pending['pending_id'] ?>)">Accept</a>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <a href="#" class="btn btn-block reject-button mb-2" onclick="rejectTenant(<?= $pending['pending_id'] ?>)">Reject</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                        } else {
                            echo '<div class="col-md-12"><p class="text-center">No new tenant applicants</p></div>';
                        }
                    ?>
                    </div>
                </div>
                <div class="card-footer" style="background-color: #f8f9fa; color: #333; border-top: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6 col-md-3 mb-2 mb-md-0">
                                    <label for="recordsRange" class="mb-0"><strong>Records:</strong></label>
                                    <input type="text" id="recordsRange" class="form-control form-control-sm record-range" value="<?= $start + 1 ?> - <?= min($start + $recordsPerPage, $totalPendingTenants) ?>" readonly style="background-color: #fff; color: #333;">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label for="totalRecords" class="mb-0"><strong>Total Records:</strong></label>
                                    <input type="text" id="totalRecords" class="form-control form-control-sm total-record" value="<?= $totalPendingTenants ?>" readonly style="background-color: #fff; color: #333;">
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
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage2" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <ul class="pagination justify-content-center mt-2" style="background-color: #fff; border-radius: 20px;">
                        <?php if ($page > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="dashboard.php?page=<?= $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="dashboard.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages) : ?>
                            <li class="page-item">
                                <a class="page-link" href="dashboard.php?page=<?= $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- Modal for Review Booked Property Details -->
            <div class="modal fade" id="pendingModal" tabindex="-1" role="dialog" aria-labelledby="bookedPropertyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h3 class="modal-title text-dark p-3" id="bookedPropertyModalLabel">Booked Property Details:</h3>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <div class="card mb-3">
                                <div class="card-body" id='tenant-review'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Rejecting Pending Tenant -->
            <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h3 class="modal-title text-dark p-3" id="rejectModalLabel">Remarks</h3>
                            <button type="button" class="close mr-n1 mt-n1" data-dismiss="modal" aria-label="Close" style="background-color: red; color: white; border: none; width: 30px; height: 30px; border-radius: 10%; top: 10; left: 10; position: absolute;">
                                <span aria-hidden="true" class="close-icon">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <form id="rejectForm" action="reject-tenant.php" method="POST">
                                        <input type="hidden" id="pendingId" name="pendingId">
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
    </main>
    
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
    <script src="js/function.js"></script>
    <script src="js/tenant-function.js"></script>
    <script src="js/tenant-modal.js"></script>
    <script src="js/tenant-sweetalert.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/pagination.js"></script>
    <script src="js/receive-payment.js"></script>
    <script src="js/review.js"></script>
</body>
</html>