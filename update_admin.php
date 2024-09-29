<?php
// Include the database connection file
include 'include/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $id = $_POST['id'];
    $admin_lastn = mysqli_real_escape_string($conn, $_POST['admin_lastn']);
    $admin_firstn = mysqli_real_escape_string($conn, $_POST['admin_firstn']);
    $admin_mi = mysqli_real_escape_string($conn, $_POST['admin_mi']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Update the admin details in the database
    $sql = "UPDATE adminv 
        SET admin_lastn='$admin_lastn', admin_firstn='$admin_firstn', admin_mi='$admin_mi', email='$email', password='$password'
        WHERE ID='$id'";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: manage_admin.php');
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
