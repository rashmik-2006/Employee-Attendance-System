<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Welcome</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body 
{
margin: 0;
padding: 0;
background: linear-gradient(to right, #051937, #004d7a, #008793, #00bf72, #a8eb12);
height: 100vh;
display: flex;
justify-content: center;
align-items: center;
color: white;
font-family: 'Segoe UI', sans-serif;
 }
.box 
{
  background: rgba(0, 0, 0, 0.6);
  padding: 50px;
  border-radius: 20px;
  text-align: center;
  box-shadow: 0 0 30px rgba(0,0,0,0.5);
}
.btn-custom 
{
  margin: 10px;
  width: 200px;
  font-size: 18px;
}
</style>
</head>
<body>
<div class="box">
<h1>Employee Attendance System</h1>
<a href="login.php?role=employee" class="btn btn-primary">Employee Login</a>
<a href="login.php?role=admin" class="btn btn-success">Admin Login</a>
</div>
</body>
</html>
