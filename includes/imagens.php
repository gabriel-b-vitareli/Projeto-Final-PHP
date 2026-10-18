<?php
/*
 * Upload de imagens dos jogos e leitura de preço.
 * Usado por pages/cadastrar-game.php e pages/editar-jogo.php.
 */

// Cada imagem: rótulo, subpasta em uploads/, tamanho máximo e tipos aceitos.
// A logo só aceita PNG/WebP porque precisa de fundo transparente.
function configImagens()
{
    $MB = 1024 * 1024;
    $jpg = IMAGETYPE_JPEG;
    $png = IMAGETYPE_PNG;
    $webp = IMAGETYPE_WEBP;

    return [
        'capa' => ['rotulo' => 'Capa',          'pasta' => 'capas', 'max' => 5 * $MB, 'tipos' => [$jpg, $png, $webp], 'aceita' => 'JPG, PNG ou WebP'],
        'logo' => ['rotulo' => 'Logo',          'pasta' => 'logos', 'max' => 3 * $MB, 'tipos' => [$png, $webp],       'aceita' => 'PNG ou WebP'],
        'hero' => ['rotulo' => 'Banner (hero)', 'pasta' => 'heros', 'max' => 8 * $MB, 'tipos' => [$jpg, $png, $webp], 'aceita' => 'JPG, PNG ou WebP'],
    ];
}

// Aceita "199,90" ou "199.90". Devolve null se não for um valor válido.
function lerPreco($texto)
{
    $texto = str_replace(',', '.', trim((string)$texto));
    if ($texto === '' || !is_numeric($texto)) {
        return null;
    }
    $n = round((float)$texto, 2);
    return ($n >= 0 && $n <= 99999999.99) ? $n : null;
}

/**
 * Valida uma imagem enviada. Devolve:
 *   null                         -> nenhum arquivo enviado (tudo bem, é opcional)
 *   ['erro' => '...']            -> algo errado
 *   ['tmp' => ..., 'ext' => ...] -> pronta para salvar
 */
function validarImagem($campo, $cfg)
{
    $extensoes = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];

    $arq = $_FILES[$campo] ?? null;
    if (!$arq || $arq['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $r = $cfg['rotulo'];
    if ($arq['error'] === UPLOAD_ERR_INI_SIZE || $arq['error'] === UPLOAD_ERR_FORM_SIZE) {
        return ['erro' => "$r: o arquivo passa do limite do servidor (" . ini_get('upload_max_filesize')
            . "). Use uma imagem menor ou aumente upload_max_filesize no php.ini."];
    }
    if ($arq['error'] !== UPLOAD_ERR_OK) {
        return ['erro' => "$r: não foi possível enviar o arquivo. Tente novamente."];
    }
    if ($arq['size'] > $cfg['max']) {
        return ['erro' => "$r: o arquivo é grande demais (máximo " . round($cfg['max'] / 1048576) . " MB)."];
    }
    // Confere o conteúdo real do arquivo, não a extensão que o usuário escolheu
    $info = @getimagesize($arq['tmp_name']);
    if (!$info || !in_array($info[2], $cfg['tipos'], true)) {
        return ['erro' => "$r: envie uma imagem " . $cfg['aceita'] . "."];
    }
    return ['tmp' => $arq['tmp_name'], 'ext' => $extensoes[$info[2]]];
}

/**
 * Grava uma imagem já validada em uploads/<pasta>/ com nome aleatório.
 * Devolve ['nome' => ..., 'caminho' => ...] ou lança RuntimeException.
 */
function salvarImagem($img, $cfg)
{
    $pasta = __DIR__ . '/../uploads/' . $cfg['pasta'];
    if (!is_dir($pasta) && !mkdir($pasta, 0755, true)) {
        throw new RuntimeException('Não consegui criar a pasta ' . $cfg['pasta'] . '.');
    }
    $nome = bin2hex(random_bytes(8)) . '.' . $img['ext'];
    if (!move_uploaded_file($img['tmp'], $pasta . '/' . $nome)) {
        throw new RuntimeException('Não consegui salvar a imagem (' . $cfg['rotulo'] . ') no servidor.');
    }
    return ['nome' => $nome, 'caminho' => $pasta . '/' . $nome];
}

// Apaga do disco uma imagem antiga. Links http(s) e valores vazios são ignorados.
function apagarImagemLocal($valor, $cfg)
{
    $valor = trim((string)$valor);
    if ($valor === '' || preg_match('#^https?://#i', $valor)) {
        return;
    }
    $caminho = __DIR__ . '/../uploads/' . $cfg['pasta'] . '/' . basename($valor);
    if (is_file($caminho)) {
        @unlink($caminho);
    }
}
