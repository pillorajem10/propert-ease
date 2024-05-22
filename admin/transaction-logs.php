<?php
session_start();
require_once('../connect.php');
require_once('includes/transaction-function.php');
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
    <link rel="stylesheet" href="css/transaction-logs.css">
    <link rel="stylesheet" href="css/dropdown-menu.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <!-- Header with hamburger menu button -->
    <div class="header">
        <i id="sidebarCollapse" class="fas fa-bars" onclick="toggleSidebar()"></i>
        <h1 id="header">Transaction Logs</h1>
    </div>

    <!-- Side menu bar -->
    <?php
    require_once 'sidemenu.php';
    ?>

    <!-- Main Content -->
    <main id="content" class="col-12">
        <div class="container mt-4">
            <div class="input-group mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search here...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterTransactionRecords()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <h2 class="card-header" style="background-color: #343a40; color: #fff;">Transaction Records</h2>
            <div class="table-responsive" id="propertyList">
                <?php if ($transactions) : ?>
                    <!-- Display transaction records table -->
                    <table class="table table-striped">
                        <!-- Table headers -->
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">Date</th>
                                <th style="width: 20%;">Landlord</th>
                                <th style="width: 20%;">Tenant</th>
                                <th style="width: 15%;">Payment Method</th>
                                <th style="width: 10%;">Amount</th>
                                <th style="width: 15%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through transaction records -->
                            <?php foreach ($transactions as $index => $transaction) : ?>
                                <tr class="table-row">
                                    <td><?php echo $index + 1; ?></td>
                                    <td class="date">
                                        <?php
                                        // Check if the 'transaction_date' key exists and is not empty
                                        if (isset($transaction['transaction_date']) && !empty($transaction['transaction_date'])) {
                                            // Format the date
                                            $formattedDate = date('F j, Y', strtotime($transaction['transaction_date']));
                                            // Output the formatted date
                                            echo '<p class="mb-0">' . $formattedDate . '</p>';
                                        } else {
                                            // If the date is not available or empty, display a default message
                                            echo '<p class="text-muted mb-0">Date not available</p>';
                                        }
                                        ?>
                                    </td>
                                    <td class="landlord-name">
                                        <?php
                                        // Display decrypted landlord's name
                                        echo $decryptedLandlordFname . ' ' . $decryptedLandlordLname;
                                        ?>
                                    </td>
                                    <td class="tenant-name">
                                        <?php
                                        // Display decrypted tenant's name
                                        echo $decryptedTenantFname . ' ' . $decryptedTenantLname;
                                        ?>
                                    </td>
                                    <td class="status-cell">
                                        <?php
                                        $transactionMethod = $transaction['method'];
                                        if ($transactionMethod === 'gcash') {
                                            echo '<p class="badge-info">' . $transactionMethod . '</p>';
                                        } elseif ($transactionMethod === 'onhand') {
                                            echo '<p class="status-pending">Cash</p>';
                                        } elseif ($transactionMethod === 'maya') {
                                            echo '<p class="status-active">' . $transactionMethod . '</p>';
                                        }
                                        ?>
                                        
                                    </td>
                                    <td class="price">
                                        <p>₱<?php echo $transaction['price']; ?></p>
                                    </td>
                                    <td class="status-cell">
                                        <?php
                                        $transactionStatus = $transaction['transaction_status'];
                                        if ($transactionStatus === 'completed') {
                                            echo '<p class="status-active">' . $transactionStatus . '</p>';
                                        } elseif ($transactionStatus === 'pending') {
                                            echo '<p class="status-pending">' . $transactionStatus . '</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- No Results Found Message -->
                    <div id="noResultsMessage" class="alert alert-warning mt-3" style="display: none;">
                        No results found
                    </div>
                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1" aria-disabled="true" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
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
    <script src="js/verifiedlandlord-modal.js"></script>
    <script src="js/verifiedtenant-modal.js"></script>
    <script src="js/sweetalert.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/sw-function.js"></script>
    <script src="js/unBanLandlord.js"></script>
    <script src="js/unBanTenant.js"></script>
    <script src="js/transactionlogs-function.js"></script>
    <script src="js/logout-function.js"></script>
</body>
</html>