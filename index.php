<?php
session_start();
include 'includes/dbconfig.php';
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}
include 'includes/header.php';
?>

<h2 class="text-center mb-4">All Users</h2>
<a href="add.php" class="btn btn-success mb-3">Add New User</a>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Image</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $result = $conn->query("SELECT * FROM users");
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "
          <tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td><img src='uploads/{$row['image']}' width='60' height='60'></td>
            <td>
              <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
              <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
            </td>
          </tr>";
      }
    } else {
      echo "<tr><td colspan='5' class='text-center'>No data available</td></tr>";
    }
    ?>
  </tbody>
</table>

<?php include 'includes/footer.php'; ?>
