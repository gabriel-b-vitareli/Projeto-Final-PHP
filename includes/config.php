<?php
/*
 * Endereço-base do projeto (BASE_URL) e a função url().
 *
 * Por que isso existe: links como "/pages/loja.php" só funcionam quando o projeto
 * está na raiz do site (http://localhost:8000/). Num servidor, o projeto muitas vezes
 * fica numa subpasta (http://servidor/gameshelf/) e esses links quebrariam.
 *
 * Como usar nas páginas:   <a href="<?= url('pages/loja.php') ?>">
 * Em redirecionamentos:    header('Location: ' . url('pages/inicial.php'));
 *
 * A BASE_URL é descoberta automaticamente, então o mesmo código roda em:
 *   - php -S localhost:8000          -> BASE_URL = ''           (raiz)
 *   - Apache/Nginx em /var/www/html  -> BASE_URL = ''           (raiz)
 *   - Apache/Nginx em .../gameshelf  -> BASE_URL = '/gameshelf' (subpasta)
 *
 * Se a detecção automática falhar no seu servidor (proxy reverso, Alias incomum...),
 * force o valor de uma destas formas:
 *   - criando includes/config.local.php (fica fora do Git) com:
 *         <?php define('BASE_URL', '/gameshelf');      // ou '' para a raiz
 *   - ou pela variável de ambiente GAMESHELF_BASE_URL (ex.: "/gameshelf")
 */

// Ajuste manual opcional, específico desta máquina (não vai pro Git).
if (is_file(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
}

// Normaliza: sem barra no fim, com barra no começo (ou vazio, para a raiz) e com
// cada pedaço codificado, para poder entrar direto no HTML sem risco.
function normalizarBaseUrl($base)
{
    $base = trim(str_replace('\\', '/', (string)$base), '/');
    if ($base === '') {
        return '';
    }
    return '/' . implode('/', array_map('rawurlencode', explode('/', $base)));
}

function detectarBaseUrl()
{
    // 1) Valor forçado por variável de ambiente.
    $manual = getenv('GAMESHELF_BASE_URL');
    if ($manual === false && isset($_SERVER['GAMESHELF_BASE_URL'])) {
        $manual = $_SERVER['GAMESHELF_BASE_URL'];
    }
    if ($manual !== false) {
        return normalizarBaseUrl($manual);
    }

    $raiz   = str_replace('\\', '/', (string)realpath(__DIR__ . '/..'));            // pasta do projeto no disco
    $script = str_replace('\\', '/', (string)realpath($_SERVER['SCRIPT_FILENAME'] ?? '')); // arquivo que está rodando
    $nome   = str_replace('\\', '/', (string)($_SERVER['SCRIPT_NAME'] ?? ''));       // endereço desse arquivo na web

    // 2) Método principal: compara o caminho do script no disco com o endereço dele.
    //    Disco: /var/www/html/gameshelf/pages/loja.php
    //    Web:   /gameshelf/pages/loja.php
    //    Tirando "/pages/loja.php" do fim do endereço sobra "/gameshelf".
    //    Funciona mesmo com Alias, ~usuario e links simbólicos.
    if ($raiz !== '' && $script !== '' && stripos($script, $raiz . '/') === 0) {
        $relativo = substr($script, strlen($raiz)); // "/pages/loja.php"
        $tam = strlen($relativo);
        if ($tam > 0 && strlen($nome) >= $tam && substr_compare($nome, $relativo, -$tam, $tam, true) === 0) {
            return normalizarBaseUrl(substr($nome, 0, strlen($nome) - $tam));
        }
    }

    // 3) Plano B: posição do projeto dentro da raiz de documentos do servidor.
    $docroot = str_replace('\\', '/', (string)realpath($_SERVER['DOCUMENT_ROOT'] ?? ''));
    if ($docroot !== '' && $raiz !== '' && stripos($raiz . '/', $docroot . '/') === 0) {
        return normalizarBaseUrl(substr($raiz, strlen($docroot)));
    }

    // 4) Último recurso: raiz do site.
    return '';
}

if (!defined('BASE_URL')) {
    define('BASE_URL', detectarBaseUrl());
}

// Monta o endereço de uma página ou arquivo do projeto, a partir da raiz do projeto.
// url('pages/loja.php?ordem=novos')  ->  /gameshelf/pages/loja.php?ordem=novos
function url($caminho = '')
{
    return BASE_URL . '/' . ltrim((string)$caminho, '/');
}
