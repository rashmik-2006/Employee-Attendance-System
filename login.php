<?php
include("db.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



$role = $_GET['role'] ?? '';
if (!in_array($role, ['admin', 'employee'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    
    $stmt = $conn->prepare("SELECT * FROM employees WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $user = $res->fetch_assoc();

    
        if (password_verify($password, $user['password'])) {


            if ($role == 'employee' && $user['email'] == 'admin@company.com') {
                echo "<script>alert('Admin cannot login here. Use Admin Login.');window.location.href='index.php';</script>";
                exit;
            }

            if ($role == 'admin' && $user['email'] != 'admin@company.com') {
                echo "<script>alert('Only admin allowed here. Use Employee Login.');window.location.href='index.php';</script>";
                exit;
            }

            // Step 4: Set session and redirect
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];

            header("Location: " . ($role == 'admin' ? 'admin_home.php' : 'employee_home.php'));
            exit;
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('Email not registered');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?= ucfirst($role) ?> Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body
  {
  background: url('https://wallpaperaccess.com/full/317501.jpg') no-repeat center center fixed;
  background-size: cover;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  }
.glass-box 
{
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  padding: 30px;
  color: white;
  width: 100%;
  max-width: 400px;
  backdrop-filter: blur(8px);
}
</style>
</head>
<body>
<div class="glass-box">
<h3 class="text-center mb-4"><?= ucfirst($role) ?> Login</h3>
<form method="POST">
<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
<button type="submit" name="login" class="btn btn-light w-100">Login</button>
</form>
</div>
</body>
</html>
