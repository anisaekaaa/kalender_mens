<?php
require 'db.php';

$nama = $_POST['nama_lengkap'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah username sudah dipakai
$cek = $conn->prepare("SELECT id FROM users WHERE username = ?");
$cek->bind_param("s", $username);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    echo "Username sudah digunakan. Silakan pilih yang lain.";
    exit;
}

// Simpan user baru
$stmt = $conn->prepare("INSERT INTO users (nama_lengkap, email, username, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nama, $email, $username, $hashed);

if ($stmt->execute()) {
    header("Location: ../index.php");
    exit;
} else {
    echo "Gagal mendaftar: " . $conn->error;
}
?>