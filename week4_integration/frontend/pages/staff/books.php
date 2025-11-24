<?php
require_once __DIR__ . '/../../../backend/config/database.php';
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../../backend/controllers/BookController.php';

requireStaff();

// ambil pesan flash
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

// ==========================
//  SEARCH
// ==========================
$keyword = trim($_GET['search'] ?? '');
[$booksResult, $authorMap] = BookController::getAllWithAuthors($keyword);

// proses form POST (create / update / delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['form_type'] ?? '';

    if ($formType === 'create_book') {
        $staffId = (int)($_SESSION['staff_id'] ?? 0);
        if ($staffId <= 0) {
            $flash = 'Session staff tidak valid, silakan login ulang.';
        } else {
            $flash = BookController::createBook($_POST, $staffId);
        }
        $_SESSION['flash'] = $flash;
        header('Location: books.php');
        exit;
    }

    if ($formType === 'update_book') {
        $flash = BookController::updateBook($_POST);
        $_SESSION['flash'] = $flash;
        header('Location: books.php');
        exit;
    }

    if ($formType === 'delete_book') {
        $bookId = $_POST['book_id'] ?? '';
        $flash  = BookController::deleteBook($bookId);
        $_SESSION['flash'] = $flash;
        header('Location: books.php');
        exit;
    }
}

// jika ada edit_id di URL → ambil data buku
$editId       = $_GET['edit_id'] ?? '';
$editingBook  = null;
$editingAuths = '';

