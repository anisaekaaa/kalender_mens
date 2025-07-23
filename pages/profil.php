<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit;
}
require '../proses/db.php';

$user_id = $_SESSION['user_id'];

// Ambil data user
$stmt = $conn->prepare("SELECT username, nama_lengkap, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Pesan sukses atau error dari proses update
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <link rel="stylesheet" href="/kalender_mens/css/style.css"> <!-- ✅ Tambahkan ini -->
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
  <h2>Profil Saya</h2>

  <?php if ($success): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
  <?php elseif ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form action="../proses/update_profil.php" method="POST">
    <label for="username">Username (tidak bisa diubah):</label>
    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" disabled>

    <label for="nama_lengkap">Nama Lengkap:</label>
    <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <label for="password">Password Baru (kosongkan jika tidak ingin diubah):</label>
    <input type="password" id="password" name="password" placeholder="Masukkan password baru">

    <label for="password_confirm">Konfirmasi Password Baru:</label>
    <input type="password" id="password_confirm" name="password_confirm" placeholder="Ulangi password baru">

    <button type="submit">Simpan Perubahan</button>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>