
<?php
session_start();
include 'includes/dbconfig.php';
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();

if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $old_image = $_POST['old_image'];

  if (!empty($_FILES['image']['name'])) {
    $image = time() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    if (file_exists("uploads/" . $old_image)) unlink("uploads/" . $old_image);
  } else {
    $image = $old_image;
  }

  $sql = $conn->prepare("UPDATE users SET name=?, email=?, password=?, image=? WHERE id=?");
  $sql->bind_param("ssssi", $name, $email, $password, $image, $id);
  if ($sql->execute()) {
    header("Location: index.php");
  }
}

include 'includes/header.php';
?>

<h2 class="mb-4">Edit User</h2>
<form method="POST" enctype="multipart/form-data" class="w-50 mx-auto">
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
    <input type="password" name="password" value="<?= $user['password'] ?>" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Current Image</label><br>
    <img src="uploads/<?= $user['image'] ?>" width="100" height="100" class="mb-2"><br>
    <input type="file" name="image" class="form-control">
  </div>
  <button type="submit" name="update" class="btn btn-success">Update</button>
</form>

<?php include 'includes/footer.php'; ?>
