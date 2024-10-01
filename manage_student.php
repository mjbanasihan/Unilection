<?php
// Include the database connection file
include 'include/db_connect_student.php';

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = isset($_GET['search']) ? $_GET['search'] : '';


$sql = "SELECT * FROM student"; // Change 'adminv' to your actual admin table name if necessary
if (!empty($search)) {
    // Sanitize input and add WHERE clause for search
    $sql .= " WHERE ID LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                    student_id LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                    student_lastn LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                    student_firstn LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                    course LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                    year_level LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                    section LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";

}
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
    <link rel="stylesheet" href="manage_student.css">
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
            <li><a href="ballot">Ballots</a></li>
            <li><a href="results">Results</a></li>
            <li><a href="status">Year Status</a></li>
            <li><a href="#">Students</a></li>
        </ul>
        <ul>
            <li class="hideOnMobile"><a href="admin.html">Home</a></li>
            <li class="hideOnMobile"><a href="ballot">Ballots</a></li>
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

    <div class="student-data">
        <h2>Student Table</h2>
        <div class="student-bar">
            <form action="manage_student.php" method="GET" style="display: flex; align-items: center;">
                <select name="search_option" required>
                    <option value="">Select Search Option</option>
                    <option value="student_id">Student ID</option>
                    <option value="student_name">Student Name</option>
                    <option value="course">Course</option>
                </select>
                <input type="text" name="search" placeholder="Enter Search Term..." required>
                <button type="submit" class="search-btn">Search</button>
            </form>
            <div class="add-student">
                <button id="addStudBtn" class="add-stud-btn">Add Student</button>
            </div>
        </div>
    </div>
        
    <div>
        </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Section</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Actions</th> <!-- Added header for Password -->
                </tr>
                <?php
                // Check if a search query is set
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $search_option = isset($_GET['search_option']) ? $_GET['search_option'] : '';

                $sql = "SELECT * FROM student"; // Change 'student' to your actual student table name if necessary

                if (!empty($search) && !empty($search_option)) {
                    // Sanitize input and modify the WHERE clause based on the selected search option
                    if ($search_option == 'student_id') {
                        $sql .= " WHERE student_id LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
                    } elseif ($search_option == 'student_name') {
                        $sql .= " WHERE student_lastn LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                                        student_firstn LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
                    } elseif ($search_option == 'course') {
                        $sql .= " WHERE course LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
                    }
                }
                $result = mysqli_query($conn, $sql);

                // Check if there are results
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['student_id'] . "</td>";
                    echo "<td>" . $row['student_lastn'] . " " . $row['student_firstn'] . " " . $row['student_mi'] . "</td>";
                    echo "<td>" . $row['course'] . "</td>";
                    echo "<td>" . $row['year_level'] . "</td>";
                    echo "<td>" . $row['section'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "<td>
                            <button class='btn update-btn' onclick=\"updateRow(" . $row['ID'] . ", '" . addslashes($row['student_id']) . "', '" . addslashes($row['student_lastn']) . "', '" . addslashes($row['student_firstn']) . "', '" . addslashes($row['student_mi']) . "', '" . addslashes($row['course']) . "','" . addslashes($row['year_level']) . "','" . addslashes($row['section']) . "','" . addslashes($row['email']) . "', '" . addslashes($row['password']) . "')\">Update</button>
                            <button class='btn remove-btn' onclick=\"removeRow(" . $row['ID'] . ")\">Remove</button>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        
        </div>
    <div>

    <div id="updatestudModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Student Details</h2>
            <form id="updateForm" method="POST" action="update_student.php">
                <input type="hidden" id="modal_s_id" name="id"> <!-- Hidden ID -->
                <input type="hidden" id="modal_student_id" name="student_id"> <!-- Hidden Admin ID -->
                
                <label for="last_name">Last Name:</label>
                <input type="text" id="modal_student_last_name" name="student_lastn" required><br>
                
                <label for="first_name">First Name:</label>
                <input type="text" id="modal_student_first_name" name="student_firstn" required><br>
                
                <label for="middle_initial">Middle Initial:</label>
                <input type="text" id="modal_student_middle_initial" name="student_mi"><br>

                <label for="course">Course:</label>
                <input type="text" id="modal_student_course" name="course"><br>

                <label for="year_level">Year Level:</label>
                <input type="text" id="modal_student_year_level" name="year_level"><br>

                <label for="section">Section:</label>
                <input type="text" id="modal_student_section" name="section"><br>
                
                <label for="email">Email:</label>
                <input type="email" id="modal_student_email" name="email" required><br>
                
                <label for="password">Password:</label>
                <input type="password" id="modal_student_password" name="password" required><br>
                
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

<!-- Add Admin Modal -->
    <div id="addStudentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Student</h2>
        <form id="addStudentForm" method="POST" action="add_student.php">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required><br>

            <label for="student_lastn">Last Name:</label>
            <input type="text" id="student_lastn" name="student_lastn" required><br>

            <label for="student_firstn">First Name:</label>
            <input type="text" id="student_firstn" name="student_firstn" required><br>

            <label for="student_mi">Middle Initial:</label>
            <input type="text" id="student_mi" name="student_mi"><br>

            <label for="course">Middle Initial:</label>
            <input type="text" id="course" name="course"><br>

            <label for="year_level">Middle Initial:</label>
            <input type="text" id="year_level" name="year_leveli"><br>

            <label for="sectioni">Middle Initial:</label>
            <input type="text" id="section" name="section"><br>

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

    <script> //UPDATE MODAL
    var modal = document.getElementById('updatestudModal'); // Ensure this points to the correct modal ID
    var span = document.getElementsByClassName('close')[0]; // Close button

    // Function to open modal with pre-filled values
    function updateRow(id, student_id, last_name, first_name, middle_initial, course, year_level, section, email, password) {
        console.log('Opening modal...'); // Check if this logs to the console when you click update

        document.getElementById('modal_s_id').value = id;
        document.getElementById('modal_student_id').value = student_id;
        document.getElementById('modal_student_last_name').value = last_name;
        document.getElementById('modal_student_first_name').value = first_name;
        document.getElementById('modal_student_middle_initial').value = middle_initial;
        document.getElementById('modal_student_course').value = course;
        document.getElementById('modal_student_year_level').value = year_level;
        document.getElementById('modal_student_section').value = section;
        document.getElementById('modal_student_email').value = email;
        document.getElementById('modal_student_password').value = password;

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
    var addModal = document.getElementById('addStudentModal');
    var addBtn = document.getElementById('addStudBtn');
    var closeAddBtn = document.querySelector('#addStudentModal .close'); // Use a query selector to target the correct close button

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

    <script>//REMOVE MODAL
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

        fetch('remove_student.php', { 
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
