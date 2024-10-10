<?php
include 'include/db_candidate.php';
include 'include/db_position.php'; // Ensure this path is correct

$sql = "SELECT ID, candidate_name, candidate_pos, candidate_partylist FROM candidate"; // Corrected 'candidate-pos' to 'candidate_pos'
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="candidate.css">
    <style>
       /* Table styling */
        table {
            width: 80%; 
            border-collapse: collapse; 
            margin: 10px auto; 
        }

        th, td {
            border: 1px solid #ddd; /* Adds a light gray border */
            padding: 10px; /* Adds padding inside table cells */
            text-align: left; /* Aligns text to the left */
        }

        th {
            background-color: #f2f2f2; 
        }

        tr:hover {
            background-color: #f1f1f1; 
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

    <div class="admin-dropdown-menu">
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
            <li><a href="ballot">Ballots</a></li>
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
                        <li><a href="Candidates">Candidate</a></li>
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

    <div class="candid">
        <h2>Candidates</h2>
        <div>
            <button class="add-cand" onclick="openModal()">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Candidate Name</th>
                        <th>Candidate Position</th>
                        <th>Candidate Partylist</th>
                        <th style="width: 168px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->rowCount() > 0) { // Use rowCount() for PDO
                        // Output data of each row
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['candidate_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['candidate_pos']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['candidate_partylist']) . "</td>";
                            echo "<td>"
                                . "<a href='#' class='btn edit-btn' onclick='openEditModal(\"" . htmlspecialchars($row["candidate_name"]) . "\", \"" . htmlspecialchars($row["candidate_pos"]) . "\", \"" . htmlspecialchars($row["candidate_partylist"]) . "\", " . htmlspecialchars($row["ID"]) . ")'>Edit</a> "
                                . "<a href='#' class='btn delete-btn' onclick='openDeleteModal(" . htmlspecialchars($row["ID"]) . ")'>Delete</a>"
                                . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No candidates found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="modal" id="myModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add Candidate</h2>
            <form action="candidate_add.php" method="POST">
                <label for="candidate_name">Candidate Name:</label>
                <input type="text" id="candidate_name" name="candidate_name" required>

                <label for="candidate_pos">Candidate Position:</label>
                <select id="candidate_pos" name="candidate_pos" required>
                    <option value="">Select a Position</option>
                    <?php
                    // Fetch positions from the database
                    include 'include/db_candidate.php'; // Ensure the path is correct
                    $position_sql = "SELECT ID, position_name FROM position"; // Adjust table/column names if necessary
                    $position_result = $conn->query($position_sql);

                    if ($position_result->rowCount() > 0) {
                        while ($position_row = $position_result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($position_row["position_name"]) . "'>" . htmlspecialchars($position_row["position_name"]) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No positions available</option>";
                    }

                    // Close the database connection
                    $conn = null;
                    ?>
                </select>

                <label for="candidate_partylist">Candidate Partylist:</label>
                <input type="text" id="candidate_partylist" name="candidate_partylist" required>

                <button type="submit" class="submit-btn">Add Candidate</button>
            </form>
        </div>
    </div>


    <script>
        // Function to open the modal
        function openModal() {
            document.getElementById('myModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        // Close the modal when clicking outside of the modal content
        window.onclick = function(event) {
            const modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <div class="modal" id="editModal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Candidate</h2>
            <form id="editForm" action="candidate_edit.php" method="POST">
                <input type="hidden" id="edit_candidate_id" name="candidate_id">

                <label for="edit_candidate_name">Candidate Name:</label>
                <input type="text" id="edit_candidate_name" name="candidate_name" required>

                <label for="edit_candidate_pos">Candidate Position:</label>
                <input type="text" id="edit_candidate_pos" name="candidate_pos" required>

                <label for="edit_candidate_partylist">Candidate Partylist:</label>
                <input type="text" id="edit_candidate_partylist" name="candidate_partylist" required>

                <button type="submit" class="submit-btn">Update</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(candidateName, candidatePos, candidatePartylist, candidateId) {
            document.getElementById('edit_candidate_name').value = candidateName;
            document.getElementById('edit_candidate_pos').value = candidatePos;
            document.getElementById('edit_candidate_partylist').value = candidatePartylist;
            document.getElementById('edit_candidate_id').value = candidateId;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>

    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this candidate?</p>
            <form id="deleteForm" action="candidate_delete.php" method="POST">
                <input type="hidden" id="delete_candidate_id" name="id">

                <div style="display: flex; justify-content: space-between;">
                    <button type="submit" class="delete-btn">Delete</button>
                    <button type="button" class="cancel-btn" onclick="closeDeleteModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentDeleteId;

        function openDeleteModal(positionId) {
            currentDeleteId = positionId; // Store the ID to delete
            document.getElementById('delete_candidate_id').value = positionId; // Set the ID in the hidden field
            document.getElementById('deleteModal').style.display = 'block'; // Open the delete modal
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none'; // Close the delete modal
        }
    </script>

    <script>
        document.querySelector('.admin-icon').addEventListener('click', function(event) {
            const dropdown = document.querySelector('.admin-dropdown-menu');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            event.stopPropagation(); // Prevent the click event from bubbling up
        });

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            const dropdown = document.querySelector('.admin-dropdown-menu');
            // Check if the clicked target is not the admin icon and not inside the dropdown
            if (!event.target.matches('.admin-icon') && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        }
    </script>
<div>