<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - Cyclea</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body class="login-page">
  <div class="login-wrapper">
    <!-- KIRI -->
    <div class="login-left">
      <img src="img/icon_login.jpg" alt="Register Image">
      <h1>Gabung bersama<br><strong>Cyclea!</strong></h1>
    </div>

    <!-- KANAN -->
    <div class="login-right">
      <h2 style="color: #f06292;">Register</h2>
      <form action="proses/register.php" method="POST">
        <label for="nama_lengkap">Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Daftar</button>

        <p class="login-link">Sudah punya akun? <a href="index.php">Login!</a></p>
      </form>
    </div>
  </div>
</body>
</html>