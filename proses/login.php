<?php
session_start();
require 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama_lengkap'];
    header("Location: ../dashboard.php");
    exit;
  } else {
    echo "Password salah!";
  }
} else {
  echo "User tidak ditemukan!";
}
?>