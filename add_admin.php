<?php
include 'include/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
    $last_name = mysqli_real_escape_string($conn, $_POST['admin_lastn']);
    $first_name = mysqli_real_escape_string($conn, $_POST['admin_firstn']);
    $middle_initial = mysqli_real_escape_string($conn, $_POST['admin_mi']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Insert data into the database
    $sql = "INSERT INTO adminv (admin_id, admin_lastn, admin_firstn, admin_mi, email, password) 
            VALUES ('$admin_id', '$last_name', '$first_name', '$middle_initial', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage_admin.php"); // Redirect back to the admin page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
