<?php
// hash_passwords.php — ONE TIME USE. Backup DB before running!
// Update DB credentials below to match your environment.
$host = 'localhost';
$dbname = 'php';   // <-- change
$user = 'root';                   // <-- change if needed
$pass = 'Rohit@123';                       // <-- change if needed
$charset = 'utf8mb4';

$mysqli = new mysqli($host, $user, $pass, $dbname);
if ($mysqli->connect_error) {
    die("DB connect error: " . $mysqli->connect_error);
}

$sql = "SELECT u_id, email, password FROM users";
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $u_id = (int)$row['u_id'];
        $email = $row['email'];
        $pwd = $row['password'];

        // Skip if already hashed (common bcrypt prefix is $2y$)
        if (strpos($pwd, '$2y$') === 0 || strpos($pwd, '$2b$') === 0) {
            echo "Skipped (already hashed): $email\n";
            continue;
        }

        // Create secure hash
        $newHash = password_hash($pwd, PASSWORD_DEFAULT);

        // Update DB
        $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE u_id = ?");
        $stmt->bind_param('si', $newHash, $u_id);
        if ($stmt->execute()) {
            echo "Updated: $email\n";
        } else {
            echo "Failed to update $email: " . $stmt->error . "\n";
        }
        $stmt->close();
    }
    $result->free();
} else {
    echo "Query error: " . $mysqli->error;
}

$mysqli->close();
echo "\nDone. Delete this file after use.\n";
