<?php
// Include the database connection file
include 'include/db_connect.php';

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Fetch admin data from the database
$sql = "SELECT * FROM adminv"; // Change 'adminv' to your actual admin table name if necessary
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="manage_admin.css">
    <style>
       /* Table styling */
        table {
            width: 70%; 
            border-collapse: collapse; 
            margin: 30px auto; 
        }

        th, td {
            border: 1px solid #ddd; /* Adds a light gray border */
            padding: 10px; /* Adds padding inside table cells */
            text-align: left; /* Aligns text to the left */
        }

        th {
            background-color: #f2f2f2; /* Light gray background for header */
        }

        tr:hover {
            background-color: #f1f1f1; /* Highlights row on hover */
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
            <li><a href="edit">Edit Site</a></li>
            <li><a href="results">Results</a></li>
            <li><a href="status">Year Status</a></li>
            <li><a href="#">Students</a></li>
        </ul>
        <ul>
            <li class="hideOnMobile"><a href="admin.html">Home</a></li>
            <li class="hideOnMobile"><a href="edit">Edit Site</a></li>
            <li class="hideOnMobile"><a href="results">Results</a></li>
            <li class="hideOnMobile">
                <span class="nav-link">Students</span>
                <ul class="dropdown">
                    <li><a href="voters">Voters</a></li>
                    <li><a href="status">Year Status</a></li>
                    <li><a href="manage">Manage</a></li>
                </ul>
            </li>
            <li class="hideOnMobile"><a href="ballot">Ballots</a></li>
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

    <!-- Table to display database results -->
    <<div class="admin-data">
        <h2>Admin Table</h2>

        <!-- Flex container for search bar and Add Admin button -->
        <div class="action-bar">
            <div class="search-bar">
                <form action="manage_admin.php" method="GET" style="display: flex; align-items: center;">
                    <input type="text" name="search" placeholder="Search Admin..." required>
                    <button type="submit">Search</button>
                </form>
                <button id="addAdminBtn" class="add-admin-btn">Add Admin</button>
            </div>
        </div>
    <div>
    <div>
        </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Admin ID</th>
                    <th>Admin Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Actions</th> <!-- Added header for Password -->
                </tr>
                <?php
                // Check if a search query is set
                $search = isset($_GET['search']) ? $_GET['search'] : '';

                // Fetch admin data from the database with search functionality
                $sql = "SELECT * FROM adminv"; // Change 'adminv' to your actual admin table name if necessary
                if (!empty($search)) {
                    // Sanitize input and add WHERE clause for search
                    $sql .= " WHERE admin_lastn LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                                    admin_firstn LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'"; // Adjust as needed
                }
                $result = mysqli_query($conn, $sql);

                // Check if there are results
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['admin_id'] . "</td>";
                    echo "<td>" . $row['admin_lastn'] . " " . $row['admin_firstn'] . " " . $row['admin_mi'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "<td>
                            <button class='btn update-btn' onclick=\"updateRow(" . $row['ID'] . ", '" . addslashes($row['admin_id']) . "', '" . addslashes($row['admin_lastn']) . "', '" . addslashes($row['admin_firstn']) . "', '" . addslashes($row['admin_mi']) . "', '" . addslashes($row['email']) . "', '" . addslashes($row['password']) . "')\">Update</button>
                            <button class='btn remove-btn' onclick=\"removeRow(" . $row['ID'] . ")\">Remove</button>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        
        </div>
    <div>

    <div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update Admin Details</h2>
        <form id="updateForm" method="POST" action="update_admin.php">
            <input type="hidden" id="modal_id" name="id"> <!-- Hidden ID -->
            <input type="hidden" id="modal_admin_id" name="admin_id"> <!-- Hidden Admin ID -->
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="modal_last_name" name="admin_lastn" required><br>
            
            <label for="first_name">First Name:</label>
            <input type="text" id="modal_first_name" name="admin_firstn" required><br>
            
            <label for="middle_initial">Middle Initial:</label>
            <input type="text" id="modal_middle_initial" name="admin_mi"><br>
            
            <label for="email">Email:</label>
            <input type="email" id="modal_email" name="email" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="modal_password" name="password" required><br>
            
            <button type="submit">Update</button>
        </form>
    </div>
</div>

<!-- Add Admin Modal -->
<div id="addAdminModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Admin</h2>
        <form id="addAdminForm" method="POST" action="add_admin.php">
            <label for="admin_id">Admin ID:</label>
            <input type="text" id="admin_id" name="admin_id" required><br>

            <label for="admin_lastn">Last Name:</label>
            <input type="text" id="admin_lastn" name="admin_lastn" required><br>

            <label for="admin_firstn">First Name:</label>
            <input type="text" id="admin_firstn" name="admin_firstn" required><br>

            <label for="admin_mi">Middle Initial:</label>
            <input type="text" id="admin_mi" name="admin_mi"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Add Admin</button>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeDeleteModal">&times;</span>
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this admin?</p>
        <button id="confirmDeleteBtn">Yes, delete</button>
        <button id="cancelDeleteBtn">Cancel</button>
    </div>
</div>

<script>
var modal = document.getElementById('updateModal'); // Ensure this points to the correct modal ID
var span = document.getElementsByClassName('close')[0]; // Close button

// Function to open modal with pre-filled values
function updateRow(id, admin_id, last_name, first_name, middle_initial, email, password) {
    console.log('Opening modal...'); // Check if this logs to the console when you click update

    document.getElementById('modal_id').value = id;
    document.getElementById('modal_admin_id').value = admin_id;
    document.getElementById('modal_last_name').value = last_name;
    document.getElementById('modal_first_name').value = first_name;
    document.getElementById('modal_middle_initial').value = middle_initial;
    document.getElementById('modal_email').value = email;
    document.getElementById('modal_password').value = password;

    modal.style.display = 'block'; // Ensure this is executed correctly
}

// Close the modal when user clicks the "x"
span.onclick = function() {
    modal.style.display = 'none';
}

// Close the modal when user clicks outside of the modal content
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>


<script>
// Get modal and button elements for adding admin
var addModal = document.getElementById('addAdminModal');
var addBtn = document.getElementById('addAdminBtn');
var closeAddBtn = document.querySelector('#addAdminModal .close'); // Use a query selector to target the correct close button

// Open add admin modal when button is clicked
addBtn.onclick = function() {
    addModal.style.display = 'block';
}

// Close add admin modal when "x" is clicked
closeAddBtn.onclick = function() {
    addModal.style.display = 'none';
}

// Close update admin modal when "x" is clicked
closeUpdateBtn.onclick = function() {
    updateModal.style.display = 'none';
}

// Close modal when clicking outside of modal content
window.onclick = function(event) {
    if (event.target == addModal) {
        addModal.style.display = 'none';
    }
    if (event.target == updateModal) {
        updateModal.style.display = 'none';
    }
}
</script>

<script>
var deleteModal = document.getElementById('deleteModal');
var closeDeleteBtn = document.getElementById('closeDeleteModal');
var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
var deleteId = null; // Variable to hold the ID of the admin to delete

function removeRow(id) {
    deleteId = id; // Store the ID to delete
    deleteModal.style.display = 'block'; // Show the confirmation modal
}

// Close the delete modal when "x" is clicked
closeDeleteBtn.onclick = function() {
    deleteModal.style.display = 'none';
}

// Confirm deletion
confirmDeleteBtn.onclick = function() {
    var formData = new FormData();
    formData.append('delete_id', deleteId);

    fetch('remove_admin.php', { 
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        location.reload(); // Refresh the page to see the changes
    })
    .catch(error => console.error('Error:', error));
}

// Close modal when clicking outside of modal content
window.onclick = function(event) {
    if (event.target == deleteModal) {
        deleteModal.style.display = 'none';
    }
}
</script>

<script src="script.js">
</body>
</html>
