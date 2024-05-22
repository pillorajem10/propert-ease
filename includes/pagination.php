<?php
// Sanitize and validate current page number
$page = isset($_GET['page']) ? filter_var($_GET['page'], FILTER_VALIDATE_INT) : 1;
$page = ($page === false || $page < 1) ? 1 : $page;

// Number of records per page
$recordsPerPage = 2;

// Calculate start index for SQL LIMIT clause
$start = ($page - 1) * $recordsPerPage;

// Fetch property data from the database with pagination
$stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_status = 'Active' LIMIT :start, :limit");
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
$stmt->execute();
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total number of active properties
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM property_tbl WHERE property_status = 'Active'");
$stmt->execute();
$totalProperties = $stmt->fetchColumn();

// Calculate total pages
$totalPages = ceil($totalProperties / $recordsPerPage);
?>