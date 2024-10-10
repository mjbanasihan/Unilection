<?php
// Include the database connection
include 'include/db_candidate.php'; // Ensure this path is correct

// Check if the ID is set and is a valid number
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $candidateId = intval($_POST['id']); // Get the ID from the POST request

    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM candidate WHERE ID = :id";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $candidateId, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect or show a success message
        header("Location: candidate.php?message=Candidate deleted successfully");
        exit(); // Make sure to exit after redirection
    } else {
        // Handle the error
        echo "Error deleting candidate: " . $stmt->errorInfo()[2];
    }
} else {
    // Handle invalid request
    echo "Invalid request.";
}

// Close the connection
$conn = null; // Set to null to close the connection
?>
