<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="create_ballot.css">
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
            <li><a href="results">Results</a></li>
            <li><a href="status">Year Status</a></li>
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
            <li class="hideOnMobile"><a href="results">Results</a></li>
            <li class="hideOnMobile">
                <span class="nav-link">Students</span>
                <ul class="dropdown">
                    <li><a href="voters">Voters</a></li>
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
    
    <div class="create-ballot-container">
        <!-- Button to open the modal -->
        <button class="btn-create-ballot" onclick="openModal()">
            <i class="fas fa-plus"></i>
        </button>
        <span class="create-ballot-text">Create Ballot Box</span>

        <!-- Modal Section -->
        <div id="createBallotModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Create Ballot</h2>

            <!-- Ballot Title -->
            <label for="ballotTitle">Ballot Title:</label>
            <input type="text" id="ballotTitle" placeholder="Enter ballot title">

            <!-- Button to Add Group (Position and Candidates) -->
            <div id="groupsContainer"></div>

            <div class="button-container">
                <button class="btn-add-group" onclick="addGroup()">Add Group</button>
                <button class="btn-save-ballot">Save Ballot</button>
            </div>
        </div>
    </div>

    <script>
    // Open modal
        function openModal() {
            document.getElementById("createBallotModal").style.display = "block";
        }

        // Close modal
        function closeModal() {
            document.getElementById("createBallotModal").style.display = "none";
        }

        // Fetch positions from the database
        async function fetchPositions() {
            try {
                const response = await fetch('api.php'); // Ensure this points to your positions endpoint
                if (!response.ok) {
                    throw new Error('Error fetching positions: ' + response.statusText);
                }
                const positions = await response.json();
                console.log('Positions:', positions); // Log the fetched positions to the console
                return positions;
            } catch (error) {
                console.error('Error:', error);
                return [];
            }
        }

        // Fetch candidates for a given position
        async function fetchCandidatesByPosition(positionName) {
            try {
                const response = await fetch(`api.php?position=${positionName}`); // Ensure the correct path to api.php
                if (!response.ok) {
                    throw new Error('Error fetching candidates for position: ' + response.statusText);
                }
                return await response.json(); // Assuming candidates include { candidate_name, candidate_partylist }
            } catch (error) {
                console.error('Error:', error);
                return [];
            }
        }

        // Add group of position and candidates
        // Add group of position only with candidate dropdown and party list
        async function addGroup() {
            const groupsContainer = document.getElementById("groupsContainer");

            const groupDiv = document.createElement('div');
            groupDiv.className = 'group';

            // Create Position Dropdown for Group
            const positionLabel = document.createElement('label');
            positionLabel.innerHTML = 'Position:';
            const positionSelect = document.createElement('select');

            // Fetch and populate positions in the dropdown
            const positions = await fetchPositions();
            if (positions.length > 0) {
                positions.forEach(pos => {
                    const option = document.createElement('option');
                    option.value = pos.position_name;
                    option.textContent = pos.position_name;
                    positionSelect.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No positions available';
                positionSelect.appendChild(option);
            }

            // Create container for candidates and party list
            const candidatesContainer = document.createElement('div');
            candidatesContainer.className = 'candidates-container';

            // Load candidates when the position changes
            positionSelect.onchange = function () {
                loadCandidatesForPosition(this.value, candidatesContainer);
            };

            // Add Candidate Button
            const addCandidateButton = document.createElement('button');
            addCandidateButton.textContent = 'Add Candidate';
            addCandidateButton.onclick = function () {
                addCandidate(candidatesContainer, positionSelect); // Call addCandidate function
            };

            // Append elements to the group div
            groupDiv.appendChild(positionLabel);
            groupDiv.appendChild(positionSelect);
            groupDiv.appendChild(candidatesContainer);
            groupDiv.appendChild(addCandidateButton); // Add the button to the group div

            // Append group to the container
            groupsContainer.appendChild(groupDiv);

            // Trigger candidates loading if a position is already selected
            if (positions.length > 0) {
                loadCandidatesForPosition(positions[0].position_name, candidatesContainer);
            }
        }
    // Load candidates based on the selected position
        async function loadCandidatesForPosition(positionName, candidatesContainer) {
            candidatesContainer.innerHTML = '';  // Clear previous candidates

            try {
                const candidates = await fetchCandidatesByPosition(positionName);
                console.log('Candidates for position', positionName, ':', candidates); // Log candidates

                // Create dropdown for candidates
                const candidateLabel = document.createElement('label');
                candidateLabel.innerHTML = 'Candidate Name:';
                const candidateSelect = document.createElement('select');
                candidateSelect.innerHTML = `<option value="" disabled selected>Select Candidate</option>`;

                if (candidates.length > 0) {
                    candidates.forEach(candidate => {
                        const option = document.createElement('option');
                        option.value = candidate.candidate_name;  // Set value to candidate name or ID if needed
                        option.textContent = candidate.candidate_name;  // Display candidate name
                        candidateSelect.appendChild(option);
                    });

                    // Party List Dropdown
                    const partyListLabel = document.createElement('label');
                    partyListLabel.innerHTML = 'Party List:';
                    const partyListSelect = document.createElement('select');
                    partyListSelect.innerHTML = `<option value="" disabled selected>Select Party List</option>`;

                    // Populate party list based on selected candidate
                    candidateSelect.onchange = function () {
                        const selectedCandidate = candidates.find(c => c.candidate_name === this.value);
                        partyListSelect.innerHTML = `<option value="" disabled selected>Select Party List</option>`; // Reset party list options

                        if (selectedCandidate) {
                            // Create an option for the party list
                            const partyOption = document.createElement('option');
                            partyOption.value = selectedCandidate.candidate_partylist; // Assuming candidate_partylist exists
                            partyOption.textContent = selectedCandidate.candidate_partylist; // Assuming candidate_partylist is a string
                            partyListSelect.appendChild(partyOption);
                        }
                    };

                    // Append candidate and party list dropdowns to the candidatesContainer
                    candidatesContainer.appendChild(candidateLabel);
                    candidatesContainer.appendChild(candidateSelect);
                    candidatesContainer.appendChild(partyListLabel);
                    candidatesContainer.appendChild(partyListSelect);
                } else {
                    // Show "No Candidate Applied" in the dropdown
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No Candidate Applied';
                    candidateSelect.appendChild(option);
                    candidatesContainer.appendChild(candidateLabel);
                    candidatesContainer.appendChild(candidateSelect);
                }

            } catch (error) {
                console.error('Error loading candidates:', error);
            }
        }

        // Function to add a new candidate dynamically
        async function addCandidate(candidatesContainer, positionSelect) {
            const candidateDiv = document.createElement('div');
            candidateDiv.className = 'candidate';

            // Candidate Name Dropdown
            const candidateNameLabel = document.createElement('label');
            candidateNameLabel.innerHTML = 'Candidate Name:';
            const candidateNameSelect = document.createElement('select');
            candidateNameSelect.innerHTML = `<option value="" disabled selected>Select Candidate</option>`;

            // Party List Dropdown
            const partyListLabel = document.createElement('label');
            partyListLabel.innerHTML = 'Party List:';
            const partyListSelect = document.createElement('select');
            partyListSelect.innerHTML = `<option value="" disabled selected>Select Party List</option>`;

            // Get the currently selected position
            const position = positionSelect.value;

            // Load candidates for the selected position
            try {
                const candidates = await fetchCandidatesByPosition(position);
                console.log('Candidates for position', position, ':', candidates); // Log candidates

                if (candidates && candidates.length > 0) {
                    candidates.forEach(candidate => {
                        const option = document.createElement('option');
                        option.value = candidate.candidate_name;  // Set value to candidate name
                        option.textContent = candidate.candidate_name;  // Display candidate name
                        candidateNameSelect.appendChild(option);
                    });

                    // Populate party list dropdown when a candidate is selected
                    candidateNameSelect.onchange = function () {
                        const selectedCandidate = candidates.find(c => c.candidate_name === this.value);
                        partyListSelect.innerHTML = ''; // Clear previous party list options

                        if (selectedCandidate) {
                            // Create option for party list
                            const option = document.createElement('option');
                            option.value = selectedCandidate.candidate_partylist;  // Set to party list name or ID if needed
                            option.textContent = selectedCandidate.candidate_partylist;  // Display party list name
                            partyListSelect.appendChild(option);
                        }
                    };
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No candidates available for this position';
                    candidateNameSelect.appendChild(option);
                }
            } catch (error) {
                console.error('Error loading candidates:', error);
            }

            // Append all candidate inputs to candidateDiv
            candidateDiv.appendChild(candidateNameLabel);
            candidateDiv.appendChild(candidateNameSelect);
            candidateDiv.appendChild(partyListLabel);
            candidateDiv.appendChild(partyListSelect); // Append the party list dropdown

            // Append candidateDiv to the candidatesContainer
            candidatesContainer.appendChild(candidateDiv);
        }

        // Close the modal when clicking outside of it
        window.onclick = function (event) {
            const modal = document.getElementById("createBallotModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>


</body>
</html>