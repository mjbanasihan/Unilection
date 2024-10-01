<?php
// Include the database connection file
include 'include/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $id = $_POST['id'];
    $student_lastn = mysqli_real_escape_string($conn, $_POST['student_lastn']);
    $student_firstn = mysqli_real_escape_string($conn, $_POST['student_firstn']);
    $student_mi = mysqli_real_escape_string($conn, $_POST['student_mi']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $year_level = mysqli_real_escape_string($conn, $_POST['year_level']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Update the admin details in the database
    $sql = "UPDATE student 
        SET student_lastn='$student_lastn', student_firstn='$student_firstn', student_mi='$student_mi', course='$course', year_level='$year_level', section='$section', email='$email', password='$password'
        WHERE ID='$id'";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: manage_student.php');
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>