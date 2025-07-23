<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  header("Location: /kalender_mens/index.php");
  exit;
}

$username = $_SESSION['username'] ?? 'User';
$nama_lengkap = $_SESSION['nama_lengkap'] ?? 'Pengguna';
$inisial = strtoupper(substr($nama_lengkap, 0, 1));
$base_url = '/kalender_mens'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cyclea</title>
  <link rel="stylesheet" href="<?= $base_url ?>/css/style.css">
</head>
<body>
  <header>
    <div class="logo">CYCLEA</div>
    <nav>
      <a href="<?= $base_url ?>/dashboard.php">Beranda</a>
      <a href="<?= $base_url ?>/pages/siklus.php">Siklus</a>
      <a href="<?= $base_url ?>/pages/gejala.php">Gejala</a>
      <a href="<?= $base_url ?>/pages/kalender.php">Kalender</a>
      <a href="<?= $base_url ?>/pages/artikel.php">Artikel</a>
    </nav>
    <div class="user-info">
      <div class="dropdown">
        <button class="dropbtn"><?= htmlspecialchars($nama_lengkap) ?> (<?= $inisial ?>) ⌄</button>
        <div class="dropdown-content">
          <a href="<?= $base_url ?>/pages/profil.php">Profil</a>
          <a href="<?= $base_url ?>/proses/logout.php">Logout</a>
        </div>
      </div>
    </div>
  </header>