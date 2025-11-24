<?php
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';
requireMember();

require_once __DIR__ . '/../../../backend/controllers/BorrowingController.php';

$mem_id  = $_SESSION['member_id'];
$keyword = trim($_GET['q'] ?? '');

// ambil riwayat + filter keyword (jika ada)
$result = BorrowingController::getHistoryByMember($mem_id, $keyword);

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

$active = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Member – InfiniRead</title>

  <!-- CSS global + layout -->
  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <link rel="stylesheet" href="/frontend/assets/css/dashboard.css">

  <!-- INLINE STYLE: seragam dengan books.php -->
  <style>
    /* NAVBAR */
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

    /* CARD */
    .card {
      background: rgba(255, 255, 255, 0.97);
      border-radius: 20px;
      padding: 24px 26px 30px;
      box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
      border: 1px solid rgba(226, 232, 240, 0.9);
    }
    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 14px;
      gap: 12px;
      flex-wrap: wrap;
    }
    .table-title {
      font-size: 18px;
      font-weight: 600;
      color: #111827;
    }

    /* SEARCH */
    .search-form {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .search-input {
      padding: 7px 10px;
      border-radius: 999px;
      border: 1px solid #c7d2fe;
      background: #f4f8ff;
      font-size: 13px;
      min-width: 230px;
      outline: none;
    }
    .search-input:focus {
      border-color: #00c6ff;
      box-shadow: 0 0 0 1px rgba(0,198,255,0.35);
      background: #eef4ff;
    }
    .btn-ghost {
      padding: 7px 14px;
      border-radius: 999px;
      font-size: 13px;
      background: #f4f8ff;
      border: 1px solid #c7d2fe;
      cursor: pointer;
      transition: 0.15s;
      text-decoration: none;
      color: #1f2937;
    }
    .btn-ghost:hover {
      background: #e0eaff;
    }

    /* TABEL */
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
      padding: 9px 12px;
      border-bottom: 1px solid #e5e7eb;
      background: #ffffff;
      color: #111827;
      vertical-align: middle;
    }
    .data-table tr:nth-child(even) td {
      background: #f9fbff;
    }
    .data-table tr:hover td {
      background: #eef4ff;
    }

    /* BUTTON UTAMA (Kembalikan) */
    .btn-primary {
      background: linear-gradient(135deg, #00e09e, #00c6ff);
      border: none;
      color: #ffffff;
      padding: 7px 16px;
      border-radius: 999px;
      cursor: pointer;
      font-weight: 600;
      font-size: 13px;
      box-shadow: 0 10px 25px rgba(0, 198, 255, 0.35);
      transition: transform 0.1s ease, box-shadow 0.1s ease, filter 0.1s ease;
    }
    .btn-primary:hover {
      transform: translateY(-1px);
      filter: brightness(1.04);
      box-shadow: 0 14px 30px rgba(0, 198, 255, 0.4);
    }

    /* LINK BUKU (tombol putih kecil) */
    .btn-link-book {
      display: inline-block;
      padding: 6px 14px;
      border-radius: 999px;
      background: #ffffff;
      border: 1px solid #c7d2fe;
      font-size: 12px;
      color: #2563eb;
      text-decoration: none;
      box-shadow: 0 10px 25px rgba(148, 163, 184, 0.35);
      transition: background 0.15s, box-shadow 0.15s, transform 0.1s;
    }
    .btn-link-book:hover {
      background: #eef4ff;
      box-shadow: 0 14px 30px rgba(148, 163, 184, 0.45);
      transform: translateY(-1px);
    }

    /* FLASH */
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

    .status-returned {
      color: #059669;
      font-weight: 600;
    }
  </style>
</head>

<body>

<?php include __DIR__ . '/../../components/navbar_member.php'; ?>

<div class="page-wrap">
  <h1 class="page-title">
    Selamat datang, <?= htmlspecialchars($_SESSION['member_name']) ?>
  </h1>
  <p class="subtitle">Berikut riwayat peminjaman buku Anda.</p>

  <?php if ($flash): ?>
    <div class="flash success"><?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <div class="card">
    <div class="table-header">
      <div class="table-title">Riwayat Peminjaman</div>

      <!-- FORM SEARCH -->
      <form method="get" class="search-form">
        <input
          type="text"
          name="q"
          class="search-input"
          placeholder="Cari ID / Judul / Kategori / Author..."
          value="<?= htmlspecialchars($keyword) ?>"
        >
        <button type="submit" class="btn-ghost">Cari</button>
      </form>
    </div>

    <table class="data-table">
      <thead>
        <tr>
          <th>ID Peminjaman</th>
          <th>Judul Buku</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Jatuh Tempo</th>
          <th>Tanggal Kembali</th>
          <th>Link Buku</th>
          <th>Aksi / Status</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= (int)$row['Brw_ID'] ?></td>
          <td><?= htmlspecialchars($row['Title']) ?></td>
          <td><?= htmlspecialchars($row['Brw_Date']) ?></td>
          <td><?= htmlspecialchars($row['Due_Date']) ?></td>
          <td><?= htmlspecialchars($row['Return_Date'] ?? '-') ?></td>

          <!-- LINK BUKU: hanya aktif kalau masih Borrowed & belum dikembalikan -->
          <td>
            <?php if ($row['Brw_Status'] === 'Borrowed'
                      && $row['Return_Date'] === null
                      && !empty($row['File_URL'])): ?>
              <a href="<?= htmlspecialchars($row['File_URL']) ?>"
                 target="_blank"
                 class="btn-link-book">
                Buka Buku
              </a>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>

          <!-- AKSI / STATUS -->
          <td>
            <?php if ($row['Brw_Status'] === 'Borrowed'
                      && $row['Return_Date'] === null): ?>
              <form action="/frontend/pages/member/return_action.php"
                    method="post" style="display:inline;">
                <input type="hidden" name="brw_id"
                       value="<?= (int)$row['Brw_ID'] ?>">
                <button type="submit" class="btn-primary">Kembalikan</button>
              </form>
            <?php else: ?>
              <span class="status-returned">
                <?= htmlspecialchars($row['Brw_Status']) ?>
              </span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
