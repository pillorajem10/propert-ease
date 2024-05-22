<?
require_once('connect.php');
$stmt = $pdo->query("SELECT CURRENT_DATE");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Current date from the database: " . $result['CURRENT_DATE'];
?>