<?php
// fetch_candidates.php
include 'include/db_candidate.php'; // Your database connection

if (isset($_GET['position_id'])) {
    $positionId = $_GET['position_id'];

    // Prepare the SQL statement
    $query = "SELECT * FROM candidate WHERE candidate_pos = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('MySQL prepare error: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("i", $positionId);
    
    // Execute the statement
    if (!$stmt->execute()) {
        die('MySQL execute error: ' . htmlspecialchars($stmt->error));
    }

    // Fetch results
    $result = $stmt->get_result();
    
    $candidates = [];
    while ($row = $result->fetch_assoc()) {
        $candidates[] = $row; // Store each candidate in the array
    }

    // Return candidates as JSON
    echo json_encode($candidates);
} else {
    echo json_encode([]); // Return an empty array if no position_id is provided
}
?>
