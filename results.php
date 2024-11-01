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
        /* Example CSS for the saved ballots wrapper */
        .saved-ballots-wrapper {
            background-color: #f9f9f9; /* Light background for contrast */
            border: 1px solid #ccc; /* Light border for definition */
            border-radius: 10px; /* Rounded corners */
            padding: 20px; /* Space around the contents */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
            width: 100%; /* Full width of the parent */
            max-width: 700px; /* Maximum width for larger screens */
            margin: 20px auto; /* Center horizontally with space above and below */
        }

        .saved-ballots-container h3 {
            text-align: center;
            color: #6b1e1e;
            margin-bottom: 15px; /* Space below the header */
            font-size: 2em; /* Larger font size for the header */
        }

        .ballot-title {
            font-size: 24px;
            font-weight: bold;
        }

        .ballot-actions {
            margin-top: 10px; /* Space above buttons */
        }

        .ballot-actions button {
            border: none; /* Remove border */
            background-color: #4CAF50; /* Change background color */
            color: white; /* Text color */
            padding: 5px 10px; /* Smaller padding */
            text-align: center; /* Center text */
            text-decoration: none; /* Remove underline */
            display: inline-block; /* Inline block */
            font-size: 14px; /* Smaller font size */
            margin: 2px; /* Smaller margin */
            cursor: pointer; /* Pointer cursor on hover */
            border-radius: 4px; /* Optional: Rounded corners */
        }

        /* Optional: Add hover effect */
        .ballot-actions button:hover {
            background-color: #45a049; /* Darker background on hover */
        }

        .ballot-actions .btn-view {
            background-color: #4CAF50; /* Green */
            color: white;
        }

        .ballot-actions .btn-publish {
            background-color: #008CBA; /* Blue */
            color: white;
        }

        .ballot-actions .btn-edit {
            background-color: #f0ad4e; /* Yellow */
            color: white;
        }

        .ballot-actions .btn-delete {
            background-color: #f44336; /* Red */
            color: white;
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
        <a href="logout">Log Out</a>
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
            <li><a href="#">Students</a></li>
        </ul>
        <ul>
            <li class="hideOnMobile"><a href="admin.html">Home</a></li>
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
                    <li><a href="status">Year Status</a></li>
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

    <body>
    <!-- Dropdown for Published Ballots -->
    <div class="dropdown-container">
        <label for="ballotDropdown">Select Published Ballot:</label>
        <select id="ballotDropdown" onchange="viewBallot(this)">
            <option value="">-- Select a Ballot --</option>
        </select>
    </div>

    <div id="chartContainer" style="width: 80%; margin: auto; padding-top: 20px;">
        <canvas id="votingChart"></canvas>
    </div>

    <script>
        // Fetch published ballots using AJAX
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

        // Redirect on selection
        function viewBallot(select) {
            const ballotId = select.value;
            if (ballotId) {
                window.location.href = `view_ballot.php?ballot_id=${ballotId}`;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.getElementById('ballotDropdown').addEventListener('change', function() {
            const ballotId = this.value;
            if (ballotId) {
                fetchVotingResults(ballotId);
            }
        });

        function fetchVotingResults(ballotId) {
            fetch('getVotingResults.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'ballotId=' + ballotId
            })
            .then(response => response.json())
            .then(data => displayChart(data))
            .catch(error => console.error('Error fetching voting results:', error));
        }

        function displayChart(data) {
            const labels = [];
            const voteData = [];

            data.forEach(item => {
                labels.push(item.candidate_name + " (" + item.position_name + ")");
                voteData.push(item.vote_count);
            });

            const ctx = document.getElementById('votingChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Votes',
                        data: voteData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    </script>
</body>
</html>