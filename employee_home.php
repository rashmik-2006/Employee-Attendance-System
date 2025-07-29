<?php include("db.php");
if (!isset($_SESSION['id'])) 
{
header("Location: login.php");
exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Employee Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body 
{
margin: 0;
padding: 0;
background: linear-gradient(135deg, #667eea, #764ba2);
height: 100vh;
display: flex;
justify-content: center;
align-items: center;
font-family: 'Segoe UI', sans-serif;
}
.card-box 
{
background: rgba(255, 255, 255, 0.1);
backdrop-filter: blur(10px);
border-radius: 15px;
padding: 40px;
width: 100%;
 max-width: 500px;
box-shadow: 0 0 25px rgba(0, 0, 0, 0.25);
color: white;
text-align: center;
}
h3 
{
margin-bottom: 30px;
font-weight: bold;
}
.btn 
{
margin-bottom: 15px;
font-size: 18px;
font-weight: bold;
 border-radius: 10px;
transition: all 0.2s ease-in-out;
}
.btn:hover 
{
transform: scale(1.03);
box-shadow: 0 0 12px rgba(255, 255, 255, 0.4);
}
</style>
</head>
<body>
<div class="card-box">
<h3>Hello, <?= $_SESSION['name'] ?></h3>
<?php if (isset($_SESSION['msg'])): ?>
<div class="alert alert-<?= $_SESSION['msg_type']; ?> text-start" role="alert">
 <?= $_SESSION['msg']; ?>
</div>
<?php unset($_SESSION['msg']); unset($_SESSION['msg_type']); ?>
<?php endif; ?>
<form method="POST" action="check_in.php">
<button class="btn btn-success w-100">Check In</button>
 </form>
<form method="POST" action="check_out.php">
<button class="btn btn-danger w-100">Check Out</button>
</form>
<a href="logout.php" class="btn btn-secondary w-100">Logout</a>
</div>
</body>
</html>
