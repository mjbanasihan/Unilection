<?php
// unpublish_ballot.php
$servername = "localhost";
$username = "root";
$password = ""; // XAMPP default, update if necessary
$dbname = "election";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$ballotId = $data['ballot_id'];

if ($ballotId) {
    // Update the status to 'draft'
    $stmt = $conn->prepare("UPDATE ballots SET status = 'draft' WHERE ballot_id = ?");
    $stmt->bind_param("i", $ballotId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error: ' . $stmt->error;
    }

    $stmt->close();
} else {
    echo 'error: Invalid ballot ID';
}

$conn->close();
?>
