<?php
// Include database connection
include 'include/db_candidate.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $candidate_name = $_POST['candidate_name'];
    $candidate_pos = $_POST['candidate_pos'];
    $candidate_partylist = $_POST['candidate_partylist'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO candidate (candidate_name, candidate_pos, candidate_partylist) VALUES (:candidate_name, :candidate_pos, :candidate_partylist)");
    
    // Bind parameters
    $stmt->bindParam(':candidate_name', $candidate_name);
    $stmt->bindParam(':candidate_pos', $candidate_pos);
    $stmt->bindParam(':candidate_partylist', $candidate_partylist);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: candidate.php");
        exit();
    } else {
        echo "Error: Could not add candidate.";
    }
}

$conn = null;
?>