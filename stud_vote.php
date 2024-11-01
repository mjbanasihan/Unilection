<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "election";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get raw POST data
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

// Check if ballot_id is set
if (!isset($data['ballot_id'])) {
    echo json_encode(['success' => false, 'message' => 'Ballot ID is missing.']);
    exit;
}

$ballotId = $data['ballot_id'];

// Here you would typically handle the voting logic, e.g., insert the vote into the database
// Assuming you have a voters table or similar to track votes:
$sql = "INSERT INTO votes (ballot_id, voter_id) VALUES (?, ?)"; // Placeholder for the actual SQL
$stmt = $conn->prepare($sql);

// Replace 1 with the actual voter ID
$voterId = 1; // Example voter ID, you should fetch it from session or similar

if ($stmt) {
    $stmt->bind_param("ii", $ballotId, $voterId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Vote cast successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error casting vote.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
}

$conn->close();
?>
