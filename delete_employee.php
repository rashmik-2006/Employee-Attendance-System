<?php
include("db.php");
session_start();
if (!isset($_SESSION['id'])) 
{
  header("Location: login.php");
  exit();
}
if (isset($_GET['id']))
{
  $id = (int)$_GET['id'];
  $conn->query("UPDATE employees SET is_deleted = 1 WHERE id = $id");
}
header("Location: admin_home.php");
exit();
?>
