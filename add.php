<?php
session_start()
include 'dbconfig.php';
// Ensure 
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include 'includes/header.php';

// Handl
if (isset($_POST['submit'])) {
  $name  = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password']; 

  // Image upload
  $image = time() . '_' . basename($_FILES['image']['name']);
  $tmp_name = $_FILES['image']['tmp_name'];
  $uploadDir = __DIR__ . '/uploads/';
  move_uploaded_file($tmp_name, $uploadDir . $image);

  // Insert data 
  $sql = "INSERT INTO users (name, email, password, image) VALUES ('$name', '$email', '$password', '$image')";
  if ($conn->query($sql)) {
    echo "<script>alert('User added successfully!'); window.location='index.php';</script>";
  } else {
    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
  }
}
?>

<h2 class="mb-4">Add New User</h2>

<form method="POST" enctype="multipart/form-data">
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
    <input type="password" name="password" class="form-control" required> <!-- ✅ Changed name & type -->
  </div>

  <div class="mb-3">
    <label class="form-label">Image</label>
    <input type="file" name="image" class="form-control" required>
  </div>

  <button type="submit" name="submit" class="btn btn-primary">Save</button>
</form>

<?php include 'includes/footer.php'; ?>

