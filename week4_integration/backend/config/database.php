<?php
// backend/config/database.php

// ===== KONFIG DATABASE =====
$DB_HOST = 'sql300.infinityfree.com';
$DB_NAME = 'if0_40486177_infiniread';
$DB_USER = 'if0_40486177';
$DB_PASS = 'PpEdtCgZ0HDFO';
$DB_PORT = 3306;   // port default MySQL di InfinityFree

date_default_timezone_set('Asia/Jakarta');

// koneksi global
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
if ($mysqli->connect_errno) {
    die('Gagal konek database: ' . $mysqli->connect_error);
}

// helper db()
function db(): mysqli {
    // pakai koneksi global
    global $mysqli;
    return $mysqli;
}

// session global
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
