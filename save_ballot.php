<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";  // XAMPP default, update if necessary
$dbname = "election";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Fetch the form data
$ballotTitle = $data['ballotTitle'];
$positions = $data['positions'];

// Insert the ballot title first
$sql = "INSERT INTO ballots (ballot_title, status) VALUES (?, 'draft')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ballotTitle);

if ($stmt->execute()) {
    $ballotId = $stmt->insert_id;  // Get the ID of the inserted ballot

    // Insert positions into ballot_positions
    foreach ($positions as $positionData) {
        $positionName = $positionData['position_name'];
        $sql = "INSERT INTO ballot_positions (ballot_id, position_name, max_vote) VALUES (?, ?, ?)";
        $maxVote = 1; // Adjust this as necessary
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $ballotId, $positionName, $maxVote);
        
        if ($stmt->execute()) {
            $positionId = $stmt->insert_id; // Get the ID of the inserted position
            
            // Now insert the candidates related to this position
            foreach ($positionData['candidates'] as $candidate) {
                $sql = "INSERT INTO ballot_candidates (position_id, candidate_name) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $positionId, $candidate);
                $stmt->execute();  // Execute the prepared statement
            }
        }
    }

    echo "Ballot saved as draft successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
