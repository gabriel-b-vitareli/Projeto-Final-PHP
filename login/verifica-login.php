<?php
require_once __DIR__ . '/../includes/config.php';
// Inclua este arquivo no topo (antes de qualquer HTML) das páginas que exigem login.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header('Location: ' . url('login/login.php'));
    exit();
}
