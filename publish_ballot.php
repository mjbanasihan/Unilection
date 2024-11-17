<?php
require 'include/db_election.php'; // Ensure this file contains your database connection

$input = json_decode(file_get_contents('php://input'), true);
$ballot_id = $input['ballot_id']; 

// Update ballot status to published
$sql = "UPDATE ballots SET status = 'published' WHERE ballot_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ballot_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error updating ballot: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
