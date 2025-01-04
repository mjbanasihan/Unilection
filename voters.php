<?php
$host = 'localhost';
$dbname = 'election';
$username = 'root';
$password = '';

try {
    // Establish the database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handling the action for fetching ballots
    if (isset($_GET['action']) && $_GET['action'] == 'getPublishedBallots') {
        $stmt = $pdo->query("SELECT ballot_id, ballot_title FROM ballots WHERE status = 'published'");
        $ballots = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($ballots);
    }

    // Handling the action for fetching voting results
    if (isset($_GET['action']) && $_GET['action'] == 'getVotingResults' && isset($_GET['ballot_id'])) {
        $ballot_id = (int)$_GET['ballot_id'];
        
        $sql = "
        SELECT
            s.student_id,
            bp.position_name,
            bc.candidate_name
        FROM ballot_votes bv
        JOIN ballot_candidates bc ON bv.candidate_id = bc.id
        JOIN ballot_positions bp ON bc.position_id = bp.id
        JOIN student s ON bv.voters_id = s.student_id
        WHERE bv.ballot_id = :ballot_id;
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ballot_id', $ballot_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $votes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($votes);
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="results.css">
    <link rel="stylesheet" href="voters.css">

    <style>
        /* Table styles */
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto; /* Centers the table */
            background-color: white; /* Sets the table background to white */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds subtle shadow for better visibility */
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: maroon;
            color: white;
        }

        /* Dropdown container styles */
        .dropdown-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }
    </style>
</head>
<header>
    <div class="top-above-rectangle"></div>
    <button class="admin-icon" aria-label="Admin">
        <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e8eaed">
            <path d="M226-262q59-42.33 121.33-65.5 62.34-23.17 132.67-23.17 70.33 0 133 23.17T734.67-262q41-49.67 59.83-103.67T813.33-480q0-141-96.16-237.17Q621-813.33 480-813.33t-237.17 96.16Q146.67-621 146.67-480q0 60.33 19.16 114.33Q185-311.67 226-262Zm253.88-184.67q-58.21 0-98.05-39.95Q342-526.58 342-584.79t39.96-98.04q39.95-39.84 98.16-39.84 58.21 0 98.05 39.96Q618-642.75 618-584.54t-39.96 98.04q-39.95 39.83-98.16 39.83ZM480.31-80q-82.64 0-155.64-31.5-73-31.5-127.34-85.83Q143-251.67 111.5-324.51T80-480.18q0-82.82 31.5-155.49 31.5-72.66 85.83-127Q251.67-817 324.51-848.5T480.18-880q82.82 0 155.49 31.5 72.66 31.5 127 85.83Q817-708.33 848.5-635.65 880-562.96 880-480.31q0 82.64-31.5 155.64-31.5 73-85.83 127.34Q708.33-143 635.65-111.5 562.96-80 480.31-80Zm-.31-66.67q54.33 0 105-15.83t97.67-52.17q-47-33.66-98-51.5Q533.67-284 480-284t-104.67 17.83q-51 17.84-98 51.5 47 36.34 97.67 52.17 50.67 15.83 105 15.83Zm0-366.66q31.33 0 51.33-20t20-51.34q0-31.33-20-51.33T480-656q-31.33 0-51.33 20t-20 51.33q0 31.34 20 51.34 20 20 51.33 20Zm0-71.34Zm0 369.34Z"/>
        </svg>
    </button>

    <div class="dropdown-menu">
        <a href="account.php">Check Account</a>
    </div>


    <div class="LSPUlogo">
        <img src="2-removebg-preview.png" alt="LSPU Logo">
    </div>

    <div class="CCSlogo">
        <img src="CCS.png" alt="CCS Logo">
    </div>

    <div class="LSPU-LB">
        <h1>Laguna State Polytechnic University</h1>
        <h2>College of Computer Studies</h2>
    </div>
    <div class="top-next-rectangle"></div>
</header>

