<?php
include("db.php");
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM employees WHERE id = $id")->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$pass = trim($_POST['password']);
if ($name && $email && $pass)
{
  $stmt = $conn->prepare("UPDATE employees SET name = ?, email = ?, password = ? WHERE id = ?");
  $stmt->bind_param("sssi", $name, $email, $pass, $id);
  $stmt->execute();
  echo "<script>
  alert('Employee updated successfully!');
  window.location.href = 'admin_home.php';
  </script>";
  exit;
} 
else
{
echo "<script>alert('All fields are required.');</script>";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Employee | Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h3>Edit Employee</h3>
<form method="POST" onsubmit="return validateEdit();">
<input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" class="form-control mb-2" required>
<input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" class="form-control mb-2" required>
<input type="text" name="password" value="<?= htmlspecialchars($data['password']) ?>" class="form-control mb-2" required>
<button class="btn btn-primary">Update</button>
</form>
</div>
<script>
function validateEdit()
 {
let form = document.forms[0];
if (!form.name.value.trim() || !form.email.value.trim() || !form.password.value.trim()) 
{
alert("No field should be empty!");
return false;
}
return true;
}
</script>
</body>
</html>
