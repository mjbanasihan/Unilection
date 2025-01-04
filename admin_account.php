<?php
session_start(); 

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_index.php"); // Redirect to login if not logged in
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "admin");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch admin details
$query = "SELECT * FROM adminv WHERE admin_id = ? AND password = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Prepare statement failed: " . $conn->error);
}

// Assuming $password is stored in session for validation; otherwise, modify accordingly
$password = $_SESSION['password'] ?? ''; // Use session variable or handle password retrieval

$stmt->bind_param("ss", $admin_id, $password); 
$stmt->execute();
$result = $stmt->get_result();

// Check if admin exists
if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "Admin not found!";
    exit();
}

// Close connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>ADMIN</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="create_ballot.css">
    <style>
        .profile-card {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 1000px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-image: url('ccslong.png'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
        }

        .profile-image img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-info h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
        }

        .logout-btn-container {
            display: flex;
            justify-content: flex-end; 
            width: 100%; 
            margin-top: 20px;
            padding-right: 460px; 
        }

        .logout-btn {
            width: 150px; 
            padding: 10px;
            text-align: center;
            background-color: #ff4d4d;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #e60000;
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
        <a href="admin_account.php">Check Account</a>
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
            <li><a href="admin.php">Home</a></li>  
            <li><a href="ballot">Ballots</a></li>
            <li><a href="results">Results</a></li>
            <li><a href="status">Year Status</a></li>
            <li><a href="#">Students</a></li>
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

    <div class="profile-card">
        <div class="profile-image">
            <?php
            // Display the profile image if available
            if ($admin['image']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($admin['image']) . '" alt="Profile Image">';
            } else {
                echo '<img src="default-profile.jpg" alt="Default Profile Image">';
            }
            ?>
        </div>
        <div class="profile-info">
            <h2><?php echo $admin['admin_firstn'] . ' ' . $admin['admin_lastn']; ?></h2>
            <p><strong>Admin ID:</strong> <?php echo $admin['admin_id']; ?></p>
            <p><strong>Email:</strong> <?php echo $admin['email']; ?></p>
        </div>
    </div>

    <!-- Log Out Button Container -->
    <div class="logout-btn-container">
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>

    <script> 
        const adminIcon = document.querySelector('.admin-icon'); 
        const dropdownMenu = document.querySelector('.dropdown-menu'); 

        // Toggle dropdown visibility when admin icon is clicked
        adminIcon.onclick = function () {
            if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
                dropdownMenu.style.display = 'block'; 
            } else {
                dropdownMenu.style.display = 'none'; 
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
