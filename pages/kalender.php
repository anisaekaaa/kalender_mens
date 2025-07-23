<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit;
}
require '../proses/db.php';

$user_id = $_SESSION['user_id'];

if (isset($_GET['month']) && isset($_GET['year'])) {
  $month = (int)$_GET['month'];
  $year = (int)$_GET['year'];
  if ($month < 1 || $month > 12) {
    $month = (int)date('n');
    $year = (int)date('Y');
  }
} else {
  $month = (int)date('n');
  $year = (int)date('Y');
}

$prevMonth = $month - 1;
$prevYear = $year;
if ($prevMonth < 1) {
  $prevMonth = 12;
  $prevYear--;
}
$nextMonth = $month + 1;
$nextYear = $year;
if ($nextMonth > 12) {
  $nextMonth = 1;
  $nextYear++;
}

$stmt = $conn->prepare("SELECT tanggal_mulai, durasi FROM siklus WHERE user_id = ? ORDER BY tanggal_mulai DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$last_cycle = $result->fetch_assoc();

if (!$last_cycle) {
  $message = "Belum ada data siklus menstruasi. Silakan isi data siklus terlebih dahulu.";
}

function buildCalendar($month, $year, $last_cycle) {
  $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
  $firstDayOfMonth = date('N', strtotime("$year-$month-01"));

  $period_days = $last_cycle['durasi'];
  $period_start = $last_cycle['tanggal_mulai'];
  $cycle_length = 28;

  $period_start_time = strtotime($period_start);
  $periods = [];

  for ($i = -1; $i <= 3; $i++) {
    $start = strtotime("+".($i * $cycle_length)." days", $period_start_time);
    $periods[] = [
      'start' => date('Y-m-d', $start),
      'end' => date('Y-m-d', strtotime("+".($period_days-1)." days", $start)),
      'ovulation' => date('Y-m-d', strtotime("+".($cycle_length - 14)." days", $start)),
    ];
  }

  $haid_dates = [];
  $fertile_dates = [];
  $ovulation_dates = [];

  foreach ($periods as $p) {
    $startDate = new DateTime($p['start']);
    $endDate = new DateTime($p['end']);
    for ($d = clone $startDate; $d <= $endDate; $d->modify('+1 day')) {
      $haid_dates[] = $d->format('Y-m-d');
    }

    $ovulation_dates[] = $p['ovulation'];

    $ovul_date = new DateTime($p['ovulation']);
    for ($d = (clone $ovul_date)->modify('-5 days'); $d <= (clone $ovul_date)->modify('+1 days'); $d->modify('+1 day')) {
      $fertile_dates[] = $d->format('Y-m-d');
    }
  }

  $html = '<table class="calendar">';
  $html .= '<thead><tr>';
  $daysOfWeek = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
  foreach ($daysOfWeek as $day) {
    $html .= "<th>$day</th>";
  }
  $html .= '</tr></thead><tbody><tr>';

  $dayCount = 1;
  $cellCount = 1;

  for ($i = 1; $i < $firstDayOfMonth; $i++) {
    $html .= "<td></td>";
    $cellCount++;
  }

  while ($dayCount <= $daysInMonth) {
    if ($cellCount > 7) {
      $html .= "</tr><tr>";
      $cellCount = 1;
    }

    $current_date = date('Y-m-d', strtotime("$year-$month-$dayCount"));

    $class = '';
    if (in_array($current_date, $haid_dates)) {
      $class = 'period';
    } elseif (in_array($current_date, $fertile_dates)) {
      $class = 'fertile';
    } elseif (in_array($current_date, $ovulation_dates)) {
      $class = 'ovulation';
    }

    $html .= "<td class='$class'>$dayCount</td>";

    $dayCount++;
    $cellCount++;
  }

  while ($cellCount <= 7) {
    $html .= "<td></td>";
    $cellCount++;
  }

  $html .= '</tr></tbody></table>';

  return $html;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kalender Menstruasi</title>
  <link rel="stylesheet" href="/kalender_mens/css/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
  <h2>Kalender Siklus Menstruasi</h2>

  <?php if (isset($message)) : ?>
    <p class="error"><?= htmlspecialchars($message) ?></p>
  <?php else: ?>
    <div class="nav-month">
      <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>">&laquo; Bulan Sebelumnya</a> |
      <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>">Bulan Berikutnya &raquo;</a>
    </div>

    <?php
      $bulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
      ];
    ?>
    <h3 style="text-align: center; margin-top: 10px; color: #f472b6;">
      <?= $bulanIndo[$month] . ' ' . $year ?>
    </h3>

    <?= buildCalendar($month, $year, $last_cycle); ?>

    <p><strong>Legenda:</strong> 
      <span class="period-box">Haid</span> 
      <span class="fertile-box">Masa Subur</span> 
      <span class="ovulation-box">Ovulasi</span>
    </p>
  <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>