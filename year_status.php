<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        <link rel="stylesheet" href="create_ballot.css">
        <link rel="stylesheet" href="results.css">
        <style>
            /* Container for the chart cards */
            .chart-cards-container {
                display: flex;
                flex-wrap: wrap; /* Allows items to wrap onto the next line */
                gap: 20px; /* Space between the cards */
                justify-content: center; /* Centers the items horizontally */
            }

            /* Each individual chart card */
            .chart-container {
                background-color: white;
                border: 1px solid #ddd;
                padding: 20px;
                margin: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                height: auto;
                width: 30%; /* Adjust the width so there are 3 items per row */
                max-width: 600px; /* Ensure the card doesn't stretch too wide */
                box-sizing: border-box;
            }

            /* Adjust canvas size */
            #yearLevelChart {
                background-color: white;
                width: 100%;
                height: 300px;
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
            <a href="check-account">Check Account</a>
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
    <main>
        <div class="dropdown-container">
            <label for="ballotDropdown">Select Published Ballot:</label>
            <select id="ballotDropdown">
                <option value="">-- Select a Ballot --</option>
            </select>
        </div>
        <!-- Container to hold all chart cards -->
        <div class="chart-cards-container">
            <!-- Dynamic chart cards will be appended here -->
        </div>

    </main>
    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            .catch(error => console.error('Error fetching published ballots:', error));

            // Fetch voting statistics for selected ballot
            document.getElementById('ballotDropdown').addEventListener('change', function () {
                const selectedBallot = this.value;
                if (!selectedBallot) return; // Return if no ballot is selected

                fetch(`results_bckend.php?action=getVotingStats`)
                    .then(response => response.json())
                    .then(data => {
                        // Prepare data for chart
                        const courseStats = {};

                        data.forEach(item => {
                            const key = `${item.course} ${item.year_level} ${item.section}`;
                            if (!courseStats[key]) {
                                courseStats[key] = { courses: key, voted: 0, notVoted: 0 };
                            }
                            courseStats[key].voted += item.voted;
                            courseStats[key].notVoted += item.not_voted;
                        });

                        // Clear any existing charts
                        const chartContainer = document.querySelector('.chart-cards-container');
                        chartContainer.innerHTML = ''; // Clear existing content

                        // Create chart for each course, year_level, section
                        Object.keys(courseStats).forEach(courseKey => {
                            const stats = courseStats[courseKey];

                            // Create a new div for each course
                            const chartDiv = document.createElement('div');
                            chartDiv.classList.add('chart-container');
                            chartContainer.appendChild(chartDiv);

                            // Create the canvas element
                            const canvas = document.createElement('canvas');
                            chartDiv.appendChild(canvas);
                            const ctx = canvas.getContext('2d');

                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [stats.courses],
                                    datasets: [{
                                        label: 'Voted',
                                        data: [stats.voted],
                                        backgroundColor: '#4caf50',
                                    }, {
                                        label: 'Not Voted',
                                        data: [stats.notVoted],
                                        backgroundColor: '#f44336',
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        title: {
                                            display: true,
                                            text: `Voting Stats for ${stats.courses}`,
                                        }
                                    }
                                }
                            });
                        });
                    })
                    .catch(error => console.error('Error fetching voting stats:', error));
            });

    </script>

    <script> //Admin Icon
        const adminIcon = document.querySelector('.admin-icon'); // Use querySelector to select the class
        const dropdownMenu = document.querySelector('.dropdown-menu'); // Ensure correct selection for the dropdown

        // Toggle dropdown visibility when admin icon is clicked
        adminIcon.onclick = function () {
            if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
                dropdownMenu.style.display = 'block'; // Show the dropdown
            } else {
                dropdownMenu.style.display = 'none'; // Hide the dropdown
            }
        };

        // Close the dropdown if the user clicks outside of it
        window.onclick = function (event) {
            if (!adminIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        };
    </script>
</body>
</html>
