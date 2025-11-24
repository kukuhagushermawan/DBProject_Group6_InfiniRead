<?php
// index.php (root)

require_once __DIR__ . '/backend/config/database.php';

if (!empty($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'member') {
        header('Location: /frontend/pages/member/dashboard.php');
        exit;
    }
    if ($_SESSION['user_type'] === 'staff') {
        header('Location: /frontend/pages/staff/dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>InfiniRead – Pilih Login</title>

  <!-- background gradient & font -->
  <link rel="stylesheet" href="/frontend/assets/css/global.css">
  <!-- tombol gradient, dll -->
  <link rel="stylesheet" href="/frontend/assets/css/components.css">
  <!-- layout card auth-page -->
  <link rel="stylesheet" href="/frontend/assets/css/auth.css">

  <style>
    .chooser-container {
      text-align: center;
    }

    .chooser-title {
      margin: 0 0 6px;
      font-size: 26px;
      font-weight: 700;
      color: #111827;
    }

    .chooser-subtitle {
      font-size: 13px;
      color: #6b7280;
      margin-bottom: 18px;
    }

    /* tiga tombol sejajar */
    .chooser-buttons {
      display: flex;
      justify-content: center;
      gap: 16px;
      margin-top: 8px;
      flex-wrap: wrap;
    }

    .chooser-buttons a {
      text-decoration: none;
    }

    /* layout isi tombol: icon di atas teks */
    .chooser-btn {
      display: inline-flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 6px;
      min-width: 190px;
      text-align: center;
      padding: 10px 18px;
    }

    .chooser-icon {
      font-size: 24px;
      line-height: 1;
    }

    /* pakai style dasar dari components.css, tapi samakan lebar */
    .chooser-buttons .btn-primary,
    .chooser-buttons .btn-secondary,
    .chooser-buttons .btn-link-pill {
      border-radius: 999px;
      font-size: 14px;
      font-weight: 600;
      box-shadow: 0 10px 25px rgba(0, 198, 255, 0.25);
    }

    /* tombol staff: putih (outline) */
    .btn-secondary {
      border: 1px solid #c7d2fe;
      background: #ffffff;
      color: #1f2937;
      transition: background 0.15s, box-shadow 0.15s, transform 0.1s;
    }
    .btn-secondary:hover {
      background: #eef4ff;
      box-shadow: 0 14px 30px rgba(148, 163, 184, 0.45);
      transform: translateY(-1px);
    }

    /* tombol daftar member baru: versi lebih ringan */
    .btn-link-pill {
      border: 1px solid #22c1c3;
      background: #ecfeff;
      color: #0f766e;
      transition: background 0.15s, box-shadow 0.15s, transform 0.1s;
    }
    .btn-link-pill:hover {
      background: #cffafe;
      box-shadow: 0 14px 30px rgba(34, 193, 195, 0.35);
      transform: translateY(-1px);
    }

    /* responsif: kalau layar sempit, boleh turun ke 2/1 kolom */
    @media (max-width: 640px) {
      .chooser-buttons {
        gap: 12px;
      }
      .chooser-btn {
        min-width: 160px;
      }
    }
  </style>
</head>
<body class="auth-page">
  <div class="auth-container chooser-container">
    <h1 class="chooser-title">Selamat datang di InfiniRead</h1>
    <p class="chooser-subtitle">Silakan pilih jenis pengguna untuk login.</p>

    <div class="chooser-buttons">
      <!-- Login Member -->
      <a href="/frontend/pages/auth/login_member.php"
         class="btn-primary chooser-btn">
        <span class="chooser-icon">👤</span>
        <span>Login sebagai Member</span>
      </a>

      <!-- Login Staff -->
      <a href="/frontend/pages/auth/login_staff.php"
         class="btn-secondary chooser-btn">
        <span class="chooser-icon">🧑‍💼</span>
        <span>Login sebagai Staff</span>
      </a>

      <!-- Daftar Member Baru -->
      <a href="/frontend/pages/auth/register_member.php"
         class="btn-link-pill chooser-btn">
        <span class="chooser-icon">✨</span>
        <span>Daftar Member Baru</span>
      </a>
    </div>
  </div>
</body>
</html>
