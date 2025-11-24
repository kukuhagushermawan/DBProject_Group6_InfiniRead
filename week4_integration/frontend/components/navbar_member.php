<?php
// frontend/components/navbar_member.php
?>
<div class="topbar">
  <div class="brand">InfiniRead</div>
  <div class="menu-right">
    <a href="/frontend/pages/member/dashboard.php" class="<?= $active === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
    <a href="/frontend/pages/member/books.php" class="<?= $active === 'books' ? 'active' : '' ?>">Lihat &amp; Pinjam Buku</a>
    <a href="/frontend/pages/member/profile.php" class="<?= $active === 'profile' ? 'active' : '' ?>">Profil</a>
    <a href="/logout.php">Logout</a>
  </div>
</div>
