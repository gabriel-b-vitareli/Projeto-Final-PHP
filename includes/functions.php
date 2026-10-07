<?php
require_once __DIR__ . '/conexao.php';

/* =========================================================
   Helpers de exibição
   ========================================================= */

// Escapa texto antes de mostrar na tela (protege contra XSS).
function e($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function moeda($valor)
{
    return 'R$ ' . number_format((float)$valor, 2, ',', '.');
}

// 12400 -> "12.4k"
function abreviar($n)
{
    $n = (int)$n;
    return $n >= 1000 ? number_format($n / 1000, 1, '.', '') . 'k' : (string)$n;
}

function percentualDesconto($jogo)
{
    $original = (float)($jogo['preco_original'] ?? 0);
    $preco = (float)$jogo['preco'];
    if ($original > $preco && $original > 0) {
        return (int)round((1 - $preco / $original) * 100);
    }
    return 0;
}

function ehLancamento($jogo)
{
    return strtotime($jogo['lancamento']) >= strtotime('-90 days');
}

function listaPlataformas($jogo)
{
    $lista = array_filter(array_map('trim', explode(',', (string)$jogo['plataforma'])));
    return array_values($lista);
}

// Devolve a URL de uma imagem do jogo (capa, logo ou hero), ou null se não houver.
// $pasta é a subpasta dentro de uploads/ (capas, logos, heros).
function imagemUrl($valor, $pasta)
{
    $valor = trim((string)$valor);
    if ($valor === '') {
        return null;
    }
    if (preg_match('#^https?://#i', $valor)) {
        return $valor;
    }
    return '/uploads/' . $pasta . '/' . rawurlencode(basename($valor));
}

function capaUrl($jogo)
{
    return imagemUrl($jogo['capa'] ?? '', 'capas');
}

function logoUrl($jogo)
{
    return imagemUrl($jogo['logo'] ?? '', 'logos');
}

function heroUrl($jogo)
{
    return imagemUrl($jogo['hero'] ?? '', 'heros');
}

// Só deixa redirecionar para caminhos internos do próprio site.
function urlSegura($url, $padrao = '/pages/inicial.php')
{
    if (is_string($url) && strlen($url) > 1 && $url[0] === '/' && $url[1] !== '/' && strpos($url, "\\") === false) {
        return $url;
    }
    return $padrao;
}

/* =========================================================
   Usuários
   ========================================================= */

function usuarioExiste($conexao, $usuario)
{
    $stmt = $conexao->prepare("SELECT 1 FROM usuarios WHERE LOWER(usuario) = LOWER(:usuario)");
    $stmt->bindValue(":usuario", $usuario);
    $stmt->execute();
    return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
}

function cadastrarUsuario($conexao, $usuario, $senha)
{
    $sql = "INSERT INTO usuarios (usuario, senha) VALUES (:usuario, :senha)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":usuario", $usuario);
    $stmt->bindValue(":senha", password_hash($senha, PASSWORD_DEFAULT));
    $stmt->execute();
}

function consultarUsuario($conexao, $usuario)
{
    $sql = "SELECT id, usuario, senha, nivel FROM usuarios WHERE LOWER(usuario) = LOWER(:usuario)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":usuario", $usuario);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function consultarNome($conexao, $id)
{
    $stmt = $conexao->prepare("SELECT usuario FROM usuarios WHERE id = :id");
    $stmt->bindValue(":id", (int)$id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['usuario'] : false;
}

// Confere a senha. Contas antigas (senha em texto puro) ainda entram
// uma última vez e já são convertidas para hash automaticamente.
function verificarSenha($conexao, $usuarioRow, $senhaDigitada)
{
    $guardada = (string)$usuarioRow['senha'];
    $info = password_get_info($guardada);

    if ($info['algo'] !== null && $info['algo'] !== 0) {
        $ok = password_verify($senhaDigitada, $guardada);
        if ($ok && password_needs_rehash($guardada, PASSWORD_DEFAULT)) {
            atualizarHashSenha($conexao, $usuarioRow['id'], $senhaDigitada);
        }
        return $ok;
    }

    if (hash_equals($guardada, $senhaDigitada)) {
        atualizarHashSenha($conexao, $usuarioRow['id'], $senhaDigitada);
        return true;
    }
    return false;
}

function atualizarHashSenha($conexao, $id, $senha)
{
    $stmt = $conexao->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
    $stmt->bindValue(":senha", password_hash($senha, PASSWORD_DEFAULT));
    $stmt->bindValue(":id", (int)$id, PDO::PARAM_INT);
    $stmt->execute();
}

/* =========================================================
   Jogos
   ========================================================= */

function buscarJogo($conexao, $id)
{
    $stmt = $conexao->prepare("SELECT * FROM jogos WHERE id = :id");
    $stmt->bindValue(":id", (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Lista jogos com busca, filtros e ordenação.
 * $f aceita: q, plataforma, genero, ordem, limite
 */
function listarJogos($conexao, $f = [])
{
    $where = [];
    $params = [];

    $q = trim((string)($f['q'] ?? ''));
    if ($q !== '') {
        // LOWER() no próprio SQL: a busca ignora maiúsculas/minúsculas sem depender de extensão do PHP.
        $like = '%' . $q . '%';
        $where[] = "(LOWER(titulo) LIKE LOWER(:q1) OR LOWER(genero) LIKE LOWER(:q2) OR LOWER(desenvolvedora) LIKE LOWER(:q3) OR LOWER(plataforma) LIKE LOWER(:q4))";
        $params[':q1'] = $params[':q2'] = $params[':q3'] = $params[':q4'] = $like;
    }

    if (!empty($f['plataforma'])) {
        $where[] = "(',' || plataforma || ',') LIKE :plat";
        $params[':plat'] = '%,' . $f['plataforma'] . ',%';
    }

    if (!empty($f['genero'])) {
        $where[] = "genero = :genero";
        $params[':genero'] = $f['genero'];
    }

    // A ordenação vem de uma lista fixa: nunca coloque texto do usuário direto no ORDER BY.
    $ordens = [
        'relevantes' => 'vendas DESC, titulo ASC',
        'novos'      => 'lancamento DESC, titulo ASC',
        'nota'       => 'nota DESC, qtd_avaliacoes DESC',
        'menor'      => 'preco ASC, titulo ASC',
        'maior'      => 'preco DESC, titulo ASC',
        'nome'       => 'titulo ASC',
    ];
    $ordem = $ordens[$f['ordem'] ?? 'relevantes'] ?? $ordens['relevantes'];

    $sql = "SELECT * FROM jogos";
    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " ORDER BY $ordem";
    if (!empty($f['limite'])) {
        $sql .= " LIMIT " . (int)$f['limite'];
    }

    $stmt = $conexao->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function jogoDestaque($conexao)
{
    $stmt = $conexao->query("SELECT * FROM jogos WHERE destaque = TRUE ORDER BY lancamento DESC LIMIT 1");
    $jogo = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($jogo) {
        return $jogo;
    }
    // sem nenhum marcado como destaque: usa o mais vendido
    $stmt = $conexao->query("SELECT * FROM jogos ORDER BY vendas DESC LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// "Em alta": jogos em promoção, dos mais vendidos pro menos.
function jogosEmAlta($conexao, $limite = 5)
{
    $sql = "SELECT * FROM jogos WHERE preco_original > preco ORDER BY vendas DESC LIMIT " . (int)$limite;
    return $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function jogosNovidades($conexao, $limite = 5)
{
    return listarJogos($conexao, ['ordem' => 'novos', 'limite' => $limite]);
}

function jogosMaisVendidos($conexao, $limite = 5)
{
    return listarJogos($conexao, ['ordem' => 'relevantes', 'limite' => $limite]);
}

function listarGeneros($conexao)
{
    $stmt = $conexao->query("SELECT DISTINCT genero FROM jogos WHERE genero IS NOT NULL AND genero <> '' ORDER BY genero");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

/* =========================================================
   Favoritos
   ========================================================= */

function idsFavoritos($conexao, $usuarioId)
{
    $stmt = $conexao->prepare("SELECT jogo_id FROM favoritos WHERE usuario_id = :u");
    $stmt->bindValue(":u", (int)$usuarioId, PDO::PARAM_INT);
    $stmt->execute();
    return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
}

function listarFavoritos($conexao, $usuarioId)
{
    $sql = "SELECT j.* FROM jogos j
            JOIN favoritos f ON f.jogo_id = j.id
            WHERE f.usuario_id = :u
            ORDER BY f.criado_em DESC";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":u", (int)$usuarioId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Se já é favorito, remove; se não é, adiciona.
function alternarFavorito($conexao, $usuarioId, $jogoId)
{
    $stmt = $conexao->prepare("SELECT 1 FROM favoritos WHERE usuario_id = :u AND jogo_id = :j");
    $stmt->execute([':u' => (int)$usuarioId, ':j' => (int)$jogoId]);

    if ($stmt->fetch()) {
        $sql = "DELETE FROM favoritos WHERE usuario_id = :u AND jogo_id = :j";
    } else {
        $sql = "INSERT INTO favoritos (usuario_id, jogo_id) VALUES (:u, :j)";
    }
    $conexao->prepare($sql)->execute([':u' => (int)$usuarioId, ':j' => (int)$jogoId]);
}

/* =========================================================
   Carrinho (jogo digital: um de cada, sem quantidade)
   ========================================================= */

function itensCarrinho($conexao, $usuarioId)
{
    $sql = "SELECT j.* FROM jogos j
            JOIN carrinho c ON c.jogo_id = j.id
            WHERE c.usuario_id = :u
            ORDER BY c.criado_em ASC, j.id ASC";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":u", (int)$usuarioId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function totalCarrinho($itens)
{
    $total = 0.0;
    foreach ($itens as $item) {
        $total += (float)$item['preco'];
    }
    return $total;
}

function adicionarCarrinho($conexao, $usuarioId, $jogoId)
{
    if (!buscarJogo($conexao, $jogoId)) {
        return false;
    }
    $stmt = $conexao->prepare("SELECT 1 FROM carrinho WHERE usuario_id = :u AND jogo_id = :j");
    $stmt->execute([':u' => (int)$usuarioId, ':j' => (int)$jogoId]);
    if (!$stmt->fetch()) {
        $conexao->prepare("INSERT INTO carrinho (usuario_id, jogo_id) VALUES (:u, :j)")
                ->execute([':u' => (int)$usuarioId, ':j' => (int)$jogoId]);
    }
    return true;
}

function removerCarrinho($conexao, $usuarioId, $jogoId)
{
    $conexao->prepare("DELETE FROM carrinho WHERE usuario_id = :u AND jogo_id = :j")
            ->execute([':u' => (int)$usuarioId, ':j' => (int)$jogoId]);
}

function idsCarrinho($conexao, $usuarioId)
{
    $stmt = $conexao->prepare("SELECT jogo_id FROM carrinho WHERE usuario_id = :u");
    $stmt->bindValue(":u", (int)$usuarioId, PDO::PARAM_INT);
    $stmt->execute();
    return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
}