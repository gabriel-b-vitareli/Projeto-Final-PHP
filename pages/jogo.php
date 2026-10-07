<?php
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/componentes.php';

$jogo = buscarJogo($conexao, (int)($_GET['id'] ?? 0));
if (!$jogo) {
    flash('Jogo não encontrado.', 'erro');
    header("Location: /pages/loja.php");
    exit();
}

$paginaAtual  = 'loja';
$tituloPagina = $jogo['titulo'];

$ehFavorito = in_array((int)$jogo['id'], idsFavoritos($conexao, $_SESSION['id']), true);
$noCarrinho = in_array((int)$jogo['id'], idsCarrinho($conexao, $_SESSION['id']), true);
$desconto   = percentualDesconto($jogo);
$classificacao = ((int)$jogo['idade'] > 0) ? $jogo['idade'] . '+' : 'Livre';

require __DIR__ . '/../includes/header.php';
?>

  <main class="content content--full">
    <div class="content__main">

      <?php exibirFlash(); ?>

      <p><a class="link" style="margin-left:0" href="/pages/loja.php">&larr; Voltar para a loja</a></p>

      <article class="jogo" data-game-id="<?= (int)$jogo['id'] ?>">
        <div class="jogo__capa"><?= htmlCapa($jogo) ?></div>

        <div class="jogo__info">
          <div>
            <?= htmlPlataformas($jogo) ?>
            <h1 class="jogo__titulo"><?= e($jogo['titulo']) ?></h1>
            <p class="rating"><?= htmlNota($jogo) ?></p>
          </div>

          <p class="jogo__desc"><?= nl2br(e($jogo['descricao'] ?: 'Este jogo ainda não tem descrição.')) ?></p>

          <dl class="jogo__meta">
            <div><dt>Gênero</dt><dd><?= e($jogo['genero'] ?: '-') ?></dd></div>
            <div><dt>Desenvolvedora</dt><dd><?= e($jogo['desenvolvedora'] ?: '-') ?></dd></div>
            <div><dt>Lançamento</dt><dd><?= e(date('d/m/Y', strtotime($jogo['lancamento']))) ?></dd></div>
            <div><dt>Classificação</dt><dd><?= e($classificacao) ?></dd></div>
          </dl>

          <div class="jogo__compra">
            <p class="jogo__preco">
              <?= htmlPreco($jogo, false) ?>
              <?php if ($desconto > 0): ?><span class="badge badge--discount">-<?= $desconto ?>%</span><?php endif; ?>
            </p>

            <?php if ($noCarrinho): ?>
              <a class="btn btn--primary" href="/pages/carrinho.php"><svg class="icon"><use href="#i-cart"/></svg>Já está no carrinho</a>
            <?php else: ?>
              <form method="post" action="/acoes/carrinho.php" class="form-inline">
                <input type="hidden" name="acao" value="adicionar">
                <input type="hidden" name="jogo_id" value="<?= (int)$jogo['id'] ?>">
                <input type="hidden" name="voltar" value="<?= e($_SERVER['REQUEST_URI']) ?>">
                <button class="btn btn--primary" type="submit"><svg class="icon"><use href="#i-cart"/></svg>Adicionar ao carrinho</button>
              </form>
            <?php endif; ?>

            <?= htmlBotaoFavorito($jogo, $ehFavorito, 'btn btn--ghost btn--fav') ?>
          </div>
        </div>
      </article>
    </div>
  </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
