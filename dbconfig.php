<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "login_signup";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Start session only if
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