if ($editId !== '') {
    $stmt = $mysqli->prepare("
        SELECT Book_ID, Category, Title, ISBN, Pages, Pub_Year,
               Age_Rating, Max_Borrowdays, Stock, File_URL
        FROM book
        WHERE Book_ID = ?
        LIMIT 1
    ");
    $stmt->bind_param('s', $editId);
    $stmt->execute();
    $res         = $stmt->get_result();
    $editingBook = $res->fetch_assoc() ?: null;
    $stmt->close();

    // ambil author
    $stmt = $mysqli->prepare("
        SELECT GROUP_CONCAT(Author SEPARATOR ', ') AS Authors
        FROM book_author
        WHERE Book_ID = ?
    ");
    $stmt->bind_param('s', $editId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $editingAuths = $row['Authors'] ?? '';
    }
    $stmt->close();
}

$active = 'books';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Buku – Staff</title>

  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <link rel="stylesheet" href="/frontend/assets/css/dashboard.css">

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
      transition: 0.15s;
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
      margin-bottom: 24px;
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

    /* SEARCH INPUT */
    .search-box {
      display: flex;
      gap: 10px;
    }
    .search-input {
      padding: 8px 12px;
      border: 1px solid #c7d2fe;
      background: #f4f8ff;
      border-radius: 999px;
      font-size: 14px;
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
    }
    .data-table td {
      padding: 9px 12px;
      border-bottom: 1px solid #e5e7eb;
      background: #ffffff;
    }
    .data-table tr:nth-child(even) td {
      background: #f9fbff;
    }

    /* BUTTONS */
    .btn-primary {
      background: linear-gradient(135deg, #00e09e, #00c6ff);
      border: none;
      color: #fff;
      padding: 7px 16px;
      border-radius: 999px;
      cursor: pointer;
      font-weight: 600;
    }
    .btn-ghost {
      padding: 7px 14px;
      border-radius: 999px;
      font-size: 13px;
      background: #f4f8ff;
      border: 1px solid #c7d2fe;
      cursor: pointer;
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../../components/navbar_staff.php'; ?>

<div class="page-wrap">
  <h1 class="page-title">Kelola Buku</h1>
  <p class="subtitle">Staff dapat menambahkan, mengedit, dan menghapus buku.</p>

  <?php if ($flash): ?>
    <div class="flash success"><?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <!-- ============================= -->
  <!-- SEARCH BAR -->
  <!-- ============================= -->
  <div class="card" style="margin-bottom:20px;">
    <form method="get" class="search-box">
      <input type="text"
             name="search"
             class="search-input"
             placeholder="Cari judul, kategori, ID, atau author..."
             value="<?= htmlspecialchars($keyword) ?>">
      <button class="btn-primary">Search</button>
      <?php if ($keyword !== ''): ?>
        <a href="books.php" class="btn-ghost">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <!-- ============================= -->
  <!-- FORM TAMBAH / EDIT -->
  <!-- ============================= -->
  <div class="card">
    <div class="table-header">
      <div class="table-title">
        <?= $editingBook ? 'Edit Buku: ' . htmlspecialchars($editingBook['Book_ID']) : 'Tambah Buku Baru' ?>
      </div>
      <?php if ($editingBook): ?>
        <a href="books.php" class="btn-ghost">Batal Edit</a>
      <?php endif; ?>
    </div>

    <?php $val = fn($k, $d='') => $editingBook[$k] ?? $d; ?>

    <form method="post" class="form-grid">
      <input type="hidden" name="form_type"
             value="<?= $editingBook ? 'update_book' : 'create_book' ?>">

      <div class="form-group">
        <label>Book ID</label>
        <input type="text" name="Book_ID"
               value="<?= htmlspecialchars($val('Book_ID')) ?>"
               <?= $editingBook ? 'readonly' : 'required' ?>>
      </div>

      <div class="form-group">
        <label>Judul</label>
        <input type="text" name="Title"
               value="<?= htmlspecialchars($val('Title')) ?>" required>
      </div>

      <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="Category"
               value="<?= htmlspecialchars($val('Category')) ?>" required>
      </div>

      <div class="form-group">
        <label>ISBN</label>
        <input type="text" name="ISBN"
               value="<?= htmlspecialchars($val('ISBN')) ?>" required>
      </div>

      <div class="form-group">
        <label>Jumlah Halaman</label>
        <input type="number" name="Pages" min="1"
               value="<?= htmlspecialchars($val('Pages')) ?>" required>
      </div>

      <div class="form-group">
        <label>Tahun Terbit</label>
        <input type="number" name="Pub_Year" min="0"
               value="<?= htmlspecialchars($val('Pub_Year')) ?>" required>
      </div>

      <div class="form-group">
        <label>Age Rating (usia minimum)</label>
        <input type="number" name="Age_Rating"
               min="0"
               value="<?= htmlspecialchars($val('Age_Rating')) ?>" required>
      </div>

      <div class="form-group">
        <label>Maks. Hari Peminjaman</label>
        <select name="Max_Borrowdays" required>
          <?php $sel = $val('Max_Borrowdays'); ?>
          <option value="">Pilih</option>
          <option value="3"  <?= $sel=='3'?'selected':'' ?>>3 hari</option>
          <option value="7"  <?= $sel=='7'?'selected':'' ?>>7 hari</option>
          <option value="14" <?= $sel=='14'?'selected':'' ?>>14 hari</option>
        </select>
      </div>

      <div class="form-group">
        <label>Stok</label>
        <input type="number" name="Stock"
               value="<?= htmlspecialchars($val('Stock',0)) ?>" required>
      </div>

      <div class="form-group full">
        <label>File_URL (link buku)</label>
        <input type="text" name="File_URL"
               value="<?= htmlspecialchars($val('File_URL')) ?>">
      </div>

      <div class="form-group full">
        <label>Penulis (pisahkan koma)</label>
        <input type="text" name="Authors"
               value="<?= htmlspecialchars($editingAuths) ?>">
      </div>

      <div class="form-group full">
        <button type="submit" class="btn-primary">
          <?= $editingBook ? 'Update Buku' : 'Simpan Buku' ?>
        </button>
      </div>
    </form>
  </div>


  <!-- ============================= -->
  <!-- TABEL DAFTAR BUKU -->
  <!-- ============================= -->
  <div class="card">
    <div class="table-header">
      <div class="table-title">Daftar Buku</div>
    </div>

    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Stok</th>
          <th>Penulis</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($b = $booksResult->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($b['Book_ID']) ?></td>
          <td><?= htmlspecialchars($b['Title']) ?></td>
          <td><?= htmlspecialchars($b['Category']) ?></td>
          <td><?= (int)$b['Stock'] ?></td>
          <td><?= htmlspecialchars($authorMap[$b['Book_ID']] ?? '-') ?></td>
          <td>
            <a href="books.php?edit_id=<?= urlencode($b['Book_ID']) ?>" class="btn-ghost" style="margin-right:6px;">Edit</a>

            <form method="post" style="display:inline"
                  onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
              <input type="hidden" name="form_type" value="delete_book">
              <input type="hidden" name="book_id" value="<?= htmlspecialchars($b['Book_ID']) ?>">
              <button type="submit" class="btn-ghost">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>
</body>
</html>
