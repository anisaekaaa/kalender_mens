<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Catat Siklus</title>
    <link rel="stylesheet" href="/kalender_mens/css/style.css">
</head>
<body>

<?php
include '../includes/header.php';
require '../proses/db.php';

$user_id = $_SESSION['user_id'];

// Ambil riwayat siklus
$query = $conn->prepare("SELECT * FROM siklus WHERE user_id = ? ORDER BY tanggal_mulai DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<div class="container">
    <h2>Catat Siklus Menstruasi</h2>
    <form action="../proses/simpan_siklus.php" method="POST">
        <label>Tanggal Mulai Haid:</label>
        <input type="date" name="tanggal_mulai" required>

        <label>Durasi (hari):</label>
        <input type="number" name="durasi" min="1" required>

        <label>Catatan (opsional):</label>
        <textarea name="catatan"></textarea>

        <button type="submit">Simpan</button>
    </form>

    <h3>Riwayat Siklus</h3>
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Durasi</th>
            <th>Catatan</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
            <td><?= htmlspecialchars($row['durasi']) ?> hari</td>
            <td><?= htmlspecialchars($row['catatan']) ?></td>
            <td>
                <a href="#">Edit</a> | <a href="#">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>