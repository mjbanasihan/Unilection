<?php
$servername = "localhost"; // Database server
$username = "root"; // Database username
$password = ""; // Database password (ensure this is correct)
$dbname = "election"; // Database name

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch positions
if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET['position'])) {
    $sql = "SELECT position_name, max_vote FROM position"; // Fetch positions
    $result = $conn->query($sql);

    if ($result === false) {
        // Log query error for debugging
        error_log("Query error (fetching positions): " . $conn->error);
        header('Content-Type: application/json', true, 500);
        echo json_encode(["error" => "Failed to fetch positions: " . $conn->error]);
        exit;
    }

    $positions = [];
    while ($row = $result->fetch_assoc()) {
        $positions[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($positions);
}

// Fetch candidates by position
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['position'])) {
    $position = $_GET['position'];  // Get the position from the request

    $sql = "SELECT candidate_name, candidate_partylist FROM candidate WHERE candidate_pos = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Log preparation error for debugging
        error_log("Prepare failed: " . $conn->error);
        header('Content-Type: application/json', true, 500);
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit;
    }

    $stmt->bind_param('s', $position);  // Bind the position parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        // Log query error for debugging
        error_log("Query error (fetching candidates): " . $stmt->error);
        header('Content-Type: application/json', true, 500);
        echo json_encode(["error" => "Failed to fetch candidates: " . $stmt->error]);
        exit;
    }

    $candidates = [];
    while ($row = $result->fetch_assoc()) {
        $candidates[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($candidates);
    $stmt->close(); // Close statement after execution
}

// Close connection
$conn->close();
?>
