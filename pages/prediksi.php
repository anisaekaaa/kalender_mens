<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit;
}
require '../proses/db.php';

$user_id = $_SESSION['user_id'];

// Ambil data siklus terakhir user
$stmt = $conn->prepare("SELECT tanggal_mulai, durasi FROM siklus WHERE user_id = ? ORDER BY tanggal_mulai DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$last_cycle = $result->fetch_assoc();

$prediction = [
  'haid_berikutnya' => 'Data siklus tidak tersedia',
  'ovulasi' => '-',
  'masa_subur' => '-',
];

if ($last_cycle) {
  $cycle_length = 28; // default siklus, bisa dikembangkan dari data riwayat
  $tgl_mulai = $last_cycle['tanggal_mulai'];

  $tanggal_mulai_ts = strtotime($tgl_mulai);

  // Prediksi haid berikutnya: tanggal mulai siklus + panjang siklus
  $haid_berikutnya_start = strtotime("+{$cycle_length} days", $tanggal_mulai_ts);
  $haid_berikutnya_end = strtotime("+".($cycle_length + $last_cycle['durasi'] - 1)." days", $tanggal_mulai_ts);

  // Ovulasi biasanya 14 hari sebelum haid berikutnya
  $ovulasi_ts = strtotime("-14 days", $haid_berikutnya_start);

  // Masa subur 5 hari sebelum + 1 hari sesudah ovulasi
  $masa_subur_start = strtotime("-5 days", $ovulasi_ts);
  $masa_subur_end = strtotime("+1 days", $ovulasi_ts);

  $prediction['haid_berikutnya'] = date('d M Y', $haid_berikutnya_start) . " - " . date('d M Y', $haid_berikutnya_end);
  $prediction['ovulasi'] = date('d M Y', $ovulasi_ts);
  $prediction['masa_subur'] = date('d M Y', $masa_subur_start) . " - " . date('d M Y', $masa_subur_end);
}
?>

<?php include '../includes/header.php'; ?>

<div class="container">
  <h2>Prediksi Siklus Menstruasi</h2>

  <div class="prediction-box">
    <p><strong>Haid Berikutnya:</strong> <?= htmlspecialchars($prediction['haid_berikutnya']) ?></p>
    <p><strong>Ovulasi:</strong> <?= htmlspecialchars($prediction['ovulasi']) ?></p>
    <p><strong>Masa Subur:</strong> <?= htmlspecialchars($prediction['masa_subur']) ?></p>
  </div>

  <section class="tips">
    <h3>Tips Singkat</h3>
    <ul>
      <li>Catat siklus menstruasi secara rutin untuk prediksi yang lebih akurat.</li>
      <li>Jaga pola hidup sehat untuk siklus yang teratur.</li>
      <li>Perhatikan tanda-tanda ovulasi seperti perubahan lendir serviks dan suhu basal.</li>
    </ul>
  </section>
</div>

<?php include '../includes/footer.php'; ?>