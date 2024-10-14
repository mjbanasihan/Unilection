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
$candidates = $data['candidates'];
$partyLists = $data['partyLists'];

// Insert the ballot title first
$sql = "INSERT INTO ballots (ballot_title, status) VALUES (?, 'draft')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ballotTitle);

if ($stmt->execute()) {
    $ballotId = $stmt->insert_id;  // Get the ID of the inserted ballot

    // Insert positions into ballot_positions first
    $positionIds = [];
    foreach ($positions as $position) {
        $sql = "INSERT INTO ballot_positions (ballot_id, position_name, max_vote) VALUES (?, ?, ?)";
        $maxVote = 1; // Adjust this as necessary
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $ballotId, $position, $maxVote);
        if ($stmt->execute()) {
            $positionIds[] = $stmt->insert_id; // Get the ID of the inserted position
        }
    }

    // Prepare the statement for ballot candidates
    $sql = "INSERT INTO ballot_candidates (position_id, candidate_name, candidate_partylist) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $positionId, $candidate, $partyList);

    // Now insert the candidates related to this ballot
    for ($i = 0; $i < count($candidates); $i++) {
        $candidate = $candidates[$i];
        $partyList = $partyLists[$i];

        // Assuming positions and candidates align in order, use the same index
        $positionId = $positionIds[$i]; 
        $stmt->execute();  // Execute the prepared statement
    }

    echo "Ballot saved as draft successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
