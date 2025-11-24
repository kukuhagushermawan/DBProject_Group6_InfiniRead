<?php
require_once __DIR__ . '/../../../backend/controllers/AuthController.php';
require_once __DIR__ . '/../../../backend/models/Province.php';

$error   = '';
$success = '';

$provResult = Province::all();

// sticky value
$old_full_name = $_POST['full_name']    ?? '';
$old_email     = $_POST['email']        ?? '';
$old_gender    = $_POST['gender']       ?? '';
$old_dob       = $_POST['dob']          ?? '';
$old_prov_id   = $_POST['province_id']  ?? '';
$old_city_id   = $_POST['city_id']      ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$error, $success] = AuthController::handleRegister($_POST);
    if ($success) {
        $old_full_name = $old_email = $old_gender =
        $old_dob       = $old_prov_id = $old_city_id = '';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register – InfiniRead</title>
  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <link rel="stylesheet" href="/frontend/assets/css/components.css">
  <link rel="stylesheet" href="/frontend/assets/css/auth.css">
  <script src="/frontend/assets/js/location.js" defer></script>
</head>
<body class="auth-page">
<div class="auth-container">
  <h1>Registrasi Member</h1>
  <div class="auth-subtitle">Buat akun InfiniRead untuk mulai meminjam buku.</div>

  <?php if ($error): ?>
    <div class="auth-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="auth-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="post" id="registerForm">

    <label>Nama Lengkap
      <input type="text" name="full_name"
             value="<?= htmlspecialchars($old_full_name) ?>" required>
    </label>

    <label>Email
      <input type="email" name="email"
             value="<?= htmlspecialchars($old_email) ?>" required>
    </label>

    <label>Gender
      <select name="gender" required>
        <option value="">Pilih</option>
        <option value="Man"   <?= $old_gender === 'Man'   ? 'selected' : '' ?>>Man</option>
        <option value="Woman" <?= $old_gender === 'Woman' ? 'selected' : '' ?>>Woman</option>
      </select>
    </label>

    <label>Tanggal Lahir
      <input type="date" name="dob"
             value="<?= htmlspecialchars($old_dob) ?>" required>
    </label>

    <label>Province
      <select name="province_id" id="province" required>
        <option value="">Pilih Province</option>
        <?php while ($p = $provResult->fetch_assoc()): ?>
          <option value="<?= $p['Province_ID']; ?>"
            <?= $old_prov_id == $p['Province_ID'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['Province_Name']); ?>
          </option>
        <?php endwhile; ?>
      </select>
    </label>

    <label>City
      <select name="city_id" id="city" required>
        <option value="">Pilih Province terlebih dahulu</option>
      </select>
    </label>

    <label>Password
      <input type="password" name="password" required>
    </label>

    <label>Konfirmasi Password
      <input type="password" name="password_confirm" required>
    </label>

    <button type="submit" class="btn-primary">Daftar</button>
  </form>

  <div class="bottom-link">
    Sudah punya akun? <a href="/frontend/pages/auth/login_member.php">Login</a>
  </div>
</div>

<script>
  window._oldProvince = '<?= addslashes($old_prov_id) ?>';
  window._oldCity     = '<?= addslashes($old_city_id) ?>';
</script>
</body>
</html>
