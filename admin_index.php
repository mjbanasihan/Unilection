<?php
session_start(); 

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_index.php"); // Redirect to login page if not logged in
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "admin");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch admin details
$query = "SELECT * FROM adminv WHERE admin_id = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Prepare statement failed: " . $conn->error);
}
$stmt->bind_param("s", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if admin exists
if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "Admin not found!";
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style(1).css">
    <title>Unilection</title>
</head>

<body>
    <div class="wrapper">
      <div class="login_box">
        <img src="lspu.png" alt="Styled image" class="my-image">
        <div class="LSPU">
          <span>Laguna State Polytechnic University
            <br>Los Baños Campus</span>
        </div>

        <hr class="custom-line">
        <div class="CCS">
            <span>COLLEGE OF
              <br>COMPUTER STUDIES</span>
          </div>
     <hr class="custom-line2">
     <div class="ELECTORAL">
        <span>ELECTORAL SYSTEM</span>
      </div>
        <hr class="custom-line3">
      
      <!-- Change the action attribute to login_verification.php -->
      <form action="admin_login_verification.php" method="POST">
        <div class="input_box1">
            <input type="text" name="admin_id" id="admin_id" class="input-field" placeholder="Admin ID" required aria-label="admin_id">
            <label for="pass" class="label"></label>
            <i class="bx bx-lock-alt icon"></i>
        </div>
          <div class="input_box2">
              <input type="password" name="password" id="pass" class="input-field" placeholder="Password" required aria-label="Password">
              <label for="pass" class="label"></label>
              <i class="bx bx-lock-alt icon"></i>
          </div>
              <input type="submit" class="input-submit" value="LOG IN">
          </div>
      </form>
    </div>
      <img src="CCS.png" class="ccspic">
</body>

</html>
