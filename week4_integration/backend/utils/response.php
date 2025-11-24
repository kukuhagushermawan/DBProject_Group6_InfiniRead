<?php
// backend/utils/Response.php

function setFlash(string $message): void {
    $_SESSION['flash'] = $message;
}

function getFlash(): string {
    $msg = $_SESSION['flash'] ?? '';
    unset($_SESSION['flash']);
    return $msg;
}

function redirect(string $path): void {
    header("Location: $path");
    exit;
}
