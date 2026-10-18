<?php
// Recebe o clique no coração, alterna o favorito e volta pra página de origem.
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/componentes.php';

$voltar = urlSegura($_POST['voltar'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jogo_id'])) {
    $jogoId = (int)$_POST['jogo_id'];
    if (buscarJogo($conexao, $jogoId)) {
        alternarFavorito($conexao, $_SESSION['id'], $jogoId);
    }
}

header("Location: $voltar");
exit();
