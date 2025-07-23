<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user_id'];
  $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
  $mood = $_POST['mood'] ?? '';
  $nyeri = $_POST['nyeri'] ?? '';
  $energi = $_POST['energi'] ?? '';
  $catatan = $_POST['catatan'] ?? '';

  if (empty($tanggal) || empty($mood) || empty($nyeri) || empty($energi)) {
    $_SESSION['error'] = "Semua data wajib diisi!";
    header("Location: ../pages/gejala.php");
    exit;
  }

  $stmt = $conn->prepare("INSERT INTO gejala_harian (user_id, tanggal, mood, nyeri, energi, catatan) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("isssss", $user_id, $tanggal, $mood, $nyeri, $energi, $catatan);

  if ($stmt->execute()) {
    $_SESSION['success'] = "Gejala berhasil disimpan.";
  } else {
    $_SESSION['error'] = "Gagal menyimpan data gejala.";
  }

  $stmt->close();
  $conn->close();

  header("Location: ../pages/gejala.php");
  exit;
} else {
  header("Location: ../pages/gejala.php");
  exit;
}