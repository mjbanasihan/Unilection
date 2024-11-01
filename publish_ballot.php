<?php
require 'include/db_election.php'; // Ensure this file contains your database connection

// Decode the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Log incoming data for troubleshooting
error_log('Incoming data: ' . print_r($data, true)); // Log incoming data

// Use null coalescing operator to handle undefined array key
$ballotId = $data['ballot_id'] ?? null; 

// Check if ballotId is null
if ($ballotId === null) {
    echo json_encode(['success' => false, 'message' => 'Ballot ID is missing or invalid.']);
    exit; // Stop further execution
}

if ($ballotId) {
    // Update the ballot to set its status to published
    $query = "UPDATE ballots SET status = 'published' WHERE ballot_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) { // Check if the statement was prepared successfully
        $stmt->bind_param("i", $ballotId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to publish ballot.']);
        }
        $stmt->close(); // Close statement if it was successfully prepared
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid ballot ID.']);
}

$conn->close(); // Close the database connection
?>
