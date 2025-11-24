<?php
require_once __DIR__ . '/../../../backend/middleware/AuthMiddleware.php';
requireMember();

require_once __DIR__ . '/../../../backend/controllers/BookController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['book_id'])) {
    header('Location: books.php');
    exit;
}

$book_id  = $_POST['book_id'];
$mem_id   = $_SESSION['member_id'];
$staff_id = 1; // sementara hardcode, nanti bisa diubah kalau transaksi diinput lewat halaman staff

$msg = BookController::memberBorrow($book_id, $mem_id, $staff_id);

$_SESSION['flash'] = $msg;
header('Location: books.php');
exit;
