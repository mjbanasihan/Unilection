<?php
// Include database connection
include 'include/db_position.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $position_name = $_POST['position_name'];
    $max_vote = $_POST['max_vote'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO position (position_name, max_vote) VALUES (:position_name, :max_vote)");
    
    // Bind parameters
    $stmt->bindParam(':position_name', $position_name);
    $stmt->bindParam(':max_vote', $max_vote);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to the positions page
        header("Location: position.php");
        exit();
    } else {
        echo "Error: Could not add position.";
    }
}

// Close the connection
$conn = null;
?>