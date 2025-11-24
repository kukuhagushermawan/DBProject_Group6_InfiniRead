<?php
require_once __DIR__ . '/../../../backend/controllers/AuthController.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // loginMember akan mengembalikan string error jika gagal
    $error = AuthController::loginMember() ?? '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Member – InfiniRead</title>
  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <link rel="stylesheet" href="/frontend/assets/css/components.css">
  <link rel="stylesheet" href="/frontend/assets/css/auth.css">
</head>
<body class="auth-page">
  <div class="auth-container">
    <h1>Login Member</h1>

    <?php if ($error): ?>
      <div class="auth-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <label>Email</label>
      <input type="email" name="email" required>

      <label>Password</label>
      <input type="password" name="password" required>

      <button type="submit" class="btn-primary">Login</button>
    </form>

    <p class="bottom-link">
      Belum punya akun? <a href="/frontend/pages/auth/register_member.php">Registrasi</a>
    </p>

    <p class="bottom-link">
      Login sebagai staff? <a href="/frontend/pages/auth/login_staff.php">Klik di sini</a>
    </p>
  </div>
</body>
</html>
