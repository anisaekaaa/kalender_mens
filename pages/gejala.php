<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit;
}

require '../proses/db.php';

$user_id = $_SESSION['user_id'];

// Ambil data gejala user
$stmt = $conn->prepare("SELECT tanggal, mood, nyeri, energi, catatan FROM gejala_harian WHERE user_id = ? ORDER BY tanggal DESC LIMIT 10");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Gejala Harian</title>
  <link rel="stylesheet" href="/kalender_mens/css/style.css"> <!-- ✅ CSS ditambahkan di sini -->
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
  <h2>Catat Gejala Harian</h2>

  <!-- Notifikasi sukses/error -->
  <?php
  if (isset($_SESSION['success'])) {
    echo '<p class="success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
  }
  if (isset($_SESSION['error'])) {
    echo '<p class="error">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
  }
  ?>

  <form action="../proses/simpan_gejala.php" method="POST">
    <label for="tanggal">Tanggal:</label>
    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>

    <label for="mood">Mood hari ini:</label>
    <select name="mood" required>
      <option value="">-- Pilih Mood --</option>
      <option value="😊">😊 Senang</option>
      <option value="😐">😐 Biasa</option>
      <option value="😞">😞 Sedih</option>
      <option value="😡">😡 Marah</option>
      <option value="😴">😴 Lelah</option>
    </select>

    <label for="nyeri">Nyeri (1–5):</label>
    <select name="nyeri" required>
      <option value="">-- Pilih Skala Nyeri --</option>
      <?php for ($i=1; $i <= 5; $i++): ?>
      <option value="<?= $i ?>"><?= $i ?></option>
      <?php endfor; ?>
    </select>

    <label for="energi">Energi (1–5):</label>
    <select name="energi" required>
      <option value="">-- Pilih Skala Energi --</option>
      <?php for ($i=1; $i <= 5; $i++): ?>
      <option value="<?= $i ?>"><?= $i ?></option>
      <?php endfor; ?>
    </select>

    <label for="catatan">Catatan tambahan:</label>
    <textarea name="catatan" rows="3" placeholder="Isi catatan jika perlu..."></textarea>

    <button type="submit">Simpan Gejala</button>
  </form>

  <h3>Riwayat Gejala Terakhir</h3>
  <table>
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Mood</th>
        <th>Nyeri</th>
        <th>Energi</th>
        <th>Catatan</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['tanggal']) ?></td>
        <td><?= htmlspecialchars($row['mood']) ?></td>
        <td><?= htmlspecialchars($row['nyeri']) ?></td>
        <td><?= htmlspecialchars($row['energi']) ?></td>
        <td><?= htmlspecialchars($row['catatan']) ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>