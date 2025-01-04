<?php
session_start();

// Database connection
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "admin";     

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['admin_id'] ?? ''; // Safely get admin_id
    $pass = $_POST['password'] ?? '';  // Safely get password

    // Validate input
    if (empty($user) || empty($pass)) {
        echo "Admin ID and Password cannot be empty.";
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM adminv WHERE admin_id = ? AND password = ?");
    if ($stmt === false) {
        die("Prepare statement failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $user, $pass);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if admin exists
    if ($result->num_rows > 0) {
        $adminv = $result->fetch_assoc();

        // Store necessary information in session variables
        $_SESSION['admin_id'] = $adminv['admin_id'];
        $_SESSION['admin_name'] = $adminv['admin_firstn'] . ' ' . $adminv['admin_lastn'];

        // Redirect to admin account
        header("Location: admin_account.php");
        exit();
    } else {
        echo "Invalid Admin ID or Password.";
    }
}

// Close connection
$conn->close();
?>
