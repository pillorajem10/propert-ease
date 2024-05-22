<?php
// Check if the user is not logged in
if (isset($_SESSION['tenant_id'])) {
    // Bind tenant ID parameter to prevent SQL injection
    $tenantId = $_SESSION['tenant_id'];
    $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
    $stmt->execute([$tenantId]);
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if tenant is banned
    if ($tenant && $tenant['tenant_role'] === 'banned') {
        unset($_SESSION['tenant_id']);
        session_destroy();
        header("Location: index.php");
        exit;
    }

    // Check if tenant has associated property ID
    if ($tenant && isset($tenant['property_id'])) {
        // Redirect to the payment management page
        header("Location: payment-management.php");
        exit;
    }
}

$city = isset($_GET['city']) ? $_GET['city'] : '';
$rentalType = isset($_GET['rental_type']) ? $_GET['rental_type'] : '';

// Check if $city and $rentalType are set and not empty
if (!empty($city) && !empty($rentalType)) {
    // Prepare a SQL statement with placeholders
    $sql = "SELECT * FROM property_tbl WHERE property_status = 'Active' AND property_city = :city AND property_type = :rentalType";
    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
    // Bind the parameters
    $stmt->bindParam(':city', $city, PDO::PARAM_STR);
    $stmt->bindParam(':rentalType', $rentalType, PDO::PARAM_STR);
} elseif (!empty($city)) {
    // Prepare a SQL statement with placeholders
    $sql = "SELECT * FROM property_tbl WHERE property_status = 'Active' AND property_city = :city";
    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
    // Bind the parameter
    $stmt->bindParam(':city', $city, PDO::PARAM_STR);
} elseif (!empty($rentalType)) {
    // Prepare a SQL statement with placeholders
    $sql = "SELECT * FROM property_tbl WHERE property_status = 'Active' AND property_type = :rentalType";
    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
    // Bind the parameter
    $stmt->bindParam(':rentalType', $rentalType, PDO::PARAM_STR);
} else {
    // Prepare a SQL statement with no placeholders
    $sql = "SELECT * FROM property_tbl WHERE property_status = 'Active'";
    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
}

// Execute the statement
$stmt->execute();

// Fetch the results
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to get the number of properties by type
function getNumberOfPropertiesByType($type)
{
    global $pdo; // Assuming $pdo is your database connection

    // Prepare SQL statement
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM property_tbl WHERE property_type = ? AND property_status = 'Active'");
    // Execute SQL statement
    $stmt->execute([$type]);
    // Fetch row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row['total'];
}

// Initialize variables to count the number of houses and apartments
// Fetch the number of houses and apartments
$numHouses = getNumberOfPropertiesByType('House');
$numApartments = getNumberOfPropertiesByType('Apartment');

// Fetch properties based on the selected rental type
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rental_type'])) {
    $rentalType = $_POST['rental_type'];

    // Prepare SQL statement
    $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_type = ? AND property_status = 'Active'");
    // Execute SQL statement
    $stmt->execute([$rentalType]);
    // Fetch properties
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count the number of houses and apartments
    foreach ($properties as $property) {
        if ($property['property_type'] == 'House') {
            $numHouses++;
        } elseif ($property['property_type'] == 'Apartment') {
            $numApartments++;
        }
    }

    // Fetch properties based on price range if provided
    if (isset($_POST['min_price']) && isset($_POST['max_price'])) {
        $minPrice = filter_var($_POST['min_price'], FILTER_VALIDATE_INT);
        $maxPrice = filter_var($_POST['max_price'], FILTER_VALIDATE_INT);
        // Limit price range from 0 to 5000
        $minPrice = max(0, min($minPrice, 5000));
        $maxPrice = max(0, min($maxPrice, 5000));
        if ($minPrice !== false && $maxPrice !== false && $minPrice <= 5000 && $maxPrice <= 5000 && $minPrice <= $maxPrice) {
            // Prepare SQL statement
            $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_type = ? AND property_price BETWEEN ? AND ? AND property_status = 'Active'");
            // Execute SQL statement
            $stmt->execute([$rentalType, $minPrice, $maxPrice]);
            // Fetch properties
            $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}

$showingType= isset($_GET['rental_type']) ? $_GET['rental_type'] : '';

// Calculate the total number of results based on the selected rental type
$totalResults = isset($rentalType) ? ($rentalType == 'House' ? $numHouses : $numApartments) : count($properties);

// Measure the start time
$start_time = microtime(true);

// Simulate sorting/filtering operations (replace this with actual sorting/filtering)

// Measure the end time
$end_time = microtime(true);

// Calculate the time taken in seconds
$timeInSeconds = number_format(($end_time - $start_time), 2);

// Determine if the selected rental type is 'House' or 'Apartment'
$selectedRentalType = isset($rentalType) ? ucfirst($rentalType) : 'All';

// Function to get the number of properties by city
function getNumberOfPropertiesByCity($city)
{
    global $pdo; // Assuming $pdo is your database connection

    // Prepare SQL statement
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM property_tbl WHERE property_city = ? AND property_status = 'Active'");
    // Execute SQL statement
    $stmt->execute([$city]);
    // Fetch row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row['total'];
}

// Initialize variables to count the number of olongapo city and subic
// Fetch the number of olongapo city and subic
$numOlongapo = getNumberOfPropertiesByCity('Olongapo');
$numSubic = getNumberOfPropertiesByCity('Subic');

// Fetch properties based on the selected rental type
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['property_location'])) {
    $propertyCity = $_POST['property_location'];

    // Prepare SQL statement
    $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_city = ? AND property_status = 'Active'");
    // Execute SQL statement
    $stmt->execute([$propertyCity]);
    // Fetch properties
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count the number of olongapo and subic
    foreach ($properties as $property) {
        if ($property['property_city'] == 'Olongapo City') {
            $numOlongapo++;
        } elseif ($property['property_city'] == 'Subic') {
            $numSubic++;
        }
    }
}

$showingCity = isset($_GET['property_location']) ? $_GET['property_location'] : '';

// Calculate the total number of results based on the selected property city
$totalResults = isset($propertyCity) ? ($propertyCity == 'Olongapo' ? $numOlongapo : $numSubic) : count($properties);

// Measure the start time
$start_time = microtime(true);

// Simulate sorting/filtering operations (replace this with actual sorting/filtering)

// Measure the end time
$end_time = microtime(true);

// Calculate the time taken in seconds
$timeInSeconds = number_format(($end_time - $start_time), 2);

// Determine if the selected property city is 'Olongapo City' or 'Subic'
$selectedPropertyCity = isset($propertyCity) ? ucfirst($propertyCity) : 'All';
?>