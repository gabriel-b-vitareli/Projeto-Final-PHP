<?php
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/componentes.php';

$paginaAtual  = 'carrinho';
$tituloPagina = 'Carrinho';

$itens = itensCarrinho($conexao, $_SESSION['id']);
$total = totalCarrinho($itens);

require __DIR__ . '/../includes/header.php';
?>

  <main class="content content--full">
    <div class="content__main">

      <?php exibirFlash(); ?>

      <div>
        <h1 class="pagina-titulo">Meu carrinho</h1>
        <p class="pagina-sub"><?= count($itens) ?> <?= count($itens) === 1 ? 'item' : 'itens' ?></p>
      </div>

      <?php if ($itens): ?>
        <div class="carrinho-lista">
          <?php foreach ($itens as $item): ?>
          <div class="carrinho-linha" data-game-id="<?= (int)$item['id'] ?>">
            <a href="/pages/jogo.php?id=<?= (int)$item['id'] ?>"><?= htmlCapa($item) ?></a>
            <div>
              <h2><a href="/pages/jogo.php?id=<?= (int)$item['id'] ?>"><?= e($item['titulo']) ?></a></h2>
              <?= htmlPlataformas($item) ?>
            </div>
            <data value="<?= e($item['preco']) ?>"><?= e(moeda($item['preco'])) ?></data>
            <form method="post" action="/acoes/carrinho.php" class="form-inline">
              <input type="hidden" name="acao" value="remover">
              <input type="hidden" name="jogo_id" value="<?= (int)$item['id'] ?>">
              <input type="hidden" name="voltar" value="/pages/carrinho.php">
              <button class="carrinho-remover" type="submit" aria-label="Remover <?= e($item['titulo']) ?>"><svg class="icon"><use href="#i-x"/></svg></button>
            </form>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="carrinho-total">
          <div>
            <p class="pagina-sub">Total</p>
            <data value="<?= e(number_format($total, 2, '.', '')) ?>"><?= e(moeda($total)) ?></data>
          </div>
          <div>
            <!-- o pagamento ainda não existe: botão desativado de propósito -->
            <button class="btn btn--primary" type="button" disabled>Finalizar compra</button>
            <p class="aviso">O pagamento ainda não está disponível.</p>
          </div>
        </div>
      <?php else: ?>
        <p class="vazio">Seu carrinho está vazio. <a href="/pages/loja.php">Explorar a loja</a></p>
      <?php endif; ?>
    </div>
  </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
