<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

require 'db.php';

$user_id = $_SESSION['user_id'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$durasi = $_POST['durasi'];
$catatan = $_POST['catatan'];

$query = $conn->prepare("INSERT INTO siklus (user_id, tanggal_mulai, durasi, catatan) VALUES (?, ?, ?, ?)");
$query->bind_param("isis", $user_id, $tanggal_mulai, $durasi, $catatan);

if ($query->execute()) {
    header("Location: ../pages/siklus.php");
} else {
    echo "Gagal menyimpan data: " . $conn->error;
}
?>