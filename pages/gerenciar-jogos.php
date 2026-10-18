<?php
require_once __DIR__ . '/../includes/admin-nivel1.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
        flash('Sessão expirada. Atualize a página e tente novamente.', 'erro');
        header('Location: /pages/gerenciar-jogos.php');
        exit();
    }
    $id = filter_input(INPUT_POST, 'jogo_id', FILTER_VALIDATE_INT);
    $jogo = $id ? buscarJogo($conexao, $id) : false;
    if (!$jogo) {
        flash('Jogo não encontrado.', 'erro');
    } else {
        try {
            $stmt = $conexao->prepare('DELETE FROM jogos WHERE id = :id');
            $stmt->execute([':id' => $id]);
            foreach (['capa' => 'capas', 'logo' => 'logos', 'hero' => 'heros'] as $campo => $pasta) {
                $arquivo = basename((string)($jogo[$campo] ?? ''));
                $caminho = __DIR__ . '/../uploads/' . $pasta . '/' . $arquivo;
                if ($arquivo !== '' && !preg_match('#^https?://#i', (string)($jogo[$campo] ?? '')) && is_file($caminho)) @unlink($caminho);
            }
            flash('Jogo excluído com sucesso.');
        } catch (Throwable $e) {
            flash('Não foi possível excluir o jogo.', 'erro');
        }
    }
    header('Location: /pages/gerenciar-jogos.php');
    exit();
}

$jogos = listarJogos($conexao, ['ordem' => 'nome']);
$paginaAtual = 'admin';
$tituloPagina = 'Gerenciar jogos';
require __DIR__ . '/../includes/header.php';
?>
<main class="content content--full"><div class="content__main">
<?php exibirFlash(); ?>
<div class="admin-heading"><div><h1 class="pagina-titulo">Gerenciar jogos</h1><p class="pagina-sub">Edite ou exclua jogos cadastrados. Acesso restrito a administradores de nível 1.</p></div><a class="btn btn--primary" href="/pages/cadastrar-game.php">Cadastrar jogo</a></div>
<?php if ($jogos): ?>
<div class="admin-games">
<?php foreach ($jogos as $j): ?>
<article class="admin-game">
<div class="admin-game__cover"><?= htmlCapa($j) ?></div>
<div class="admin-game__info"><h2><?= e($j['titulo']) ?></h2><p><?= e($j['genero'] ?: 'Sem gênero') ?> · <?= e(implode(', ', listaPlataformas($j))) ?> · <?= e(moeda($j['preco'])) ?></p></div>
<div class="admin-game__actions"><a class="btn btn--ghost" href="/pages/editar-jogo.php?id=<?= (int)$j['id'] ?>">Editar</a>
<form method="post" onsubmit="return confirm('Tem certeza que deseja excluir este jogo? Esta ação não pode ser desfeita.');"><input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>"><input type="hidden" name="jogo_id" value="<?= (int)$j['id'] ?>"><button class="btn btn--danger" type="submit">Excluir</button></form></div>
</article>
<?php endforeach; ?>
</div>
<?php else: ?><p class="vazio">Nenhum jogo cadastrado.</p><?php endif; ?>
</div></main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
