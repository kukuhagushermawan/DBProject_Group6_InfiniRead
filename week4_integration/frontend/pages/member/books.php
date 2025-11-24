<?php
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';
requireMember();

require_once __DIR__ . '/../../../backend/controllers/BookController.php';

// ambil flash kalau ada
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

// ambil keyword pencarian (optional)
$keyword = trim($_GET['q'] ?? '');

// ambil data buku + author (sudah support search)
[$booksResult, $authorMap] = BookController::getAllWithAuthors($keyword);

$active = 'books';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Buku – InfiniRead</title>

  <!-- CSS global + layout -->
  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <link rel="stylesheet" href="/frontend/assets/css/dashboard.css">

  <!-- INLINE STYLE: salinan style penting dari components.css
       supaya tampilan pasti cakep walaupun file components.css tidak terbaca -->
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

    /* CARD UTAMA */
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
      gap: 12px;
      margin-bottom: 14px;
    }
    .table-title {
      font-size: 18px;
      font-weight: 600;
      color: #111827;
    }

    /* SEARCH BAR */
    .search-form {
      margin: 0;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .search-input {
      background: #f4f8ff;
      border: 1px solid #c7d2fe;
      padding: 7px 12px;
      border-radius: 999px;
      font-size: 13px;
      min-width: 220px;
      color: #111827;
      outline: none;
    }
    .search-input:focus {
      border-color: #00c6ff;
      box-shadow: 0 0 0 1px rgba(0, 198, 255, 0.4);
      background: #eef4ff;
    }

    /* TABEL DATA */
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

    /* BUTTONS */
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

    .btn-ghost {
      padding: 7px 14px;
      border-radius: 999px;
      font-size: 13px;
      background: #f4f8ff;
      border: 1px solid #c7d2fe;
      cursor: pointer;
      transition: 0.15s;
    }
    .btn-ghost:hover {
      background: #e0eaff;
    }

    /* FLASH MESSAGE */
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

    .status-out {
      color: #d97706;
      font-weight: 600;
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../../components/navbar_member.php'; ?>

<div class="page-wrap">
  <h1 class="page-title">Daftar Buku</h1>
  <p class="subtitle">Pilih buku yang ingin kamu pinjam dari koleksi InfiniRead.</p>

  <?php if ($flash): ?>
    <div class="flash success"><?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <div class="card">
    <div class="table-header">
      <div class="table-title">Book List</div>

      <!-- FORM CARI + RELOAD -->
      <form method="get" class="search-form">
        <input
          type="text"
          name="q"
          class="search-input"
          placeholder="Cari ID / judul / kategori / author(s)..."
          value="<?= htmlspecialchars($keyword) ?>"
        >
        <button type="submit" class="btn-ghost">Cari</button>
        <a href="books.php" class="btn-ghost">Reset</a>
      </form>
    </div>

    <table class="data-table">
      <thead>
        <tr>
          <th>Book ID</th>
          <th>Category</th>
          <th>Title</th>
          <th>ISBN</th>
          <th>Pages</th>
          <th>Pub<br>Year</th>
          <th>Age<br>Rating</th>
          <th>Max<br>Borrow Days</th>
          <th>Stock</th>
          <th>Author(s)</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($booksResult && $booksResult->num_rows > 0): ?>
        <?php while ($row = $booksResult->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['Book_ID']) ?></td>
            <td><?= htmlspecialchars($row['Category']) ?></td>
            <td><?= htmlspecialchars($row['Title']) ?></td>
            <td><?= htmlspecialchars($row['ISBN']) ?></td>
            <td><?= (int)$row['Pages'] ?></td>
            <td><?= (int)$row['Pub_Year'] ?></td>
            <td><?= (int)$row['Age_Rating'] ?></td>
            <td><?= htmlspecialchars($row['Max_Borrowdays']) ?></td>
            <td><?= (int)$row['Stock'] ?></td>
            <td><?= htmlspecialchars($authorMap[$row['Book_ID']] ?? '-') ?></td>
            <td>
              <?php if ((int)$row['Stock'] > 0): ?>
                <form action="/frontend/pages/member/borrow_action.php"
                      method="post" style="display:inline;">
                  <input type="hidden" name="book_id"
                         value="<?= htmlspecialchars($row['Book_ID']) ?>">
                  <button type="submit" class="btn-primary">Pinjam</button>
                </form>
              <?php else: ?>
                <span class="status-out">Habis</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="11" style="text-align:center;">
            <?php if ($keyword !== ''): ?>
              Tidak ada buku yang cocok dengan kata kunci "<?= htmlspecialchars($keyword) ?>".
            <?php else: ?>
              Belum ada data buku.
            <?php endif; ?>
          </td>
        </tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
