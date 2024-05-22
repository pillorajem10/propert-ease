<?php
    // Database connection configuration
    require_once('config/config.php');

    $servername = '127.0.0.1';
    $username = 'root';
    $password = '';
    $dbname = 'properteasedb';

    try {
        // Create connection
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $pdo = new PDO($dsn, $username, $password, $options);

        // Query to fetch landlords
        $sql = "SELECT landlord_id, landlord_fname FROM landlord_tbl";
        $stmt = $pdo->query($sql);

        $landlords = $stmt->fetchAll();

        // Close connection
        $pdo = null;

        // Set header for JSON response
        header('Content-Type: application/json');
        echo json_encode($landlords);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
