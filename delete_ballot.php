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
$ballotId = $data['ballot_id']; // Fetch the ballot ID from the data

// Prepare the SQL statement to delete the ballot and related records
$sql = "DELETE FROM ballots WHERE ballot_id = ?"; // Use the correct column name
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ballotId);

if ($stmt->execute()) {
    // Optionally delete related positions and candidates
    $sql = "DELETE FROM ballot_positions WHERE ballot_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ballotId);
    $stmt->execute();

    echo 'success'; // Return success message
} else {
    echo "Error: " . $stmt->error; // Return error message
}

$stmt->close();
$conn->close();
?>
