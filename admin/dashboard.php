<?php
require_once('../connect.php');
require_once('includes/dashboard-function.php');
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
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/dashboard-button.css">
    <link rel="stylesheet" href="css/dashboard-card.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <!-- Header with hamburger menu button -->
    <div class="header">
        <i id="sidebarCollapse" class="fas fa-bars" onclick="toggleSidebar()"></i>
        <h1 id="header">Dashboard</h1>
        
    </div>

    <!-- Side menu bar -->
    <?php
    require_once 'sidemenu.php';
    ?>

    <!-- Main Content -->
    <main id="content" class="col-12">
        <div class="container mt-4">
            <!-- Content Row -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Verified Properties</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $verifiedPropertiesCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                                <div class="col-12 mt-auto text-center">
                                    <a href="#" class="text-decoration-none text-primary" onclick="navigateToSection('property-management.php', 'container3')">View Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Verified Tenants</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $verifiedTenantsCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                                <div class="col-12 mt-auto text-center">
                                    <a href="#" class="text-decoration-none text-primary" onclick="navigateToSection('property-management.php', 'container2')">View Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Verified Landlords</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $verifiedLandlordsCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                                <div class="col-12 mt-auto text-center">
                                    <a href="#" class="text-decoration-none text-primary" onclick="navigateToSection('property-management.php', 'container1')">View Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Row -->

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Banned Tenants</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $bannedTenantsCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-times fa-2x text-gray-300"></i>
                                </div>
                                <div class="col-12 mt-auto text-center">
                                    <a href="#" class="text-decoration-none text-primary" onclick="navigateToSection('history-logs.php', 'container5')">View Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Banned Landlords</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $bannedLandlordsCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-times fa-2x text-gray-300"></i>
                                </div>
                                <div class="col-12 mt-auto text-center">
                                    <a href="#" class="text-decoration-none text-primary" onclick="navigateToSection('history-logs.php', 'container4')">View Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Paid Tenants</div>
                                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $paidTenantsCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                                <div class="col-12 mt-auto text-center">
                                    <a href="#" class="text-decoration-none text-primary" onclick="navigateToSection('history-logs.php', 'container6')">View Info</a>
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
    <script src="http://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/plugins.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/sidebar-toggle.js"></script>
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
    <script src="js/view-page.js"></script>
    <script type="text/javascript">
        var chartMonth = <?php echo json_encode($chartMonth); ?>;
        var ctx = document.getElementById('chart-month').getContext('2d');
        new Chart(ctx, chartMonth);

        chartMonth.data.datasets[0].data = [
            <?= $verifiedPropertiesCount ?>,
            <?= $verifiedTenantsCount ?>,
            <?= $verifiedLandlordsCount ?>,
            <?= $bannedTenantsCount ?>,
            <?= $bannedLandlordsCount ?>,
            <?= $paidTenantsCount ?>
        ];
        chartMonth.update();
    </script>
</body>
</html>