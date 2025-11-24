<?php
require_once __DIR__ . '/../../../backend/config/database.php';
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';

requireStaff();

$staff_id = $_SESSION['staff_id'];   // sesuaikan kalau nama key berbeda
$flash    = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
$error    = '';

// ambil data staff
$stmt = $mysqli->prepare("
    SELECT Staff_ID, Staff_Name, Email, Position
    FROM staff
    WHERE Staff_ID = ?
    LIMIT 1
");
$stmt->bind_param('i', $staff_id);
$stmt->execute();
$res   = $stmt->get_result();
$staff = $res->fetch_assoc();
$stmt->close();

if (!$staff) {
    $error = 'Data staff tidak ditemukan.';
} else {
    $old_name     = $staff['Staff_Name'];
    $old_email    = $staff['Email'];
    $old_position = $staff['Position'];
}

// handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$error) {
    $name     = trim($_POST['staff_name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $position = trim($_POST['position'] ?? '');

    if ($name === '' || $email === '' || $position === '') {
        $error = 'Semua field wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } else {
        $stmt = $mysqli->prepare("
            UPDATE staff
            SET Staff_Name = ?, Email = ?, Position = ?
            WHERE Staff_ID = ?
        ");
        $stmt->bind_param('sssi', $name, $email, $position, $staff_id);
        if ($stmt->execute()) {
            $stmt->close();

            $_SESSION['flash']      = 'Profil staff berhasil diperbarui.';
            $_SESSION['staff_name'] = $name; // supaya navbar ikut ter-update
            header('Location: /frontend/pages/staff/profile.php');
            exit;
        } else {
            $error = 'Gagal menyimpan perubahan. Silakan coba lagi.';
            $stmt->close();
        }
    }

    // kalau ada error, tetap tampilkan nilai yang baru di form
    $old_name     = $name;
    $old_email    = $email;
    $old_position = $position;
}

$active = 'profile';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Staff – InfiniRead</title>

  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <link rel="stylesheet" href="/frontend/assets/css/dashboard.css">

  <style>
    /* NAVBAR – sama seperti halaman member/books */
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

    /* CARD + FORM – mirip profil member */
    .card {
      background: rgba(255, 255, 255, 0.97);
      border-radius: 20px;
      padding: 24px 26px 30px;
      box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
      border: 1px solid rgba(226, 232, 240, 0.9);
    }
    .card-title {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 18px;
      color: #111827;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 16px 24px;
    }
    .form-group {
      display: flex;
      flex-direction: column;
    }
    .form-group.full {
      grid-column: 1 / -1;
    }
    .form-group label {
      font-size: 14px;
      margin-bottom: 6px;
      color: #4b5563;
    }
    .form-group input {
      background: #f4f8ff;
      border: 1px solid #c7d2fe;
      padding: 9px 11px;
      border-radius: 10px;
      font-size: 14px;
      color: #111827;
      outline: none;
    }
    .form-group input:focus {
      border-color: #00c6ff;
      box-shadow: 0 0 0 1px rgba(0, 198, 255, 0.4);
      background: #eef4ff;
    }
    .form-group input[disabled] {
      background: #e5edff;
      color: #6b7280;
      cursor: not-allowed;
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
      transition: transform 0.1s ease, box-shadow 0.1s ease, filter 0.1s ease;
    }
    .btn-primary:hover {
      transform: translateY(-1px);
      filter: brightness(1.04);
      box-shadow: 0 14px 30px rgba(0, 198, 255, 0.4);
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

    @media (max-width: 768px) {
      .form-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../../components/navbar_staff.php'; ?>

<div class="page-wrap">
  <h1 class="page-title">Profil Staff</h1>
  <p class="subtitle">Kelola data akun staff InfiniRead Anda.</p>

  <?php if ($flash): ?>
    <div class="flash success"><?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="flash error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (!$error): ?>
  <div class="card">
    <div class="card-title">Data Profil Staff</div>

    <form method="post" class="form-grid">
      <div class="form-group">
        <label>Staff ID</label>
        <input type="text" value="<?= (int)$staff['Staff_ID'] ?>" disabled>
      </div>

      <div class="form-group">
        <label>Posisi / Jabatan</label>
        <input type="text" name="position"
               value="<?= htmlspecialchars($old_position) ?>" required>
      </div>

      <div class="form-group full">
        <label>Nama Lengkap</label>
        <input type="text" name="staff_name"
               value="<?= htmlspecialchars($old_name) ?>" required>
      </div>

      <div class="form-group full">
        <label>Email</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($old_email) ?>" required>
      </div>

      <div class="form-group full">
        <button type="submit" class="btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
  <?php endif; ?>
</div>

</body>
</html>
