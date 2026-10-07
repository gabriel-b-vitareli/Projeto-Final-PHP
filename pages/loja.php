<?php
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/componentes.php';

$paginaAtual  = 'loja';
$tituloPagina = 'Loja';

$plataformas = ['PC', 'PS', 'Xbox', 'Switch'];
$ordens = [
    'relevantes' => 'Mais vendidos',
    'novos'      => 'Lançamentos',
    'nota'       => 'Melhor avaliados',
    'menor'      => 'Menor preço',
    'maior'      => 'Maior preço',
    'nome'       => 'Nome (A-Z)',
];

// Lê os filtros da URL (GET) e valida contra as listas permitidas
$buscaAtual = trim((string)($_GET['q'] ?? ''));
$plataforma = in_array($_GET['plataforma'] ?? '', $plataformas, true) ? $_GET['plataforma'] : '';
$generos    = listarGeneros($conexao);
$genero     = in_array($_GET['genero'] ?? '', $generos, true) ? $_GET['genero'] : '';
$ordem      = array_key_exists($_GET['ordem'] ?? '', $ordens) ? $_GET['ordem'] : 'relevantes';

$jogos = listarJogos($conexao, [
    'q' => $buscaAtual, 'plataforma' => $plataforma, 'genero' => $genero, 'ordem' => $ordem,
]);
$favoritos = idsFavoritos($conexao, $_SESSION['id']);
$filtrando = ($buscaAtual !== '' || $plataforma !== '' || $genero !== '');

require __DIR__ . '/../includes/header.php';
?>

  <main class="content content--full">
    <div class="content__main">

      <?php exibirFlash(); ?>

      <div>
        <h1 class="pagina-titulo">Loja</h1>
        <p class="pagina-sub"><?= count($jogos) ?> <?= count($jogos) === 1 ? 'jogo encontrado' : 'jogos encontrados' ?><?= $buscaAtual !== '' ? ' para "' . e($buscaAtual) . '"' : '' ?></p>
      </div>

      <form class="filtros" method="get" action="/pages/loja.php">
        <label>Busca
          <input type="search" name="q" value="<?= e($buscaAtual) ?>" placeholder="Título, gênero...">
        </label>
        <label>Plataforma
          <select name="plataforma">
            <option value="">Todas</option>
            <?php foreach ($plataformas as $p): ?>
              <option value="<?= e($p) ?>" <?= $p === $plataforma ? 'selected' : '' ?>><?= e($p) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Gênero
          <select name="genero">
            <option value="">Todos</option>
            <?php foreach ($generos as $g): ?>
              <option value="<?= e($g) ?>" <?= $g === $genero ? 'selected' : '' ?>><?= e($g) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Ordenar por
          <select name="ordem">
            <?php foreach ($ordens as $valor => $rotulo): ?>
              <option value="<?= e($valor) ?>" <?= $valor === $ordem ? 'selected' : '' ?>><?= e($rotulo) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <button class="btn btn--primary" type="submit">Filtrar</button>
        <?php if ($filtrando || $ordem !== 'relevantes'): ?>
          <a class="btn btn--ghost" href="/pages/loja.php">Limpar</a>
        <?php endif; ?>
      </form>

      <?php if ($jogos): ?>
        <ul class="grid"><?php foreach ($jogos as $j) cardJogo($j, $favoritos); ?></ul>
      <?php else: ?>
        <p class="vazio">Nenhum jogo encontrado com esses filtros.</p>
      <?php endif; ?>
    </div>
  </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
