<?php
require_once __DIR__ . '/../../../backend/config/database.php';
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../../backend/models/Member.php';

requireStaff();

$flash   = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

// keyword search nama / email
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $like = '%' . $keyword . '%';

    $stmt = $mysqli->prepare("
        SELECT 
            m.*,
            s.Staff_Name
        FROM member m
        LEFT JOIN staff s ON m.Staff_ID = s.Staff_ID
        WHERE m.Full_Name LIKE ?
           OR m.Email     LIKE ?
        ORDER BY m.Mem_ID ASC
    ");
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $rows = Member::all($mysqli); // fungsi lama tetap dipakai kalau tanpa search
}

$active = 'members';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Member – Staff</title>

  <!-- CSS GLOBAL -->
  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <link rel="stylesheet" href="/frontend/assets/css/dashboard.css">

  <style>
    /* NAVBAR – sama dengan halaman lain */
    .topbar {
      background: rgba(255,255,255,0.96);
      padding: 14px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(148,163,184,0.5);
      box-shadow: 0 10px 25px rgba(15,23,42,0.15);
      color: #111827;
    }
    .brand {
      font-size: 22px;
      font-weight: 700;
    }
    .menu-right a {
      margin-left: 20px;
      padding: 7px 16px;
      border-radius: 999px;
      font-size: 14px;
      color: #4b5563;
      text-decoration: none;
      transition: .15s;
    }
    .menu-right a:hover {
      background: #eef4ff;
      color: #1d4ed8;
    }
    .menu-right a.active {
      background: linear-gradient(135deg,#00e09e,#00c6ff);
      color: #fff;
      box-shadow: 0 8px 20px rgba(0,198,255,0.35);
    }

    /* CARD */
    .card {
      background: rgba(255,255,255,0.97);
      border-radius: 20px;
      padding: 26px 28px 30px;
      box-shadow: 0 18px 45px rgba(15,23,42,0.18);
      border: 1px solid rgba(226,232,240,0.9);
      margin-top: 10px;
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 14px;
    }
    .table-title {
      font-size: 18px;
      font-weight: 600;
      color: #111827;
    }

    .search-box {
      display: flex;
      gap: 8px;
      align-items: center;
    }
    .search-input {
      padding: 7px 10px;
      border-radius: 999px;
      border: 1px solid #c7d2fe;
      font-size: 13px;
      background: #f4f8ff;
      outline: none;
    }
    .search-input:focus {
      border-color: #00c6ff;
      box-shadow: 0 0 0 1px rgba(0, 198, 255, 0.4);
      background: #eef4ff;
    }

    /* TABLE */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }
    .data-table th {
      background: #f3f6ff;
      padding: 10px 12px;
      font-weight: 600;
      color: #4b5563;
      border-bottom: 1px solid #e5e7eb;
      text-align: left;
      white-space: nowrap;
    }
    .data-table td {
      padding: 10px 12px;
      border-bottom: 1px solid #e5e7eb;
      background: #fff;
      color: #111827;
      vertical-align: middle;
    }
    .data-table tr:nth-child(even) td {
      background: #f9fbff;
    }
    .data-table tr:hover td {
      background: #eef4ff;
    }

    .btn-primary {
      background: linear-gradient(135deg,#00e09e,#00c6ff);
      border: none;
      color: #fff;
      padding: 6px 14px;
      border-radius: 999px;
      cursor: pointer;
      font-size: 13px;
      font-weight: 600;
      box-shadow: 0 10px 25px rgba(0,198,255,0.35);
      transition: 0.15s;
    }
    .btn-primary:hover {
      transform: translateY(-1px);
      filter: brightness(1.04);
      box-shadow: 0 14px 30px rgba(0,198,255,0.45);
    }

    .flash {
      padding: 10px 12px;
      border-radius: 999px;
      margin-bottom: 14px;
      font-size: 13px;
      text-align: center;
    }
    .flash.success {
      background: #dcfce7;
      color: #166534;
      border: 1px solid #bbf7d0;
    }
    .flash.error {
      background: #fee2e2;
      color: #b91c1c;
      border: 1px solid #fecaca;
    }
  </style>
</head>

<body>

<?php include __DIR__ . '/../../components/navbar_staff.php'; ?>

<div class="page-wrap">
  <h1 class="page-title">Daftar Member</h1>
  <p class="subtitle">Staff dapat melihat dan memverifikasi member.</p>

  <?php if ($flash): ?>
    <div class="flash success"><?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <div class="card">
    <div class="table-header">
      <div class="table-title">Daftar Member</div>
      <form method="get" class="search-box">
        <input
          type="text"
          name="q"
          class="search-input"
          placeholder="Cari nama atau email..."
          value="<?= htmlspecialchars($keyword) ?>"
        >
        <button type="submit" class="btn-primary">Cari</button>
      </form>
    </div>

    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Gender</th>
          <th>Usia</th>
          <th>Status</th>
          <th>Staff Verifikator</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($rows as $m): ?>
        <?php
          // hitung usia dari Date_of_Birth
          $ageText = '-';
          if (!empty($m['Date_of_Birth'])) {
              try {
                  $dob   = new DateTime($m['Date_of_Birth']);
                  $today = new DateTime();
                  $age   = $today->diff($dob)->y;
                  $ageText = $age . ' tahun';
              } catch (Exception $e) {
                  $ageText = '-';
              }
          }

          // teks status verifikasi
          $statusText = ((int)$m['Is_Verified'] === 1) ? 'Terverifikasi' : 'Menunggu';
        ?>
        <tr>
          <td><?= (int)$m['Mem_ID'] ?></td>
          <td><?= htmlspecialchars($m['Full_Name']) ?></td>
          <td><?= htmlspecialchars($m['Email']) ?></td>
          <td><?= htmlspecialchars($m['Gender']) ?></td>

          <!-- Usia -->
          <td><?= htmlspecialchars($ageText) ?></td>

          <!-- Status verifikasi -->
          <td><?= $statusText ?></td>

          <td><?= htmlspecialchars($m['Staff_Name'] ?? '-') ?></td>

          <td>
            <?php if ((int)$m['Is_Verified'] !== 1): ?>
              <form action="verify_member.php" method="post" style="display:inline;">
                <input type="hidden" name="mem_id" value="<?= (int)$m['Mem_ID'] ?>">
                <button class="btn-primary" type="submit">Verifikasi</button>
              </form>
            <?php else: ?>
              -
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
