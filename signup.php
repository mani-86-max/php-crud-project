<?php
session_start();
include 'includes/dbconfig.php';
include 'includes/header.php';

if (isset($_POST['signup'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $image = "";

  // Upload image if selected
  if (!empty($_FILES['image']['name'])) {
    $image = time() . '_' . basename($_FILES['image']['name']);
    $uploadDir = __DIR__ . '/uploads/';
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
  }

  $check = $conn->prepare("SELECT id FROM users WHERE email=?");
  $check->bind_param("s", $email);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    echo "<div class='alert alert-danger'>Email already registered!</div>";
  } else {
    $sql = $conn->prepare("INSERT INTO users (name, email, password, image) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $name, $email, $password, $image);
    if ($sql->execute()) {
      echo "<script>alert('Signup Successful! You can now login.'); window.location='login.php';</script>";
    } else {
      echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
  }
}
?>

<h2 class="text-center mb-4">Sign Up</h2>
<form method="POST" enctype="multipart/form-data" class="w-50 mx-auto">
  <div class="mb-3">
    <label class="form-label">Full Name</label>
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
    <label class="form-label">Profile Image</label>
    <input type="file" name="image" class="form-control">
  </div>
  <button type="submit" name="signup" class="btn btn-primary w-100">Sign Up</button>
  <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
</form>

<?php include 'includes/footer.php'; ?>
