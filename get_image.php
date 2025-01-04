<?php
include 'include/db_election.php';

// Check if an ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to retrieve the image for the given ID
    $sql = "SELECT image FROM student WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $image);
    mysqli_stmt_fetch($stmt);

    // Check if the image exists
    if ($image) {
        // Set headers for image output
        header("Content-Type: image/jpeg"); // or image/png if it's PNG
        echo $image; // Output the image data
    } else {
        echo 'Image not found';
    }

    mysqli_stmt_close($stmt);
} else {
    echo 'No image ID specified';
}

mysqli_close($conn);
?>
