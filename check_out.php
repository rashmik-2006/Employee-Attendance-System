<?php
include("db.php");
session_start(); 
$eid = $_SESSION['id'];
$date = date('Y-m-d');
$time = date('H:i:s');
$start = strtotime('18:00:00'); 
$end = strtotime('18:30:00');   
$current = strtotime($time);
$exists = $conn->query("SELECT * FROM attendance WHERE employee_id=$eid AND date='$date'");
if ($exists->num_rows > 0) 
{
if ($current >= $start && $current <= $end) 
{
 $conn->query("UPDATE attendance SET check_out='$time' WHERE employee_id=$eid AND date='$date'");
$_SESSION['msg'] = "You have successfully checked out!";
$_SESSION['msg_type'] = "primary";
} 
else 
{
$_SESSION['msg'] = "Check-out allowed only between 6:00 PM to 6:30 PM.";
$_SESSION['msg_type'] = "danger";
}
} 
else 
{
  $_SESSION['msg'] = "You haven't checked in today.";
  $_SESSION['msg_type'] = "warning";
}
header("Location: employee_home.php");
?>
