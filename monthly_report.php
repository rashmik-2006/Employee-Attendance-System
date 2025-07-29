<?php
include("db.php");
if (!isset($_SESSION['id'])) 
{
  header("Location: login.php");
  exit();
}
function getWorkingDays($month, $year) {
  $days = [];
  $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
  $today = date('Y-m-d');
for ($d = 1; $d <= $totalDays; $d++) 
{
  $date = date('Y-m-d', strtotime("$year-$month-$d"));
  if ($date > $today) break;
  $dayOfWeek = date('N', strtotime($date));
  if ($dayOfWeek < 6) 
  {
  $days[] = $date;
  }
  }
  return $days;
}
if (isset($_POST['download_csv'])) {
  $month = $_POST['month'];
  $year = $_POST['year'];
  $employee_id = $_POST['employee_id'];
  $emp = $conn->query("SELECT name FROM employees WHERE id = $employee_id")->fetch_assoc();
  $employee_name = $emp['name'];
  $month_name = date('F', mktime(0, 0, 0, $month, 1));
  $workingDays = [];
  $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
  $today = date('Y-m-d');
  for ($d = 1; $d <= $totalDays; $d++) 
  {
    $date = date('Y-m-d', strtotime("$year-$month-$d"));
    if ($date > $today) break;
    $dayOfWeek = date('N', strtotime($date));
    if ($dayOfWeek < 6) $workingDays[] = $date;
  $filename = str_replace(' ', '_', $employee_name) . "_{$month_name}_{$year}.csv";
  header('Content-Type: text/csv; charset=UTF-8');
  header("Content-Disposition: attachment; filename=\"$filename\"");
  $output = fopen("php://output", "w");
  fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
  fputcsv($output, ["Attendance Report for $employee_name - $month_name $year"]);
  fputcsv($output, []); 
  fputcsv($output, ['Date', 'Check-in Time', 'Check-out Time', 'Status']);
  foreach ($workingDays as $day) {
    $att = $conn->query("SELECT * FROM attendance WHERE employee_id = $employee_id AND date = '$day'");
    if ($att->num_rows > 0) 
    {
      $row = $att->fetch_assoc();
      fputcsv($output, ["\t" . $day, $row['check_in'] ?: '-', $row['check_out'] ?: '-', 'Present']);
    } 
    else 
    {
      fputcsv($output, ["\t" . $day, '-', '-', 'Absent']);
    }
  }
  fclose($output);
  exit;
}
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard | Monthly Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body 
    {
      background: linear-gradient(to right, #fdfbfb, #ebedee);
      padding: 30px;
      font-family: 'Segoe UI', sans-serif;
    }
    .container 
    {
      background: white;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 0 25px rgba(0,0,0,0.1);
    }
    .table thead 
    {
      background: #343a40;
      color: white;
    }
    h2 
    {
      font-weight: bold;
    }
    .alert-summary 
    {
      font-size: 18px;
      font-weight: bold;
      background: #e9ecef;
      padding: 15px;
      border-radius: 10px;
      margin-top: 20px;
    }
    .badge-success 
    {
      background: #28a745 !important;
    }
    .badge-danger 
    {
      background: #dc3545 !important;
    }
  </style>
</head>
<body>
<div class="container">
<h2>Admin Dashboard - Monthly Attendance Report</h2>
<form method="POST" class="row g-3 mb-4">
<div class="col-md-3">
<select name="month" class="form-select" required>
<option value="">-- Select Month --</option>
<?php for ($m = 1; $m <= 12; $m++): ?>
<option value="<?= $m ?>"><?= date('F', mktime(0, 0, 0, $m, 10)) ?></option>
<?php endfor; ?>
</select>
</div>
<div class="col-md-3">
<select name="year" class="form-select" required>
<option value="">-- Select Year --</option>
<?php for ($y = date('Y'); $y >= 2020; $y--): ?>
<option value="<?= $y ?>"><?= $y ?></option>
<?php endfor; ?>
</select>
</div>
<div class="col-md-3">
<select name="employee_id" class="form-select" required>
<option value="">-- Select Employee --</option>
<?php
$empList = $conn->query("SELECT id, name FROM employees WHERE is_deleted=0 ORDER BY name");
while ($emp = $empList->fetch_assoc())
{
echo "<option value='{$emp['id']}'>{$emp['name']}</option>";
}
?>
</select>
</div>
<div class="col-md-3 d-flex gap-2">
<button class="btn btn-primary w-100" name="generate">Generate Report</button>
<button class="btn btn-success w-100" name="download_csv">Download CSV</button>
</div>
</form>
<?php
if (isset($_POST['generate'])) 
{
  $month = $_POST['month'];
  $year = $_POST['year'];
  $employee_id = $_POST['employee_id'];
  $empData = $conn->query("SELECT * FROM employees WHERE id=$employee_id")->fetch_assoc();
  $workingDays = getWorkingDays($month, $year);
  echo "<h4>Report for: <b>{$empData['name']} - " . date('F Y', strtotime("$year-$month-01")) . "</b></h4>";
  echo "<table class='table table-bordered table-striped mt-3'>";
  echo "<thead><tr><th>Date</th><th>Check-in</th><th>Check-out</th><th>Status</th></tr></thead><tbody>";
  $totalPresent = 0;
  $totalAbsent = 0;
  foreach ($workingDays as $day) 
  {
    $att = $conn->query("SELECT * FROM attendance WHERE employee_id=$employee_id AND date='$day'");
    if ($att->num_rows > 0) 
    {
      $data = $att->fetch_assoc();
      echo "<tr>
              <td>$day</td>
              <td>{$data['check_in']}</td>
              <td>{$data['check_out']}</td>
              <td><span class='badge badge-success'>Present</span></td>
             </tr>";
             $totalPresent++;
    } 
    else 
    {
      echo "<tr>
              <td>$day</td>
              <td>-</td>
              <td>-</td>
              <td><span class='badge badge-danger'>Absent</span></td>
              </tr>";
              $totalAbsent++;
    }
  }
echo "</tbody></table>";
echo "<div class='alert-summary'>Total Presents: <b>$totalPresent</b> | Total Absents: <b>$totalAbsent</b></div>";
}
?>
<a href="admin_home.php" class="btn btn-dark mt-4">Back to Dashboard</a>
</div>
</body>
</html>