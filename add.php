<?php
session_start();
require_once __DIR__ . '/includes/dbconfig.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/uploads/" . $image);
    }

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $image);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error adding user</div>";
    }
}
include 'includes/header.php';
?>

<h2 class="mb-4">Add New User</h2>
<form method="POST" enctype="multipart/form-data" class="w-50 mx-auto">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Image</label>
    <input type="file" name="image" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
</form>

<?php include 'includes/footer.php'; ?>



