<?php include("db.php");
if (!isset($_SESSION['id']))
{
header("Location: login.php");
exit();
}
$filter = false;
?>
<!DOCTYPE html>
<html>
<head><h3>Admin Dashboard</h3>
<title>Filter Attendance</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2>Filter Attendance</h2>
<form method="POST" class="row g-3 mb-4">
<div class="col-md-4">
<select name="employee_id" class="form-select" required>
<option value="">-- Select Employee --</option>
<?php
$emp = $conn->query("SELECT id, name FROM employees WHERE is_deleted = 0 ORDER BY name");
while ($e = $emp->fetch_assoc()) 
{
echo "<option value='{$e['id']}'>{$e['name']}</option>";
}
?>
</select>
</div>
<div class="col-md-3">
<input type="date" name="from" class="form-control" required>
</div>
<div class="col-md-3">
<input type="date" name="to" class="form-control" required>
</div>
<div class="col-md-2">
<button name="filter" class="btn btn-primary w-100">Search</button>
</div>
</form>
<?php
if (isset($_POST['filter']))
{
$filter = true;
$eid = $_POST['employee_id'];
$from = $_POST['from'];
$to = $_POST['to'];
$query = "SELECT attendance.id, employees.name, attendance.date, attendance.check_in, attendance.check_out 
          FROM attendance 
          JOIN employees ON attendance.employee_id = employees.id 
          WHERE attendance.employee_id=$eid 
          AND date BETWEEN '$from' AND '$to'";
  $result = $conn->query($query);
  echo "<table class='table table-bordered'>
        <thead>
        <tr><th>ID</th><th>Name</th><th>Date</th><th>Check-in</th><th>Check-out</th></tr>
        </thead><tbody>";
while ($row = $result->fetch_assoc())
{
  echo "<tr>
      <td>{$row['id']}</td>
      <td>{$row['name']}</td>
      <td>{$row['date']}</td>
      <td>{$row['check_in']}</td>
      <td>{$row['check_out']}</td>
    </tr>";
}
echo "</tbody></table>";
}
?>
<a href="admin_home.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
