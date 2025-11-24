<?php
require_once __DIR__ . '/../../../backend/config/database.php';
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';

requireStaff();

// ringkasan cepat (aman kalau query gagal → default 0)
$booksCountRes      = $mysqli->query("SELECT COUNT(*) AS c FROM book");
$booksCountRow      = $booksCountRes ? $booksCountRes->fetch_assoc() : ['c' => 0];
$booksCount         = (int)($booksCountRow['c'] ?? 0);

$membersCountRes    = $mysqli->query("SELECT COUNT(*) AS c FROM member");
$membersCountRow    = $membersCountRes ? $membersCountRes->fetch_assoc() : ['c' => 0];
$membersCount       = (int)($membersCountRow['c'] ?? 0);

$activeBorrowingRes = $mysqli->query("SELECT COUNT(*) AS c FROM borrowing WHERE Brw_Status = 'Borrowed'");
$activeBorrowingRow = $activeBorrowingRes ? $activeBorrowingRes->fetch_assoc() : ['c' => 0];
$activeBorrowing    = (int)($activeBorrowingRow['c'] ?? 0);

$active = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Staff – InfiniRead</title>

  <!-- background gradient + layout umum -->
  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <link rel="stylesheet" href="/frontend/assets/css/dashboard.css">
  <!-- komponen tombol, dsb -->
  <link rel="stylesheet" href="/frontend/assets/css/components.css">

  <!-- Styling tambahan supaya seragam dengan member dashboard / daftar buku -->
  <style>
    /* NAVBAR (sama tone dengan member) */
    .topbar {
      background: rgba(255, 255, 255, 0.96);
      padding: 14px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #111827;
      border-bottom: 1px solid rgba(148, 163, 184, 0.5);
      box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
    }
    .brand {
      font-size: 22px;
      font-weight: 700;
      color: #111827;
    }
    .menu-right a {
      margin-left: 20px;
      padding: 7px 16px;
      border-radius: 999px;
      font-size: 14px;
      color: #4b5563;
      background: transparent;
      transition: background 0.15s, color 0.15s, box-shadow 0.15s;
      text-decoration: none;
    }
    .menu-right a:hover {
      background: #eef4ff;
      color: #1d4ed8;
    }
    .menu-right a.active {
      background: linear-gradient(135deg, #00e09e, #00c6ff);
      color: #ffffff;
      box-shadow: 0 8px 20px rgba(0, 198, 255, 0.35);
    }

    /* CARD & STATS */
    .card {
      background: rgba(255, 255, 255, 0.97);
      border-radius: 20px;
      padding: 24px 26px 26px;
      box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
      border: 1px solid rgba(226, 232, 240, 0.9);
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 18px;
      margin-top: 8px;
    }

    .stat-card {
      background: #f4f8ff;
      border-radius: 16px;
      padding: 16px 18px;
      font-size: 14px;
      color: #111827;
      border: 1px solid #dbe4ff;
      box-shadow: 0 10px 25px rgba(148, 163, 184, 0.35);
    }

    .stat-label {
      font-size: 13px;
      color: #6b7280;
      margin-bottom: 4px;
    }
    .stat-value {
      font-size: 20px;
      font-weight: 700;
      color: #111827;
    }

    /* TOMBOL PROFIL STAFF */
    .page-actions {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 14px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #00e09e, #00c6ff);
      border: none;
      color: #ffffff;
      padding: 9px 18px;
      border-radius: 999px;
      cursor: pointer;
      font-weight: 600;
      font-size: 14px;
      box-shadow: 0 10px 25px rgba(0, 198, 255, 0.35);
      text-decoration: none;
      display: inline-block;
      transition: transform 0.1s ease, box-shadow 0.1s ease, filter 0.1s ease;
    }
    .btn-primary:hover {
      transform: translateY(-1px);
      filter: brightness(1.04);
      box-shadow: 0 14px 30px rgba(0, 198, 255, 0.4);
    }

    @media (max-width: 900px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../../components/navbar_staff.php'; ?>

<div class="page-wrap">
  <h1 class="page-title">Dashboard Staff</h1>
  <p class="subtitle">Ringkasan aktivitas perpustakaan digital.</p>

  <!-- tombol ke profil staff -->
  <div class="page-actions">
    <a href="/frontend/pages/staff/profile.php" class="btn-primary">
      Lihat Profil Staff
    </a>
  </div>

  <div class="card">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Total Buku</div>
        <div class="stat-value"><?= $booksCount ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Member</div>
        <div class="stat-value"><?= $membersCount ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Peminjaman Aktif</div>
        <div class="stat-value"><?= $activeBorrowing ?></div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
