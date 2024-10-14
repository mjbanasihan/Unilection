<?php
// Database connection variables
$host = 'localhost'; // Replace with your database host
$dbname = 'election'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    // Establish the database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL to create tables
    $sql = "
    -- Create the ballots table
    CREATE TABLE IF NOT EXISTS ballots (
        ballot_id INT PRIMARY KEY AUTO_INCREMENT,
        ballot_title VARCHAR(255) NOT NULL,
        status ENUM('draft', 'published') DEFAULT 'draft',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

    -- Create the ballot_positions table
    CREATE TABLE IF NOT EXISTS ballot_positions (
        position_id INT PRIMARY KEY AUTO_INCREMENT,
        ballot_id INT,
        position_name VARCHAR(255) NOT NULL,
        max_vote INT NOT NULL,
        FOREIGN KEY (ballot_id) REFERENCES ballots(ballot_id) ON DELETE CASCADE
    );

    -- Create the ballot_candidates table
    CREATE TABLE IF NOT EXISTS ballot_candidates (
        candidate_id INT PRIMARY KEY AUTO_INCREMENT,
        position_id INT,
        candidate_name VARCHAR(255) NOT NULL,
        candidate_partylist VARCHAR(255),
        FOREIGN KEY (position_id) REFERENCES ballot_positions(position_id) ON DELETE CASCADE
    );

    -- Create the ballot_votes table (optional)
    CREATE TABLE IF NOT EXISTS ballot_votes (
        vote_id INT PRIMARY KEY AUTO_INCREMENT,
        ballot_id INT,
        candidate_id INT,
        voter_id INT,
        FOREIGN KEY (ballot_id) REFERENCES ballots(ballot_id) ON DELETE CASCADE,
        FOREIGN KEY (candidate_id) REFERENCES ballot_candidates(candidate_id) ON DELETE CASCADE
    );

    -- Create indexes for better performance (optional)
    CREATE INDEX IF NOT EXISTS idx_ballot_id ON ballot_positions(ballot_id);
    CREATE INDEX IF NOT EXISTS idx_position_id ON ballot_candidates(position_id);
    CREATE INDEX IF NOT EXISTS idx_ballot_candidate ON ballot_votes(ballot_id, candidate_id);
    ";

    // Execute the SQL script
    $pdo->exec($sql);
    echo "Tables created successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>
