<?php
include 'database_connection.php'; // Adjust this to match your connection file

if (isset($_POST['ballotId'])) {
    $ballotId = $_POST['ballotId'];

    // Query to retrieve each position and its candidates along with vote counts
    $query = "
        SELECT 
            p.position_name, 
            c.candidate_name, 
            COUNT(v.vote_id) AS vote_count
        FROM ballot_positions bp
        JOIN position p ON bp.position_id = p.position_id
        JOIN ballot_candidates bc ON bc.position_id = bp.position_id AND bc.ballot_id = bp.ballot_id
        JOIN candidate c ON bc.candidate_id = c.id
        LEFT JOIN ballot_votes v ON v.candidate_id = c.id AND v.ballot_id = bp.ballot_id
        WHERE bp.ballot_id = ?
        GROUP BY p.position_name, c.candidate_name
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $ballotId);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
