<?php
// Pedaços de HTML reutilizados em várias páginas.
require_once __DIR__ . '/functions.php';

/* ---------- Mensagens rápidas (aparecem uma vez e somem) ---------- */

function flash($mensagem, $tipo = 'ok')
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash'] = ['msg' => $mensagem, 'tipo' => $tipo];
}

function exibirFlash()
{
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        echo '<p class="flash flash--' . e($f['tipo']) . '" role="status">' . e($f['msg']) . '</p>';
    }
}

/* ---------- Peças do card ---------- */

function htmlCapa($jogo)
{
    $url = capaUrl($jogo);
    if ($url) {
        return '<img src="' . e($url) . '" alt="Capa de ' . e($jogo['titulo']) . '" loading="lazy">';
    }
    return '<span class="cover-fallback">' . e($jogo['titulo']) . '</span>';
}

function htmlPlataformas($jogo)
{
    $out = '<ul class="platforms">';
    foreach (listaPlataformas($jogo) as $p) {
        $classe = (strcasecmp($p, 'Xbox') === 0) ? ' class="x"' : '';
        $out .= '<li' . $classe . '>' . e($p) . '</li>';
    }
    return $out . '</ul>';
}

function htmlNota($jogo, $comTotal = true)
{
    if ($jogo['nota'] === null || $jogo['nota'] === '') {
        return '';
    }
    $nota = number_format((float)$jogo['nota'], 1, '.', '');
    $out = '<svg class="icon fill"><use href="#i-star"/></svg><data value="' . e($nota) . '">' . e($nota) . '</data>';
    if ($comTotal && (int)$jogo['qtd_avaliacoes'] > 0) {
        $out .= ' <span>(' . e(abreviar($jogo['qtd_avaliacoes'])) . ')</span>';
    }
    return $out;
}

function htmlPreco($jogo, $comBadge = true)
{
    $out = '<data value="' . e(number_format((float)$jogo['preco'], 2, '.', '')) . '">' . e(moeda($jogo['preco'])) . '</data>';
    $desc = percentualDesconto($jogo);
    if ($desc > 0) {
        $out .= '<s>' . e(moeda($jogo['preco_original'])) . '</s>';
        if ($comBadge) {
            $out .= '<span class="badge badge--discount">-' . $desc . '%</span>';
        }
    }
    return $out;
}

// Botão de coração: envia um POST para /acoes/favoritos.php
function htmlBotaoFavorito($jogo, $ehFavorito, $classe = 'fav')
{
    $rotulo = $ehFavorito ? 'Remover dos favoritos' : 'Adicionar aos favoritos';
    return '<form method="post" action="/acoes/favoritos.php" class="form-inline">'
        . '<input type="hidden" name="jogo_id" value="' . (int)$jogo['id'] . '">'
        . '<input type="hidden" name="voltar" value="' . e($_SERVER['REQUEST_URI'] ?? '/pages/inicial.php') . '">'
        . '<button class="' . $classe . ($ehFavorito ? ' is-fav' : '') . '" type="submit" aria-label="' . $rotulo . '" title="' . $rotulo . '">'
        . '<svg class="icon' . ($ehFavorito ? ' fill' : '') . '"><use href="#i-heart"/></svg></button></form>';
}

/**
 * Card de jogo (usado na home, loja e favoritos).
 * $compacto = true  -> versão com preço e nota na mesma linha (Novidades)
 */
function cardJogo($jogo, $favoritos = [], $compacto = false)
{
    $id = (int)$jogo['id'];
    $ehFav = in_array($id, $favoritos, true);
    $link = '/pages/jogo.php?id=' . $id;

    echo '<li><article class="card' . ($compacto ? ' card--compact' : '') . '" data-game-id="' . $id . '">';
    echo '<a class="card__cover" href="' . $link . '">' . htmlCapa($jogo) . '</a>';
    if ($compacto && ehLancamento($jogo)) {
        echo '<span class="badge badge--new card__flag">Lançamento</span>';
    }
    echo htmlBotaoFavorito($jogo, $ehFav);
    echo '<div class="card__body">';

    if ($compacto) {
        echo '<h3 class="card__title"><a href="' . $link . '">' . e($jogo['titulo']) . '</a></h3>';
        echo htmlPlataformas($jogo);
        echo '<p class="price">' . htmlPreco($jogo, false)
            . '<span class="rating">' . htmlNota($jogo) . '</span></p>';
    } else {
        echo htmlPlataformas($jogo);
        echo '<h3 class="card__title"><a href="' . $link . '">' . e($jogo['titulo']) . '</a></h3>';
        echo '<p class="rating">' . htmlNota($jogo) . '</p>';
        echo '<p class="price">' . htmlPreco($jogo) . '</p>';
    }

    echo '</div></article></li>';
}
