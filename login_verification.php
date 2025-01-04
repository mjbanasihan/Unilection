<?php
session_start(); // Start the session

// Database connection
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "election";     

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['student_id']; // Get the student_id from the form
    $pass = $_POST['password'];  // Get the password from the form

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM student WHERE student_id = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a student was found
    if ($result->num_rows > 0) {
        // User exists and credentials are correct
        $student = $result->fetch_assoc();
    
        // Store necessary information in session variables
        $_SESSION['voters_id'] = $student['student_id']; // This will be used for voting
        $_SESSION['student_name'] = $student['student_firstn'] . ' ' . $student['student_lastn'];
    
        // Debugging: Check session values
        echo "Session voters_id: " . $_SESSION['voters_id']; 
        echo "Session student_name: " . $_SESSION['student_name'];
    
        // Redirect to the student home page
        header("Location: student_home.php");
        exit();
    }
    
}

// Close connection
$conn->close();
?>
