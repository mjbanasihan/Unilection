<?php
// Database connection
$host = 'localhost';
$db = 'election';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT id, position_name FROM position"; // Adjust table name if needed
    $stmt = $pdo->query($query);
    $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($positions);
} catch (PDOException $e) {
    // Handle connection errors
    echo json_encode(['error' => $e->getMessage()]);
}
?>
