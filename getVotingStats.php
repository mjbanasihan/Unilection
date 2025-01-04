<?php
// Database connection variables
$host = 'localhost';
$dbname = 'election';
$username = 'root';
$password = '';

try {
    // Establish the database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_GET['action'] == 'getPublishedBallots') {
        $stmt = $pdo->query("SELECT ballot_id, ballot_title FROM ballots WHERE status = 'published'");
        $ballots = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($ballots);
    }

    // Fetch voting statistics for selected ballot
    if (isset($_GET['action']) && $_GET['action'] == 'getVotingStats') {
        $sql = "
            SELECT 
                s.course,
                s.year_level,
                s.section,
                COUNT(DISTINCT bv.voters_id) AS voted,  -- Count distinct voters (unique students who voted)
                (COUNT(s.student_id) - COUNT(bv.voters_id)) AS not_voted  -- Total students - distinct voters
            FROM student s
            LEFT JOIN ballot_votes bv ON s.student_id = bv.voters_id
            GROUP BY s.course, s.year_level, s.section;
        ";

        $stmt = $pdo->query($sql);
        $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($stats)) {
            echo json_encode([]); // Return an empty array if no results found
        } else {
            echo json_encode($stats); // Return the fetched data in JSON format
        }
    }

    
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
