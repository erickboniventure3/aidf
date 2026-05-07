<?php
$servername = getenv('DB_HOST') ?: "127.0.0.1"; // Use TCP to avoid localhost socket/host resolution issues
$username = getenv('DB_USER') ?: "root"; // Default XAMPP username
$password = getenv('DB_PASS') ?: ""; // Default XAMPP password (empty)
$dbname = getenv('DB_NAME') ?: "aidf"; // Change to your local database name
$port = (int) (getenv('DB_PORT') ?: 3306); // Change if your MariaDB uses a different port (e.g., 3307)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed. Check host/user/password/port and MariaDB permissions. Details: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
// echo "Connected successfully";
?>
