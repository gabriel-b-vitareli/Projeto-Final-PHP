<?php
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/componentes.php';

$paginaAtual  = 'favoritos';
$tituloPagina = 'Favoritos';

$jogos     = listarFavoritos($conexao, $_SESSION['id']);
$favoritos = array_map(fn($j) => (int)$j['id'], $jogos);

require __DIR__ . '/../includes/header.php';
?>

  <main class="content content--full">
    <div class="content__main">

      <?php exibirFlash(); ?>

      <div>
        <h1 class="pagina-titulo">Favoritos</h1>
        <p class="pagina-sub">Jogos que você marcou para ver depois.</p>
      </div>

      <?php if ($jogos): ?>
        <ul class="grid"><?php foreach ($jogos as $j) cardJogo($j, $favoritos); ?></ul>
      <?php else: ?>
        <p class="vazio">Você ainda não favoritou nenhum jogo. Clique no coração de qualquer jogo na <a href="/pages/loja.php">loja</a>.</p>
      <?php endif; ?>
    </div>
  </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