<body>
    <nav>
        <ul class="sidebar">
            <li onclick="hideSidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#e8eaed"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="admin.html">Home</a></li>  
            <li><a href="create_ballot.php">Ballots</a></li>
            <li><a href="result.php">Results</a></li>
            <li><a href="status.php">Year Status</a></li>
        </ul>
        <ul>
            <li class="hideOnMobile"><a href="admin.php">Home</a></li>
            <li class="hideOnMobile">
                <span class="nav-link">Ballots</span>
                    <ul class="dropdown">
                        <li><a href="position.php">Position</a></li>
                        <li><a href="candidate.php">Candidate</a></li>
                        <li><a href="create_ballot.php">Ballot Sheet</a></li>
                    </ul>
            <li class="hideOnMobile"><a href="results.php">Results</a></li>
            <li class="hideOnMobile">
                <span class="nav-link">Students</span>
                <ul class="dropdown">
                    <li><a href="voters.php">Voters</a></li>
                    <li><a href="year_status.php">Year Status</a></li>
                    <li><a href="manage_student.php">Manage</a></li>
                </ul>
            </li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li class="menu-button" onclick="showSidebar()">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="60 -960 960 960" width="18px" fill="#e8eaed">
                        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
                    </svg>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Dropdown to select the published ballot -->
    <div class="dropdown-container">
        <label for="ballotDropdown">Select Published Ballot:</label>
        <select id="ballotDropdown">
            <option value="">-- Select a Ballot --</option>
        </select>
    </div>

    <div id="votesTableContainer"></div>

    <script>
        // Fetch published ballots
        fetch('results_bckend.php?action=getPublishedBallots')
            .then(response => response.json())
            .then(data => {
                const ballotDropdown = document.getElementById('ballotDropdown');
                data.forEach(ballot => {
                    const option = document.createElement('option');
                    option.value = ballot.ballot_id;
                    option.textContent = ballot.ballot_title;
                    ballotDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching ballots:', error));

        // Fetch voting results when a ballot is selected
        function fetchVotingResults(ballot_id) {
            fetch(`results_bckend.php?action=getVotingResults&ballot_id=${ballot_id}`)
                .then(response => response.json())
                .then(data => {
                    displayVotingResults(data);
                })
                .catch(error => console.error('Error fetching voting results:', error));
        }

        // Display the results in a table
        function displayVotingResults(votes) {
            const container = document.getElementById('votesTableContainer');

            // Identify unique positions
            const positions = [...new Set(votes.map(vote => vote.position_name))];

            // Start constructing the table
            let tableHTML = `
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
            `;

            // Add a column for each position in the ballot
            positions.forEach(position => {
                tableHTML += `<th>${position}</th>`;
            });

            tableHTML += `
                    </tr>
                </thead>
                <tbody>
            `;

            // Group votes by student ID
            const groupedVotes = votes.reduce((acc, vote) => {
                if (!acc[vote.student_id]) {
                    acc[vote.student_id] = { student_id: vote.student_id };
                }
                acc[vote.student_id][vote.position_name] = vote.candidate_name;
                return acc;
            }, {});

            // Loop through each student and their votes
            Object.values(groupedVotes).forEach(student => {
                // Masking the student ID except for the first 4 characters
                const maskedStudentId = student.student_id.slice(0, 4) + '****';

                tableHTML += `<tr><td>${maskedStudentId}</td>`;

                // Add a cell for each position, displaying "*" based on the length of the candidate's name
                positions.forEach(position => {
                    if (student[position]) {
                        const candidateName = student[position];
                        const stars = '*'.repeat(candidateName.length); // Repeat '*' based on the length of the candidate's name
                        tableHTML += `<td>${stars}</td>`;
                    } else {
                        tableHTML += `<td>No vote</td>`;
                    }
                });

                tableHTML += `</tr>`;
            });

            tableHTML += `
                </tbody>
            </table>
            `;
            container.innerHTML = tableHTML;
        }




        // Event listener for dropdown change
        document.getElementById('ballotDropdown').addEventListener('change', function () {
            const selectedBallotId = this.value;
            if (selectedBallotId) {
                fetchVotingResults(selectedBallotId);
            }
        });
    </script>

</body>
</html>