<?php
include 'include/db_connect_student.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $student_lastn = mysqli_real_escape_string($conn, $_POST['student_lastn']);
    $student_firstn = mysqli_real_escape_string($conn, $_POST['student_firstn']);
    $student_mi = mysqli_real_escape_string($conn, $_POST['student_mi']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $year_level = mysqli_real_escape_string($conn, $_POST['year_level']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Insert data into the database
    $sql = "INSERT INTO student (student_id, student_lastn, student_firstn, student_mi, course, year_level, section, email, password) 
            VALUES ('$student_id', '$last_name', '$first_name', '$middle_initial', '$course', '$year_level', '$section', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage_student.php"); // Redirect back to the admin page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>