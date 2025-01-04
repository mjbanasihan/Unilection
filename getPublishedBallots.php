<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = 'localhost';
$dbname = 'election';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT ballot_id, ballot_title FROM ballots WHERE status = 'published'");
    $ballots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($ballots);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
