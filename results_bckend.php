<?php
// Assuming you have a database connection setup in this file
include('db_connection.php');

if (isset($_GET['action']) && $_GET['action'] == 'getPublishedBallots') {
    $query = "SELECT ballot_id, ballot_title FROM ballots WHERE status = 'published'";
    $result = mysqli_query($conn, $query);
    
    $ballots = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ballots[] = $row;
        }
    }
    
    // Send response as JSON
    header('Content-Type: application/json');
    echo json_encode($ballots);
    exit;
}
?>