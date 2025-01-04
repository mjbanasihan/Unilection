<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "election";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if student_id is provided in the request
if (isset($_GET['student_id'])) {
    $student_id = $conn->real_escape_string($_GET['student_id']);

    // Fetch student details from the database
    $sql = "SELECT student_id, student_lastn, student_firstn, student_mi, image, gender, course, section, year_level, email 
            FROM student 
            WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Convert the image blob to a base64-encoded string
        if (!empty($student['image']) && file_exists($student['image'])) {
            $student['image'] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($student['image']));
        } else {
            // Fallback to a default image if no image is set or if file does not exist
            $student['image'] = 'images/default_image.jpg'; // Adjust path accordingly
        }


        // Return the student details as a JSON response
        echo json_encode($student);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}

$conn->close();
?>
