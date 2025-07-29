<?php
include("db.php");
?>
<!DOCTYPE html>
<html>
<head><h3>Admin Dashboard</h3>
<title>Inactive Employees</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body 
{
background: #f4f7fa;
font-family: Arial, sans-serif;
}
.container 
{
  margin-top: 50px;
  background: #fff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
h3 
{
  margin-bottom: 20px;
}
</style>
</head>
<body>
<div class="container">
<h3>Inactive Employees</h3>
<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Password</th>
</tr>
</thead>
<tbody>
<?php
$result = $conn->query("SELECT * FROM employees WHERE is_deleted = 1 ORDER BY id");
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
echo "<tr>
<td>{$row['id']}</td>
<td>{$row['name']}</td>
<td>{$row['email']}</td>
<td>{$row['password']}</td>
</tr>";
}
}
else 
{
  echo "<tr><td colspan='4' class='text-center text-muted'>No inactive employees found.</td></tr>";
}
?>
</tbody>
</table>
<a href="admin_home.php" class="btn btn-dark mt-3">Back to Dashboard</a>
</div>
</body>
</html>
