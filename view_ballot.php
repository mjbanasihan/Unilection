<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";  // XAMPP default, update if necessary
$dbname = "election";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ballot ID from the URL
if (isset($_GET['ballot_id'])) {
    $ballotId = intval($_GET['ballot_id']); // Ensure it's an integer to prevent SQL injection

    // Fetch the ballot details
    $sql = "SELECT * FROM ballots WHERE ballot_id = $ballotId";
    $ballotResult = $conn->query($sql);

    if ($ballotResult->num_rows > 0) {
        $ballot = $ballotResult->fetch_assoc();
        
        // Ballot title and status
        echo '<div class="ballot-preview-container">';
        echo '<h1>' . htmlspecialchars($ballot['ballot_title']) . '</h1>';
        echo '<p>Status: ' . htmlspecialchars($ballot['status']) . '</p>';

        // Fetch positions for this ballot
        $positionsSql = "SELECT * FROM ballot_positions WHERE ballot_id = $ballotId";
        $positionsResult = $conn->query($positionsSql);

        if ($positionsResult->num_rows > 0) {
            echo '<form id="voteForm">'; // Add form for voting
            echo '<ul class="positions">';
            while ($position = $positionsResult->fetch_assoc()) {
                echo '<li class="position-title">' . htmlspecialchars($position['position_name']) . ' <span class="max-vote">(Max Votes: ' . htmlspecialchars($position['max_vote']) . ')</span></li>';
                
                // Fetch and display candidates
                $candidatesSql = "SELECT * FROM ballot_candidates WHERE position_id = " . $position['id'];
                $candidatesResult = $conn->query($candidatesSql);

                if ($candidatesResult->num_rows > 0) {
                    echo '<ul class="candidate-list">';
                    while ($candidate = $candidatesResult->fetch_assoc()) {
                        echo '<li>';
                        echo '<input type="radio" name="candidate_' . $position['id'] . '" value="' . $candidate['id'] . '" id="candidate_' . $candidate['id'] . '">'; // Assign radio button to each candidate
                        echo '<label for="candidate_' . $candidate['id'] . '">' . htmlspecialchars($candidate['candidate_name']) . ' - ' . htmlspecialchars($candidate['candidate_partylist']) . '</label>';
                        echo '</li>';
                    }
                    echo '</ul>'; // Close candidate-list
                } else {
                    echo '<li>No candidates for this position.</li>';
                }
            }
            echo '</ul>'; // Close positions
            echo '</form>';
        } else {
            echo '<p>No positions found for this ballot.</p>';
        }
    } else {
        echo '<p>No ballot found with the provided ID.</p>';
    }
}

$conn->close();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="create_ballot.css">
    <link rel="stylesheet" href="preview.css">
</head>