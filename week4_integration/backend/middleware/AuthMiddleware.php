<?php
// backend/middleware/AuthMiddleware.php

require_once __DIR__ . '/../config/database.php';

function requireMember(): void {
    if (empty($_SESSION['user_type']) || $_SESSION['user_type'] !== 'member') {
        header('Location: /index.php');
        exit;
    }
}

function requireStaff(): void {
    if (empty($_SESSION['user_type']) || $_SESSION['user_type'] !== 'staff') {
        header('Location: /index.php');
        exit;
    }
}
