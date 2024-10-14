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

// Fetch all saved ballots
$sql = "SELECT * FROM ballots WHERE status = 'draft'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="saved-ballot">';
        echo '<h4 style="font-size: 24px; font-weight: bold;">' . htmlspecialchars($row['ballot_title']) . '</h4>'; // Increased font size and bold
        echo '<p>Status: ' . htmlspecialchars($row['status']) . '</p>';
        
        // Use the actual identifier for the ballot
        $ballotId = isset($row['id']) ? $row['id'] : (isset($row['ballot_id']) ? $row['ballot_id'] : ''); // Replace 'ballot_id' with your actual column name

        // Buttons for actions
        echo '<div class="ballot-actions">';
        echo '<button class="btn-view" onclick="viewBallot(' . $ballotId . ')">View Ballot</button>';
        echo '<button class="btn-publish" onclick="publishBallot(' . $ballotId . ')">Publish Ballot</button>';
        echo '<button class="btn-edit" onclick="editBallot(' . $ballotId . ')">Edit Ballot</button>';
        echo '<button class="btn-delete" onclick="deleteBallot(' . $ballotId . ')">Delete Ballot</button>';
        echo '</div>'; // Close ballot-actions div
        echo '</div>'; // Close saved-ballot div
    }
} else {
    echo '<p>No saved ballots found.</p>';
}

$conn->close();
?>
