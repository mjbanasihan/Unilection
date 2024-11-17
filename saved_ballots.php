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

// Fetch all saved ballots including published ones
$sql = "SELECT * FROM ballots WHERE status IN ('draft', 'published')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="saved-ballot" id="ballot-' . $row['ballot_id'] . '">';
        echo '<h4 style="font-size: 24px; font-weight: bold;">' . htmlspecialchars($row['ballot_title']) . '</h4>'; // Increased font size and bold
        echo '<p>Status: <span class="status-badge">' . htmlspecialchars($row['status']) . '</span></p>';
        
        // Use the actual identifier for the ballot
        $ballotId = isset($row['id']) ? $row['id'] : (isset($row['ballot_id']) ? $row['ballot_id'] : ''); // Replace 'ballot_id' with your actual column name

        // Buttons for actions
        echo '<div class="ballot-actions">';
        
        // Publish button (only show if not already published)
        if ($row['status'] == 'draft') {
            echo '<button class="btn-publish" onclick="publishBallot(' . $ballotId . ')">Publish Ballot</button>';
        } else {
            echo '<button class="btn-publish" disabled>Published</button>';
        }
        
        // View Ballot and Delete buttons
        echo '<button class="btn-view" onclick="location.href=\'view_ballot.php?ballot_id=' . $ballotId . '\'">View Ballot</button>';
        echo '<button class="btn-delete" data-ballot-id="' . $ballotId . '" onclick="deleteBallot(this.dataset.ballotId)">Delete Ballot</button>';
        echo '</div>';
        echo '</div>';  // Close saved-ballot div
    }
} else {
    echo '<p>No saved ballots found.</p>';
}

$conn->close();
?>

<script>
    function deleteBallot(ballotId) {
        console.log("Delete function called for ballot ID: " + ballotId); // Check if function is called
        if (confirm('Are you sure you want to delete this ballot?')) {
            // AJAX request to delete_ballot.php
            fetch('delete_ballot.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' // Send as JSON
                },
                body: JSON.stringify({ ballot_id: ballotId }) // Send the ballot_id as a JSON object
            })
            .then(response => response.text())
            .then(data => {
                console.log('Response from server:', data); // Log server response
                if (data.trim() === 'success') { // Check for success response
                    // Reload the page to show updated list
                    location.reload();
                } else {
                    alert('Error deleting the ballot: ' + data); // Show specific error
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the ballot.');
            });
        }
    }
</script>
