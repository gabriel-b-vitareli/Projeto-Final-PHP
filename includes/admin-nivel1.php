<?php
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/componentes.php';

$stAdmin = $conexao->prepare('SELECT nivel FROM usuarios WHERE id = :id');
$stAdmin->execute([':id' => (int)($_SESSION['id'] ?? 0)]);
if ((int)$stAdmin->fetchColumn() !== 1) {
    http_response_code(404);
    echo '<!DOCTYPE html><html lang="pt-BR"><meta charset="UTF-8"><title>404</title><h1>Não encontrado</h1>';
    exit();
}
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
