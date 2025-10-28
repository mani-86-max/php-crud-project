<?php
include 'dbconfig.php';  
include 'includes/header.php';

if (isset($_POST['signup'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $image = "";

  // ✅ Upload image if selected
  if (!empty($_FILES['image']['name'])) {
    $image = time() . '_' . basename($_FILES['image']['name']); // unique file name
    $uploadDir = __DIR__ . '/uploads/';
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
  }

  // ✅ Check if email
  $check = $conn->query("SELECT * FROM users WHERE email='$email'");
  if ($check && $check->num_rows > 0) {
    echo "<div class='alert alert-danger'>Email already registered!</div>";
  } else {

    $sql = "INSERT INTO users (name, email, password, image) 
            VALUES ('$name', '$email', '$password', '$image')";

    if ($conn->query($sql)) {
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
