
<?php
include 'dbconfig.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include 'includes/header.php';

// Get user ID from URL
$id = $_GET['id'];

// Fetch user details from database
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();

// When form is submitted
if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password']; 
  $old_image = $_POST['old_image'];

  // Handle image upload
  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);

    // Delete image  exists
    if (file_exists("uploads/" . $old_image)) {
      unlink("uploads/" . $old_image);
    }
  } else {
    $image = $old_image;
  }
  $sql = "UPDATE users SET name='$name', email='$email', password='$password', image='$image' WHERE id=$id"; // ✅ updated column name

  if ($conn->query($sql)) {
    echo "<script>alert('User updated successfully!'); window.location='index.php';</script>";
  } else {
    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
  }
}
?>

<h2 class="mb-4">Edit User</h2>

<form method="POST" enctype="multipart/form-data">
  <input type="hidden" name="old_image" value="<?= $user['image'] ?>">

  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" value="<?= $user['name'] ?>" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label> 
    <input type="password" name="password" value="<?= $user['password'] ?>" class="form-control" required> <!-- ✅ changed name & type -->
  </div>

  <div class="mb-3">
    <label class="form-label">Current Image</label><br>
    <img src="uploads/<?= $user['image'] ?>" width="100" height="100" class="mb-2"><br>
    <input type="file" name="image" class="form-control">
  </div>

  <button type="submit" name="update" class="btn btn-success">Update</button>
</form>

<?php include 'includes/footer.php'; ?>
