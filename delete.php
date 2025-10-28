<?php
include 'dbconfig.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Get user ID from the URL
$id = $_GET['id'];

// user image
$result = $conn->query("SELECT image FROM users WHERE id = $id");
$user = $result->fetch_assoc();

// Delete the image 
if ($user && file_exists("uploads/" . $user['image'])) {
  unlink("uploads/" . $user['image']);
}

// Delete the user record 
$conn->query("DELETE FROM users WHERE id = $id");

// Redirect 
header("Location: index.php");
exit();
?>
