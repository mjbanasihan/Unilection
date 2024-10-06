<?php
// Include database connection
include 'include/db_position.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $position_id = $_POST['position_id'];
    $position_name = $_POST['position_name'];
    $max_vote = $_POST['max_vote'];

    // Prepare SQL update statement
    $sql = "UPDATE position SET position_name = :position_name, max_vote = :max_vote WHERE ID = :position_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':position_name', $position_name);
    $stmt->bindParam(':max_vote', $max_vote);
    $stmt->bindParam(':position_id', $position_id);

    if ($stmt->execute()) {
        // Redirect or show success message
        header("Location: position.php");
        exit;
    } else {
        echo "Error updating record.";
    }
}
?>
