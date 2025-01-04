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

// Check if ballot_id and votes are set
if (!isset($data['ballot_id']) || !isset($data['votes'])) {
    echo json_encode(['success' => false, 'message' => 'Ballot ID or votes are missing.']);
    exit;
}

$ballotId = $data['ballot_id'];
$votes = $data['votes'];

// Assuming you have the student information from the session or login, retrieve the student_id
session_start();
if (!isset($_SESSION['student_id'])) {
    echo json_encode(['success' => false, 'message' => 'Student not logged in.']);
    exit;
}

$studentId = $_SESSION['student_id']; // Fetch the student_id from the session

// Insert votes into the ballot_votes table for each selected vote
foreach ($votes as $position => $candidate) {
    // Assuming you have a column for position and candidate in the ballot_votes table
    $sql = "INSERT INTO ballot_votes (ballot_id, student_id, position_name, candidate_name) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiss", $ballotId, $studentId, $position, $candidate);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Error casting vote for position ' . $position]);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for vote insertion.']);
        exit;
    }
}

echo json_encode(['success' => true, 'message' => 'Vote cast successfully.']);

$stmt->close();
$conn->close();
?>
