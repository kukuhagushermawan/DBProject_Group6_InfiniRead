<?php
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';
requireMember();

require_once __DIR__ . '/../../../backend/controllers/BorrowingController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['brw_id'])) {
    header('Location: dashboard.php');
    exit;
}

$brw_id = (int)$_POST['brw_id'];
$mem_id = $_SESSION['member_id'];

$msg = BorrowingController::memberReturn($brw_id, $mem_id);
$_SESSION['flash'] = $msg;

header('Location: dashboard.php');
exit;
