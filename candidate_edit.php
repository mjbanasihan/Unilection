<?php
// Include database connection
include 'include/db_candidate.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $candidate_id = $_POST['candidate_id'];
    $candidate_name = $_POST['candidate_name'];
    $candidate_pos = $_POST['candidate_pos'];
    $candidate_partylist = $_POST['candidate_partylist'];

    // Prepare SQL update statement
    $sql = "UPDATE candidate SET candidate_name = :candidate_name, candidate_pos = :candidate_pos, candidate_partylist = :candidate_partylist WHERE ID = :candidate_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':candidate_name', $candidate_name);
    $stmt->bindParam(':candidate_pos', $candidate_pos); // Add a colon (:) before 'candidate_pos'
    $stmt->bindParam(':candidate_partylist', $candidate_partylist);
    $stmt->bindParam(':candidate_id', $candidate_id); // Bind the candidate_id

    if ($stmt->execute()) {
        // Redirect or show success message
        header("Location: candidate.php");
        exit;
    } else {
        echo "Error updating record.";
    }
}
?>
