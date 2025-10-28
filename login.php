<?php
session_start();
 require_once include 'dbconfig.php';
include 'includes/header.php';

// Handle login form submission
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // ✅ Fetch user from the correct table
  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // ✅ If passwords are hashed
    if (password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user;
      echo "<script>alert('Login Successful!'); window.location='index.php';</script>";
    }
    // ✅ If passwords plan text
    elseif ($password === $user['password']) {
      $_SESSION['user'] = $user;
      echo "<script>alert('Login Successful!'); window.location='index.php';</script>";
    }
    else {
      echo "<div class='alert alert-danger'>Incorrect password!</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>Email not found!</div>";
  }
}
?>

<h2 class="mb-4">Login</h2>

<form method="POST">
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>

  <button type="submit" name="login" class="btn btn-primary">Login</button>
  <p class="mt-3">Don’t have an account? <a href="signup.php">Sign up here</a></p>
</form>

<?php include 'includes/footer.php'; ?>

