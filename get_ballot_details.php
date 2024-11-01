<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "election";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

if (isset($_GET['ballot_id'])) {
    $ballotId = intval($_GET['ballot_id']);
    $positions = [];

    // Fetch positions for the ballot
    $sql = "SELECT position_name FROM positions WHERE ballot_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $ballotId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($position = $result->fetch_assoc()) {
            $posName = $position['position_name'];
            $candidatesSql = "SELECT candidate_name FROM candidates WHERE candidate_pos = ?";
            if ($candidatesStmt = $conn->prepare($candidatesSql)) {
                $candidatesStmt->bind_param("s", $posName);
                $candidatesStmt->execute();
                $candidatesResult = $candidatesStmt->get_result();

                $candidates = [];
                while ($candidate = $candidatesResult->fetch_assoc()) {
                    $candidates[] = $candidate['candidate_name'];
                }

                $positions[$posName] = $candidates;
                $candidatesStmt->close();
            } else {
                echo json_encode(['error' => 'Failed to prepare candidates statement.']);
                exit();
            }
        }

        echo json_encode($positions);
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare positions statement.']);
        exit();
    }
} else {
    echo json_encode(['error' => 'No ballot_id provided.']);
}

$conn->close();
?>
