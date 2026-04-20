<?php
$servername = "127.0.0.1"; // Use TCP to avoid localhost socket/host resolution issues
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (empty)
$dbname = "aidf"; // Change to your local database name
$port = 3306; // Change if your MariaDB uses a different port (e.g., 3307)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed. Check host/user/password/port and MariaDB permissions. Details: " . $conn->connect_error);
}
// echo "Connected successfully";
?>
