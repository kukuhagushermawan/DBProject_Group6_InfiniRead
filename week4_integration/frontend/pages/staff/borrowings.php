<?php
require_once __DIR__ . '/../../../backend/config/database.php';
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../../backend/models/Borrowing.php';

requireStaff();

// ======== SEARCH PROCESS ========
$keyword = trim($_GET['search'] ?? '');

$rows = Borrowing::all($mysqli);

// Filter manual di PHP
if ($keyword !== '') {
    $key = strtolower($keyword);
    $rows = array_filter($rows, function($r) use ($key) {
        return
            str_contains(strtolower($r['Title']), $key) ||
            str_contains(strtolower($r['Member_Name']), $key) ||
            str_contains(strtolower($r['Staff_Name'] ?? ''), $key) ||
            str_contains(strtolower($r['Brw_Status']), $key);
    });
}

$active = 'borrowings';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Peminjaman – Staff</title>

  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <link rel="stylesheet" href="/frontend/assets/css/dashboard.css">

  <style>
    .topbar {
      background: rgba(255, 255, 255, 0.96);
      padding: 14px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(148,163,184,0.5);
      box-shadow: 0 10px 25px rgba(15,23,42,0.15);
      color: #111827;
    }
    .brand { font-size: 22px; font-weight: 700; }
    .menu-right a {
      margin-left: 20px;
      padding: 7px 16px;
      border-radius: 999px;
      font-size: 14px;
      color: #4b5563;
      text-decoration: none;
      transition: 0.15s;
    }
    .menu-right a:hover { background:#eef4ff; color:#1d4ed8; }
    .menu-right a.active {
      background: linear-gradient(135deg,#00e09e,#00c6ff);
      color: #fff;
      box-shadow: 0 8px 20px rgba(0,198,255,0.35);
    }

    .card {
      background: rgba(255,255,255,0.97);
      border-radius: 20px;
      padding: 26px 28px 30px;
      box-shadow: 0 18px 45px rgba(15,23,42,0.18);
      border: 1px solid rgba(226,232,240,0.9);
      margin-top: 10px;
    }

    .data-table { width:100%; border-collapse:collapse; font-size:13px; }
    .data-table th {
      background:#f3f6ff; padding:10px 12px; font-weight:600;
      border-bottom:1px solid #e5e7eb;
    }
    .data-table td {
      padding:10px 12px; border-bottom:1px solid #e5e7eb;
    }
    .data-table tr:nth-child(even) td { background:#f9fbff; }
    .data-table tr:hover td { background:#eef4ff; }

    .status-returned { color:#059669; font-weight:600; }
    .status-borrowed { color:#2563eb; font-weight:600; }

    /* Search Bar */
    .search-box {
      margin-bottom: 18px;
      display:flex;
      gap:10px;
    }
    .search-box input {
      flex:1;
      padding:10px 14px;
      border-radius:12px;
      border:1px solid #cbd5e1;
      background:#f8fafc;
      font-size:14px;
    }
    .search-box button {
      padding:10px 18px;
      border-radius:12px;
      border:none;
      background:linear-gradient(135deg,#00e09e,#00c6ff);
      color:white;
      font-weight:600;
      cursor:pointer;
    }
  </style>
</head>

<body>

<?php include __DIR__ . '/../../components/navbar_staff.php'; ?>

<div class="page-wrap">
  <h1 class="page-title">Data Peminjaman</h1>
  <p class="subtitle">Semua transaksi peminjaman dan pengembalian buku.</p>

  <div class="card">

    <!-- SEARCH BAR -->
    <form method="get" class="search-box">
      <input type="text" name="search" placeholder="Cari Judul / Member / Staff / Status..."
             value="<?= htmlspecialchars($keyword) ?>">
      <button type="submit">Search</button>
    </form>

    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Judul Buku</th>
          <th>Member</th>
          <th>Staff</th>
          <th>Tgl Pinjam</th>
          <th>Jatuh Tempo</th>
          <th>Tgl Kembali</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>

      <?php if (empty($rows)): ?>
        <tr>
          <td colspan="8" style="text-align:center; padding:20px;">
            Tidak ada data ditemukan.
          </td>
        </tr>
      <?php endif; ?>

      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= (int)$r['Brw_ID'] ?></td>
          <td><?= htmlspecialchars($r['Title']) ?></td>
          <td><?= htmlspecialchars($r['Member_Name']) ?></td>
          <td><?= htmlspecialchars($r['Staff_Name'] ?? '-') ?></td>
          <td><?= htmlspecialchars($r['Brw_Date']) ?></td>
          <td><?= htmlspecialchars($r['Due_Date']) ?></td>
          <td><?= htmlspecialchars($r['Return_Date'] ?? '-') ?></td>

          <td>
            <?php if ($r['Brw_Status'] === 'Returned'): ?>
              <span class="status-returned">Returned</span>
            <?php else: ?>
              <span class="status-borrowed">Borrowed</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>

      </tbody>
    </table>
  </div>
</div>

</body>
</html>
