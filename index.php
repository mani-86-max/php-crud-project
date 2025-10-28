<?php
include 'dbconfig.php';

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
      <th>Password</th> 
      <th>Image</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $result = $conn->query("SELECT * FROM users");

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "
          <tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['password']}</td> <!-- ✅ Display password instead of phone -->
            <td><img src='uploads/{$row['image']}' width='60' height='60'></td>
          </tr>";
      }
    } else {
      echo "<tr><td colspan='5' class='text-center'>No data available</td></tr>";
    }
    ?>
  </tbody>
</table>

<?php include 'includes/footer.php'; ?>
