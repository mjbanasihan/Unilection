<?php
header('Content-Type: application/json');
// Your database query and response logic
echo json_encode($data);

ini_set('display_errors', 1);
error_reporting(E_ALL);

include('include/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getVotingResults') {
    $ballot_id = $_GET['ballot_id'];

    // Query to fetch student IDs, candidate names, and positions they voted for
    $query = "
        SELECT 
            s.student_id,  
            bp.position_name, 
            bc.candidate_name
        FROM ballot_votes bv
        JOIN student s ON bv.voters_id = s.student_id
        JOIN ballot_candidates bc ON bv.candidate_id = bc.id
        JOIN ballot_positions bp ON bc.position_id = bp.id
        WHERE bv.ballot_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $ballot_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $votes = [];
    while ($row = $result->fetch_assoc()) {
        $votes[] = $row;
    }
    
    // Debugging: Print out the fetched votes
    if (empty($votes)) {
        echo "No votes found for this ballot.";
    } else {
        echo json_encode($votes);
    }
    
}

?>
