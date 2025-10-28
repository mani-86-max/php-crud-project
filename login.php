<?php
session_start();
include 'includes/dbconfig.php';
include 'includes/header.php';

if (isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $sql = $conn->prepare("SELECT * FROM users WHERE email=?");
  $sql->bind_param("s", $email);
  $sql->execute();
  $result = $sql->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user;
      header("Location: index.php");
      exit();
    } else {
      echo "<div class='alert alert-danger'>Incorrect password!</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>Email not found!</div>";
  }
}
?>

<h2 class="text-center mb-4">Login</h2>
<form method="POST" class="w-50 mx-auto">
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
  <p class="mt-3 text-center">Don’t have an account? <a href="signup.php">Sign up here</a></p>
</form>

<?php include 'includes/footer.php'; ?>


