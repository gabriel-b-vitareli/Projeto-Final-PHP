<?php
/*
 * Topo padrão das páginas internas (abre <html>, sidebar e barra superior).
 * Antes de incluir, a página define (opcional):
 *   $paginaAtual  -> 'inicio' | 'loja' | 'favoritos' | 'carrinho' | 'admin'
 *   $tituloPagina -> texto da aba do navegador
 *   $buscaAtual   -> texto que já aparece na busca
 * E precisa ter incluído login/verifica-login.php ANTES (ele pode redirecionar).
 */
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/componentes.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuarioId   = (int)($_SESSION['id'] ?? 0);
$nomeUsuario = $usuarioId ? consultarNome($conexao, $usuarioId) : false;

// Sessão de um usuário que não existe mais no banco: sai.
if (!$nomeUsuario) {
    header('Location: ' . url('login/logout.php'));
    exit();
}
$st = $conexao->prepare("SELECT nivel FROM usuarios WHERE id = :id");
$st->execute([':id' => $usuarioId]);
$ehAdmin = ((int)$st->fetchColumn() === 1);
$qtdCarrinho  = count(idsCarrinho($conexao, $usuarioId));
$paginaAtual  = $paginaAtual  ?? '';
$tituloPagina = $tituloPagina ?? 'Gameshelf';
$buscaAtual   = $buscaAtual   ?? '';

function itemMenu($chave, $href, $icone, $texto, $atual, $contador = null)
{
    $ativo = ($chave === $atual);
    echo '<a class="nav__item' . ($ativo ? ' is-active' : '') . '" href="' . $href . '"' . ($ativo ? ' aria-current="page"' : '') . '>'
        . '<svg class="icon' . ($ativo ? ' fill' : '') . '"><use href="#' . $icone . '"/></svg><span>' . $texto . '</span>';
    if ($contador !== null && $contador > 0) {
        echo '<span class="count">' . (int)$contador . '</span>';
    }
    echo '</a>';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($tituloPagina) ?> | Gameshelf</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= url('style/homepage.css') ?>">
  <link rel="stylesheet" href="<?= url('style/app.css') ?>">
  <link rel="shortcut icon" href="<?= url('uploads/favicon.ico') ?>" type="image/x-icon">
</head>
<body>

<?php include __DIR__ . '/icones.php'; ?>

<div class="app">

  <!-- ============ SIDEBAR ============ -->
  <aside class="sidebar">
    <a class="logo" href="<?= url('pages/inicial.php') ?>">
      <img src="<?= url('uploads/banner-maior.png') ?>" alt="Gameshelf" width="450">
    </a>

    <nav class="nav" aria-label="Principal">
      <?php
      itemMenu('inicio',     url('pages/inicial.php'),      'i-home',  'Início',        $paginaAtual);
      itemMenu('loja',       url('pages/loja.php'),         'i-bag',   'Loja',          $paginaAtual);
      itemMenu('favoritos',  url('pages/favoritos.php'),    'i-heart', 'Favoritos',     $paginaAtual);
      itemMenu('carrinho',   url('pages/carrinho.php'),     'i-cart',  'Carrinho',      $paginaAtual, $qtdCarrinho);
      if ($ehAdmin) {
        itemMenu('admin', url('pages/gerenciar-jogos.php'), 'i-crown', 'Gerenciar jogos', $paginaAtual);
      }
      ?>
    </nav>

    <nav class="nav nav--bottom" aria-label="Conta">
      <a class="nav__item" href="<?= url('login/logout.php') ?>"><svg class="icon"><use href="#i-arrow"/></svg><span>Sair</span></a>
    </nav>
  </aside>

  <!-- ============ TOPO ============ -->
  <header class="topbar">
    <form class="search-form" action="<?= url('pages/loja.php') ?>" method="get" role="search">
      <label class="search">
        <svg class="icon"><use href="#i-search"/></svg>
        <input type="search" name="q" value="<?= e($buscaAtual) ?>" placeholder="Buscar por jogos, gêneros, plataformas...">
      </label>
    </form>
    <div class="topbar__actions">
      <span class="user"><img class="user__avatar" src="<?= url('uploads/user-icon.png') ?>" alt=""><span><?= e($nomeUsuario) ?></span></span>
    </div>
  </header>
