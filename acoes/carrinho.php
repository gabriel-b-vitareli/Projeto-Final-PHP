<?php
// Adiciona ou remove um jogo do carrinho e volta pra página de origem.
// POST: acao = adicionar | remover, jogo_id, voltar
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/componentes.php';

$voltar = urlSegura($_POST['voltar'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jogo_id'], $_POST['acao'])) {
    $jogoId = (int)$_POST['jogo_id'];

    if ($_POST['acao'] === 'adicionar') {
        if (adicionarCarrinho($conexao, $_SESSION['id'], $jogoId)) {
            flash('Jogo adicionado ao carrinho.');
        } else {
            flash('Esse jogo não existe mais.', 'erro');
        }
    } elseif ($_POST['acao'] === 'remover') {
        removerCarrinho($conexao, $_SESSION['id'], $jogoId);
        flash('Jogo removido do carrinho.');
    }
}

header("Location: $voltar");
exit();
