<?php
session_start();
include 'includes/dbconfig.php';
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$id = (int)$_GET['id'];
$res = $conn->query("SELECT image FROM users WHERE id=$id");
$user = $res->fetch_assoc();

if ($user && file_exists("uploads/" . $user['image'])) {
  unlink("uploads/" . $user['image']);
}

$conn->query("DELETE FROM users WHERE id=$id");
header("Location: index.php");
exit();
?>
