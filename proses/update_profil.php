<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit;
}

require 'db.php';

$user_id = $_SESSION['user_id'];
$nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

// Validasi input sederhana
if (empty($nama_lengkap) || empty($email)) {
  $_SESSION['error'] = "Nama lengkap dan email wajib diisi.";
  header("Location: ../pages/profil.php");
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['error'] = "Format email tidak valid.";
  header("Location: ../pages/profil.php");
  exit;
}

// Jika user isi password baru, cek konfirmasi
if ($password !== '') {
  if ($password !== $password_confirm) {
    $_SESSION['error'] = "Password dan konfirmasi password tidak sama.";
    header("Location: ../pages/profil.php");
    exit;
  }
  // Hash password baru
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("UPDATE users SET nama_lengkap = ?, email = ?, password = ? WHERE id = ?");
  $stmt->bind_param("sssi", $nama_lengkap, $email, $password_hash, $user_id);
} else {
  // Update tanpa ganti password
  $stmt = $conn->prepare("UPDATE users SET nama_lengkap = ?, email = ? WHERE id = ?");
  $stmt->bind_param("ssi", $nama_lengkap, $email, $user_id);
}

if ($stmt->execute()) {
  $_SESSION['success'] = "Profil berhasil diperbarui.";
} else {
  $_SESSION['error'] = "Terjadi kesalahan saat menyimpan data profil.";
}

$stmt->close();
header("Location: ../pages/profil.php");
exit;