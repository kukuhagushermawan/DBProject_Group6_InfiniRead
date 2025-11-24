<?php
// frontend/components/navbar_staff.php
// $active = 'dashboard' | 'books' | 'borrowings' | 'members';
?>
<div class="topbar">
  <div class="brand">InfiniRead – Staff</div>
  <div class="menu-right">
    <a href="/frontend/pages/staff/dashboard.php"  class="<?= $active === 'dashboard'   ? 'active' : '' ?>">Dashboard</a>
    <a href="/frontend/pages/staff/books.php"      class="<?= $active === 'books'       ? 'active' : '' ?>">Kelola Buku</a>
    <a href="/frontend/pages/staff/borrowings.php" class="<?= $active === 'borrowings'  ? 'active' : '' ?>">Peminjaman</a>
    <a href="/frontend/pages/staff/members.php"    class="<?= $active === 'members'     ? 'active' : '' ?>">Member</a>
    <a href="/logout.php">Logout</a>
  </div>
</div>
