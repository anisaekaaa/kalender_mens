<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Cyclea</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body class="login-page">
  <div class="login-wrapper">
    <!-- KIRI -->
    <div class="login-left">
      <img src="img/icon_login.jpg" alt="Login Image">
      <h1>Welcome in Cyclea!</h1>
    </div>

    <!-- KANAN -->
    <div class="login-right">
      <h2>Login</h2>
      <form action="proses/login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <div class="remember">
          <input type="checkbox" name="remember" id="remember">
          <label for="remember">Remember me</label>
        </div>

        <button type="submit">Login</button>

        <p><a href="forgot_password.php">Forgot password?</a></p>
        <p>Belum punya akun? <a href="register.php">Daftar!</a></p>
      </form>
    </div>
  </div>
</body>
</html>