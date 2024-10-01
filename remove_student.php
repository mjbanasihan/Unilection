<?php
// Include the database connection file
include 'include/db_connect_student.php';

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle deletion request
if (isset($_POST['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
    $delete_sql = "DELETE FROM student WHERE ID='$delete_id'"; // Change 'adminv' to your actual table name
    if (mysqli_query($conn, $delete_sql)) {
        echo "Admin deleted successfully";
    } else {
        echo "Error deleting admin: " . mysqli_error($conn);
    }
    exit; // Prevent further execution of the script
}

// Fetch admin data from the database
$sql = "SELECT * FROM student"; // Change 'adminv' to your actual admin table name if necessary
$result = mysqli_query($conn, $sql);
?>