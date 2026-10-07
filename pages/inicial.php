<?php
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/componentes.php';

$paginaAtual  = 'inicio';
$tituloPagina = 'Início';

$destaque     = jogoDestaque($conexao);
$emAlta       = jogosEmAlta($conexao, 5);
$novidades    = jogosNovidades($conexao, 5);
$maisVendidos = jogosMaisVendidos($conexao, 5);
$favoritos    = idsFavoritos($conexao, $_SESSION['id']);
$carrinho     = itensCarrinho($conexao, $_SESSION['id']);

require __DIR__ . '/../includes/header.php';
?>

  <main class="content">
    <div class="content__main">

      <?php exibirFlash(); ?>

      <!-- Destaque -->
      <?php if ($destaque): ?>
      <?php $heroImg = heroUrl($destaque); $logoImg = logoUrl($destaque); ?>
      <section class="hero" aria-label="Destaque">
        <?php if ($heroImg): ?>
          <img class="hero__bg" src="<?= e($heroImg) ?>" alt="">
        <?php endif; ?>
        <div class="hero__body">
          <h1 class="hero__title<?= $logoImg ? ' hero__title--logo' : '' ?>">
            <?php if ($logoImg): ?>
              <img class="hero__logo" src="<?= e($logoImg) ?>" alt="<?= e($destaque['titulo']) ?>">
            <?php else: ?>
              <?= e($destaque['titulo']) ?>
            <?php endif; ?>
            <small><?= e($destaque['desenvolvedora']) ?></small>
          </h1>
          <p class="hero__desc"><?= e($destaque['descricao']) ?></p>
          <p class="hero__price"><?= htmlPreco($destaque, false) ?></p>
          <div class="hero__actions">
            <a class="btn btn--primary" href="/pages/jogo.php?id=<?= (int)$destaque['id'] ?>">Ver jogo</a>
            <form method="post" action="/acoes/carrinho.php" class="form-inline">
              <input type="hidden" name="acao" value="adicionar">
              <input type="hidden" name="jogo_id" value="<?= (int)$destaque['id'] ?>">
              <input type="hidden" name="voltar" value="/pages/inicial.php">
              <button class="btn btn--ghost" type="submit"><svg class="icon"><use href="#i-cart"/></svg>Adicionar ao carrinho</button>
            </form>
          </div>
        </div>
      </section>
      <?php endif; ?>

      <!-- Em alta agora -->
      <section class="section">
        <header class="section__head">
          <svg class="icon section__icon"><use href="#i-flame"/></svg>
          <div><h2>Em alta agora</h2><p>Os jogos em promoção que mais vendem.</p></div>
          <a class="link" href="/pages/loja.php">Ver todos <svg class="icon"><use href="#i-arrow"/></svg></a>
        </header>
        <?php if ($emAlta): ?>
          <ul class="grid"><?php foreach ($emAlta as $j) cardJogo($j, $favoritos); ?></ul>
        <?php else: ?>
          <p class="vazio">Nenhum jogo em promoção no momento.</p>
        <?php endif; ?>
      </section>

      <!-- Novidades -->
      <section class="section">
        <header class="section__head">
          <svg class="icon section__icon"><use href="#i-star"/></svg>
          <div><h2>Novidades na loja</h2><p>Lançamentos e jogos recentes para você.</p></div>
          <a class="link" href="/pages/loja.php?ordem=novos">Ver todos <svg class="icon"><use href="#i-arrow"/></svg></a>
        </header>
        <?php if ($novidades): ?>
          <ul class="grid"><?php foreach ($novidades as $j) cardJogo($j, $favoritos, true); ?></ul>
        <?php else: ?>
          <p class="vazio">Ainda não há jogos cadastrados.</p>
        <?php endif; ?>
      </section>
    </div>

    <!-- ============ COLUNA DIREITA ============ -->
    <aside class="content__side">

      <!-- Carrinho -->
      <section class="panel">
        <h2 class="panel__title"><svg class="icon"><use href="#i-cart"/></svg>Meu carrinho <span class="count"><?= count($carrinho) ?></span></h2>
        <?php if ($carrinho): ?>
          <ul class="cart">
            <?php foreach ($carrinho as $item): ?>
            <li class="cart__item" data-game-id="<?= (int)$item['id'] ?>">
              <a href="/pages/jogo.php?id=<?= (int)$item['id'] ?>" class="cart__thumb"><?= htmlCapa($item) ?></a>
              <div><h3><?= e($item['titulo']) ?></h3><data value="<?= e($item['preco']) ?>"><?= e(moeda($item['preco'])) ?></data></div>
              <form method="post" action="/acoes/carrinho.php" class="form-inline">
                <input type="hidden" name="acao" value="remover">
                <input type="hidden" name="jogo_id" value="<?= (int)$item['id'] ?>">
                <input type="hidden" name="voltar" value="/pages/inicial.php">
                <button type="submit" aria-label="Remover <?= e($item['titulo']) ?>"><svg class="icon"><use href="#i-x"/></svg></button>
              </form>
            </li>
            <?php endforeach; ?>
          </ul>
          <a class="btn btn--primary btn--block" href="/pages/carrinho.php">Ver carrinho <svg class="icon"><use href="#i-arrow"/></svg></a>
        <?php else: ?>
          <p class="vazio">Seu carrinho está vazio. <a href="/pages/loja.php">Explorar a loja</a></p>
        <?php endif; ?>
      </section>

      <!-- Mais vendidos -->
      <section class="panel">
        <h2 class="panel__title"><svg class="icon"><use href="#i-trophy"/></svg>Mais vendidos</h2>
        <ol class="rank">
          <?php foreach ($maisVendidos as $i => $j): ?>
          <li class="rank__item" data-game-id="<?= (int)$j['id'] ?>">
            <span class="rank__pos"><?= $i + 1 ?></span>
            <a href="/pages/jogo.php?id=<?= (int)$j['id'] ?>" class="cart__thumb"><?= htmlCapa($j) ?></a>
            <div><h3><?= e($j['titulo']) ?></h3><data value="<?= e($j['preco']) ?>"><?= e(moeda($j['preco'])) ?></data><p class="rating"><?= htmlNota($j, false) ?></p></div>
          </li>
          <?php endforeach; ?>
        </ol>
      </section>
    </aside>
  </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>