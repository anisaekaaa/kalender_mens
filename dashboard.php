<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit;
}

require 'proses/db.php'; // koneksi database

$user_id = $_SESSION['user_id'];
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Pengguna';

// Fungsi untuk format tanggal ke bahasa Indonesia
function tgl_indo($tanggal) {
  $bulan = [
    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];
  $tgl = date('j', strtotime($tanggal));
  $bln = $bulan[(int)date('m', strtotime($tanggal))];
  $thn = date('Y', strtotime($tanggal));
  return "$tgl $bln $thn";
}

// Tanggal hari ini dalam format bahasa Indonesia
setlocale(LC_TIME, 'id_ID.utf8');
$hari_ini = strftime('%A, %e %B %Y');
$hari_ini = ucfirst(trim($hari_ini));

// Ambil siklus terakhir user
$stmt = $conn->prepare("SELECT tanggal_mulai, durasi FROM siklus WHERE user_id = ? ORDER BY tanggal_mulai DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$last_siklus = $result->fetch_assoc();
$stmt->close();

$prediksi_hari_haid = '-';
$masa_subur = '-';
$peluang_kehamilan = '-';

if ($last_siklus) {
  $tanggal_mulai = $last_siklus['tanggal_mulai'];
  $durasi = $last_siklus['durasi'];

  // Asumsi siklus rata-rata 28 hari
  $prediksi_haid = date('Y-m-d', strtotime($tanggal_mulai . ' + 28 days'));
  $prediksi_hari_haid = tgl_indo($prediksi_haid);

  // Masa subur: 2 hari sebelum ovulasi s.d. 2 hari setelah ovulasi (ovulasi hari ke-14)
  $ovulasi = date('Y-m-d', strtotime($tanggal_mulai . ' + 14 days'));
  $masa_subur_awal = date('Y-m-d', strtotime($ovulasi . ' - 2 days'));
  $masa_subur_akhir = date('Y-m-d', strtotime($ovulasi . ' + 2 days'));
  $masa_subur = tgl_indo($masa_subur_awal) . ' - ' . tgl_indo($masa_subur_akhir);

  $peluang_kehamilan = 'Tinggi selama ' . $masa_subur;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Cyclea</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container center - dashboard">
  <h1>Hai, <?= htmlspecialchars($nama) ?>! 👋</h1>
  <p class="quote">"Tubuhmu adalah rumahmu, rawat dia dengan cinta 🌷"</p>
  <p class="tanggal">📅 <?= $hari_ini ?></p>

  <?php if (!$last_siklus): ?>
    <div class="error">
      Belum ada data siklus. Yuk mulai catat siklus menstruasimu <a href="pages/siklus.php">di sini</a>!
    </div>
  <?php endif; ?>

  <div class="ringkasan">
    <h2>📍 Ringkasan Siklus Kamu</h2>
    <ul>
      <li>🩸 Siklus terakhir: <?= $last_siklus ? tgl_indo($last_siklus['tanggal_mulai']) : '-' ?></li>
      <li>📅 Prediksi haid berikutnya: <?= $prediksi_hari_haid ?></li>
      <li>🌱 Masa subur: <?= $masa_subur ?></li>
      <li>👶 Peluang kehamilan: <?= $peluang_kehamilan ?></li>
    </ul>
  </div>

  <div class="shortcut">
    <a href="pages/siklus.php" class="btn">Catat Siklus</a>
    <a href="pages/gejala.php" class="btn">Catat Gejala</a>
    <a href="pages/kalender.php" class="btn">Kalender</a>
    <a href="pages/.php" class="btn">Profil</a>
    <a href="pages/artikel.php" class="btn">Artikel</a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>