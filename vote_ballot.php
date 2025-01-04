<?php
// Database connection variables
$host = 'localhost'; // Replace with your database host
$dbname = 'election'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Start session to access voter data
session_start();

// Ensure voter is logged in and has a voter ID
if (!isset($_SESSION['voter_id'])) {
    echo json_encode(['error' => 'Voter is not logged in.']);
    exit();
}

$voter_id = $_SESSION['voter_id']; // Assuming the voter ID is stored in session

try {
    // Establish the database connection using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if ballot_id is provided
    if (isset($_GET['ballot_id'])) {
        $ballotId = intval($_GET['ballot_id']);

        // Check if the voter has already voted for this ballot
        $checkVoteSql = "SELECT * FROM ballot_votes WHERE ballot_id = ? AND voter_id = ?";
        $stmt = $pdo->prepare($checkVoteSql);
        $stmt->bindParam(1, $ballotId, PDO::PARAM_INT);
        $stmt->bindParam(2, $voter_id, PDO::PARAM_INT);
        $stmt->execute();

        // If the voter has already voted, display an error message
        if ($stmt->rowCount() > 0) {
            echo json_encode(['error' => 'You have already voted for this ballot.']);
            exit();
        }

        // SQL to retrieve ballot positions and candidates
        $sql = "
            SELECT 
                bp.position_name, 
                bc.candidate_name 
            FROM 
                ballot_positions bp
            JOIN 
                ballot_candidates bc ON bp.id = bc.position_id
            WHERE 
                bp.ballot_id = :ballot_id
            ORDER BY 
                bp.id, bc.candidate_name";
        
        // Prepare the SQL statement
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ballot_id', $ballotId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the results
        $positions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $positions[$row['position_name']][] = $row['candidate_name'];
        }

        // Check if we found positions and candidates
        if (empty($positions)) {
            echo json_encode(['error' => 'No positions or candidates found for the given ballot_id.']);
        } else {
            // Show the positions and candidates for voting
            echo json_encode($positions, JSON_PRETTY_PRINT);
        }

    } else {
        echo json_encode(['error' => 'No ballot_id provided.']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}

// Close the connection
$pdo = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="preview.css">
    <title>Vote for Ballot</title>
</head>
<body>
    <h2>Ballot Voting</h2>

    <?php if (!empty($positions)): ?>
        <form id="voteForm">
            <?php foreach ($positions as $position => $candidates): ?>
                <div>
                    <h3><?php echo htmlspecialchars($position); ?></h3>
                    <?php foreach ($candidates as $candidate): ?>
                        <label>
                            <input type="radio" name="<?php echo htmlspecialchars($position); ?>" value="<?php echo htmlspecialchars($candidate); ?>">
                            <?php echo htmlspecialchars($candidate); ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit">Submit Vote</button>
        </form>
    <?php else: ?>
        <p>No positions or candidates available for this ballot.</p>
    <?php endif; ?>

    <script>
        document.getElementById('voteForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const ballotData = {};
            const formElements = event.target.elements;

            for (const element of formElements) {
                if (element.type === 'radio' && element.checked) {
                    ballotData[element.name] = element.value;
                }
            }

            try {
                const response = await fetch('stud_vote.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(ballotData),
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                alert('Vote cast successfully!');
            } catch (error) {
                console.error('Error casting vote:', error);
                alert('An error occurred while casting your vote.');
            }
        });
    </script>
</body>
</html>
