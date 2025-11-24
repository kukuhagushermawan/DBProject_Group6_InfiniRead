<?php
// frontend/pages/staff/verify_member.php
require_once __DIR__ . '/../../../backend/config/database.php';
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';

requireStaff();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: members.php');
    exit;
}

$mem_id   = (int)($_POST['mem_id'] ?? 0);
$staff_id = (int)($_SESSION['staff_id'] ?? 0);

if ($mem_id <= 0 || $staff_id <= 0) {
    $_SESSION['flash'] = 'Data tidak valid.';
    header('Location: members.php');
    exit;
}

// update status verifikasi + catat staff verifikator
$stmt = $mysqli->prepare("
    UPDATE member
    SET Is_Verified = 1,
        Staff_ID    = ?
    WHERE Mem_ID    = ?
");
$stmt->bind_param('ii', $staff_id, $mem_id);
$ok = $stmt->execute();
$stmt->close();

$_SESSION['flash'] = $ok
    ? 'Member berhasil diverifikasi.'
    : 'Gagal memverifikasi member.';

header('Location: members.php');
exit;
