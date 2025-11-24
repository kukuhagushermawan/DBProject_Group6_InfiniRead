<?php
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../../backend/controllers/MemberController.php';
require_once __DIR__ . '/../../../backend/models/Province.php';
require_once __DIR__ . '/../../../backend/utils/response.php';

requireMember(); // fungsi VALID di AuthMiddleware.php

$mem_id = $_SESSION['member_id'];
$flash  = getFlash();
$error  = '';

// ambil data profil dari controller
$member     = MemberController::getProfile($mem_id);
$provResult = Province::all();

$old_full_name = $member['Full_Name'];
$old_email     = $member['Email'];
$old_gender    = $member['Gender'];
$old_dob       = $member['Date_of_Birth'];
$old_prov_id   = $member['Province_ID'];
$old_city_id   = $member['City_ID'];

// teks untuk field staff verifikator (ID: X – Nama)
$staffDisplay = '-';
if (!empty($member['Staff_ID']) && !empty($member['Staff_Name'])) {
    $staffDisplay = 'ID: ' . $member['Staff_ID'] . ' – ' . $member['Staff_Name'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = MemberController::updateProfile($mem_id, $_POST);
    // kalau sukses, fungsi di atas sudah redirect & exit
}

$active = 'profile';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Member – InfiniRead</title>

  <!-- CSS global + layout -->
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
    .card-title {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 18px;
      color: #111827;
    }

    /* GRID FORM 2 kolom */
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
    .form-group input,
    .form-group select {
      background: #f4f8ff;
      border: 1px solid #c7d2fe;
      padding: 9px 11px;
      border-radius: 10px;
      font-size: 14px;
      color: #111827;
      outline: none;
    }
    .form-group input:focus,
    .form-group select:focus {
      border-color: #00c6ff;
      box-shadow: 0 0 0 1px rgba(0, 198, 255, 0.4);
      background: #eef4ff;
    }

    .form-group input[disabled] {
      background: #e5edff;
      color: #6b7280;
      cursor: not-allowed;
    }

    /* BUTTON & FLASH */
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
      .page-wrap { padding: 24px 16px 32px; }
      .form-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../../components/navbar_member.php'; ?>

<div class="page-wrap">
  <h1 class="page-title">Profil Member</h1>
  <p class="subtitle">Kelola data akun dan informasi domisili Anda.</p>

  <?php if ($flash): ?>
    <div class="flash success"><?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="flash error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <div class="card">
    <div class="card-title">Data Profil</div>

    <form method="post" class="form-grid">
      <!-- MEMBER ID & STAFF (read-only) -->
      <div class="form-group">
        <label>Member ID</label>
        <input type="text" value="<?= (int)$member['Mem_ID'] ?>" disabled>
      </div>

      <div class="form-group">
        <label>Staff yang memverifikasi</label>
        <input type="text" value="<?= htmlspecialchars($staffDisplay) ?>" disabled>
      </div>

      <!-- NAMA LENGKAP -->
      <div class="form-group full">
        <label>Nama Lengkap</label>
        <input type="text" name="full_name"
               value="<?= htmlspecialchars($old_full_name) ?>" required>
      </div>

      <!-- EMAIL & GENDER -->
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($old_email) ?>" required>
      </div>

      <div class="form-group">
        <label>Gender</label>
        <select name="gender" required>
          <option value="">Pilih</option>
          <option value="Man"   <?= $old_gender === 'Man'   ? 'selected' : '' ?>>Man</option>
          <option value="Woman" <?= $old_gender === 'Woman' ? 'selected' : '' ?>>Woman</option>
        </select>
      </div>

      <!-- TANGGAL LAHIR & PROVINCE -->
      <div class="form-group">
        <label>Tanggal Lahir</label>
        <input type="date" name="dob"
               value="<?= htmlspecialchars($old_dob) ?>" required>
      </div>

      <div class="form-group">
        <label>Province</label>
        <select name="province_id" id="province" required>
          <option value="">Pilih Province</option>
          <?php while ($p = $provResult->fetch_assoc()): ?>
            <option value="<?= $p['Province_ID']; ?>"
              <?= (int)$old_prov_id === (int)$p['Province_ID'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($p['Province_Name']); ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <!-- CITY -->
      <div class="form-group full">
        <label>City</label>
        <select name="city_id" id="city" required>
          <option value="">Memuat data city...</option>
        </select>
      </div>

      <!-- BUTTON -->
      <div class="form-group full">
        <button type="submit" class="btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- set nilai awal untuk dipakai di location.js -->
<script>
  window._oldProvince = '<?= addslashes((string)$old_prov_id) ?>';
  window._oldCity     = '<?= addslashes((string)$old_city_id) ?>';
</script>
<!-- PENTING: ini yang tadinya hilang -->
<script src="/frontend/assets/js/location.js" defer></script>

</body>
</html>
