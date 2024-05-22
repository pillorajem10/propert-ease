<?php
session_start();
require_once('../connect.php');
require_once('includes/tenantmanagement-function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="css/tenant-management.css">
    <link rel="stylesheet" href="css/tenantmanagement-card.css">
    <link rel="stylesheet" href="css/tenantmanagement-button.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <!-- Header with hamburger menu button and dropdown -->
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
                    <h2 class="card-title">Tenant Management</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2>Property Details:</h2>
                            <?php
                            require_once 'includes/property-decryption.php';
                            ?>
                            <img src="<?=$path ?>" alt="Property Image" class="img-fluid mb-3">
                            <p><strong>Location:</strong> <?= $propertyAddress ?>, <?= $propertyBrgy ?>, <?= $propertyCity ?>, <?= $propertyProvince ?>, <?= $propertyZipcode?></p>
                            <p><strong>Pay Rate:</strong> <?= $propertyPrice ?></p>
                            <p><strong>Due Date:</strong> <?= $property['property_due'] ?></p>
                            <p><strong>Status:</strong> <span class="badge <?= ($property['property_status'] === 'Active') ? 'badge-success' : 'badge-info' ?>"><?= $property['property_status'] ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <div class="card mt-5" id="card">
                <div class="card-header">
                    <h2 class="card-title">History of Paid Tenants in their Booked Properties</h2>
                    <div class="float-right">
                        <div class="input-group mb-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search paid tenants..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="filterPaidTenants()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2>Paid Tenants:</h2>
                            <?php if ($totalPaidTenants > 0): ?>
                                <div class="table-responsive" id="paidTenantList">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <!-- Add more columns if needed -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($paidTenants as $index => $tenant): 
                                                require 'includes/tenant-decryption.php';    
                                            ?>
                                            
                                                <tr>
                                                    <td><?= $start + $index + 1 ?></td>
                                                    <td class="tenant-name"><?= $tenantFname .' '.$tenantLname ?></td>
                                                    <td><?= $tenant['tenant_email'] ?></td>
                                                    <!-- Add more columns if needed -->
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- No Results Found Message -->
                                <div id="noResultsMessage" class="alert alert-warning mt-3" style="display: none;">
                                    No results found
                                </div>
                                <!-- Pagination Links -->
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                                            <li class="page-item <?= ($page == $currentPage) ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            <?php else: ?>
                                <p>No paid tenants found for this property.</p>
                            <?php endif; ?>
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
    <script src="js/tenantmanagement-function.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/sw-function.js"></script>
</body>
</html>