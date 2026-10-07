<?php
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/componentes.php';

/* ---------- Acesso: só nível 1 ----------
 * Quem não for admin recebe um 404 comum (sem redirecionar nem avisar "acesso negado"),
 * pra página parecer que não existe. Isso roda antes de qualquer HTML. */
$st = $conexao->prepare("SELECT nivel FROM usuarios WHERE id = :id");
$st->bindValue(':id', (int)$_SESSION['id'], PDO::PARAM_INT);
$st->execute();
if ((int)$st->fetchColumn() !== 1) {
    http_response_code(404);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>404 Not Found</title></head>'
       . '<body><h1>Not Found</h1><p>The requested URL was not found on this server.</p></body></html>';
    exit();
}

/* ---------- Configurações ---------- */
$plataformasOk = ['PC', 'PS', 'Xbox', 'Switch'];
$idadesOk      = [0 => 'Livre', 10 => '10+', 12 => '12+', 14 => '14+', 16 => '16+', 18 => '18+'];
$MB = 1024 * 1024;
$jpg = IMAGETYPE_JPEG; $png = IMAGETYPE_PNG; $webp = IMAGETYPE_WEBP;
$extensoes = [$jpg => 'jpg', $png => 'png', $webp => 'webp'];

// Cada imagem: rótulo, subpasta em uploads/, tamanho máximo e tipos aceitos.
// A logo só aceita PNG/WebP porque precisa de fundo transparente.
$imagens = [
    'capa' => ['rotulo' => 'Capa',            'pasta' => 'capas', 'max' => 5 * $MB, 'tipos' => [$jpg, $png, $webp], 'aceita' => 'JPG, PNG ou WebP'],
    'logo' => ['rotulo' => 'Logo',            'pasta' => 'logos', 'max' => 3 * $MB, 'tipos' => [$png, $webp],       'aceita' => 'PNG ou WebP'],
    'hero' => ['rotulo' => 'Banner (hero)',   'pasta' => 'heros', 'max' => 8 * $MB, 'tipos' => [$jpg, $png, $webp], 'aceita' => 'JPG, PNG ou WebP'],
];
$pastaUploads = __DIR__ . '/../uploads';

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
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
 *   null                       -> nenhum arquivo enviado (tudo bem, é opcional)
 *   ['erro' => '...']          -> algo errado
 *   ['tmp' => ..., 'ext' => ...] -> pronta para salvar
 */
function validarImagem($campo, $cfg, $extensoes)
{
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

/* ---------- Processa o formulário ---------- */
$erros = [];
$v = [
    'titulo' => '', 'plataformas' => [], 'genero' => '', 'desenvolvedora' => '',
    'lancamento' => '', 'descricao' => '', 'idade' => '0',
    'preco' => '', 'preco_original' => '', 'destaque' => false,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Arquivo maior que o post_max_size do PHP chega aqui com tudo vazio
    if (empty($_POST) && empty($_FILES) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        $erros[] = 'O envio total passou do limite do servidor (post_max_size = ' . ini_get('post_max_size') . '). Use imagens menores ou aumente esse limite no php.ini.';
    } elseif (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
        $erros[] = 'Sua sessão do formulário expirou. Recarregue a página e tente de novo.';
    } else {
        $v['titulo']         = trim((string)($_POST['titulo'] ?? ''));
        $v['plataformas']    = array_values(array_intersect($plataformasOk, (array)($_POST['plataformas'] ?? [])));
        $v['genero']         = trim((string)($_POST['genero'] ?? ''));
        $v['desenvolvedora'] = trim((string)($_POST['desenvolvedora'] ?? ''));
        $v['lancamento']     = trim((string)($_POST['lancamento'] ?? ''));
        $v['descricao']      = trim((string)($_POST['descricao'] ?? ''));
        $v['idade']          = (string)($_POST['idade'] ?? '0');
        $v['preco']          = trim((string)($_POST['preco'] ?? ''));
        $v['preco_original'] = trim((string)($_POST['preco_original'] ?? ''));
        $v['destaque']       = isset($_POST['destaque']);

        if ($v['titulo'] === '' || strlen($v['titulo']) > 100) {
            $erros[] = 'Informe o título (até 100 caracteres).';
        }
        if (!$v['plataformas']) {
            $erros[] = 'Marque pelo menos uma plataforma.';
        }
        if ($v['genero'] === '' || strlen($v['genero']) > 50) {
            $erros[] = 'Informe o gênero (até 50 caracteres).';
        }
        if (strlen($v['desenvolvedora']) > 100) {
            $erros[] = 'A desenvolvedora pode ter no máximo 100 caracteres.';
        }
        $data = DateTime::createFromFormat('Y-m-d', $v['lancamento']);
        if (!$data || $data->format('Y-m-d') !== $v['lancamento']) {
            $erros[] = 'Informe uma data de lançamento válida.';
        }
        if (!array_key_exists((int)$v['idade'], $idadesOk)) {
            $erros[] = 'Classificação indicativa inválida.';
        }

        $preco = lerPreco($v['preco']);
        if ($preco === null) {
            $erros[] = 'Informe um preço válido (ex.: 199,90).';
        }
        $precoOriginal = null;
        if ($v['preco_original'] !== '') {
            $precoOriginal = lerPreco($v['preco_original']);
            if ($precoOriginal === null) {
                $erros[] = 'O preço original não é um valor válido.';
            } elseif ($preco !== null && $precoOriginal <= $preco) {
                $erros[] = 'O preço original precisa ser maior que o preço atual (ele é o preço "de", usado no desconto).';
            }
        }

        // ----- Imagens (todas opcionais) -----
        $prontas = [];
        foreach ($imagens as $campo => $cfg) {
            $res = validarImagem($campo, $cfg, $extensoes);
            if ($res === null) {
                continue;
            }
            if (isset($res['erro'])) {
                $erros[] = $res['erro'];
            } else {
                $prontas[$campo] = $res;
            }
        }

        // ----- Salva (só se estiver tudo certo) -----
        if (!$erros) {
            $salvos = []; // caminhos gravados, pra apagar se o banco falhar
            $nomes  = ['capa' => null, 'logo' => null, 'hero' => null];
            try {
                foreach ($prontas as $campo => $img) {
                    $pasta = $pastaUploads . '/' . $imagens[$campo]['pasta'];
                    if (!is_dir($pasta) && !mkdir($pasta, 0755, true)) {
                        throw new RuntimeException('Não consegui criar a pasta ' . $imagens[$campo]['pasta'] . '.');
                    }
                    $nome = bin2hex(random_bytes(8)) . '.' . $img['ext'];
                    if (!move_uploaded_file($img['tmp'], $pasta . '/' . $nome)) {
                        throw new RuntimeException('Não consegui salvar a imagem (' . $imagens[$campo]['rotulo'] . ') no servidor.');
                    }
                    $salvos[] = $pasta . '/' . $nome;
                    $nomes[$campo] = $nome;
                }

                $sql = "INSERT INTO jogos
                            (titulo, capa, logo, hero, plataforma, genero, desenvolvedora, lancamento, descricao, idade,
                             preco, preco_original, destaque, estoque, vendas, qtd_avaliacoes)
                        VALUES
                            (:titulo, :capa, :logo, :hero, :plataforma, :genero, :dev, :lancamento, :descricao, :idade,
                             :preco, :original, :destaque, 0, 0, 0)
                        RETURNING id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindValue(':titulo', $v['titulo']);
                $stmt->bindValue(':capa', $nomes['capa']);
                $stmt->bindValue(':logo', $nomes['logo']);
                $stmt->bindValue(':hero', $nomes['hero']);
                $stmt->bindValue(':plataforma', implode(',', $v['plataformas']));
                $stmt->bindValue(':genero', $v['genero']);
                $stmt->bindValue(':dev', $v['desenvolvedora'] !== '' ? $v['desenvolvedora'] : null);
                $stmt->bindValue(':lancamento', $v['lancamento']);
                $stmt->bindValue(':descricao', $v['descricao'] !== '' ? $v['descricao'] : null);
                $stmt->bindValue(':idade', (int)$v['idade'], PDO::PARAM_INT);
                $stmt->bindValue(':preco', number_format($preco, 2, '.', ''));
                $stmt->bindValue(':original', $precoOriginal !== null ? number_format($precoOriginal, 2, '.', '') : null);
                $stmt->bindValue(':destaque', $v['destaque'], PDO::PARAM_BOOL);
                $stmt->execute();
                $novoId = (int)$stmt->fetchColumn();

                $_SESSION['csrf'] = bin2hex(random_bytes(16));
                flash('Jogo cadastrado com sucesso.');
                header('Location: /pages/jogo.php?id=' . $novoId);
                exit();
            } catch (Throwable $ex) {
                // Se algo falhou depois do upload, não deixa imagens órfãs
                foreach ($salvos as $caminho) {
                    if (is_file($caminho)) {
                        unlink($caminho);
                    }
                }
                $erros[] = 'Erro ao salvar o jogo: ' . $ex->getMessage();
            }
        }
    }
}

$generosExistentes = listarGeneros($conexao);

$paginaAtual  = 'admin';
$tituloPagina = 'Cadastrar jogo';
require __DIR__ . '/../includes/header.php';
?>

  <style>
    .form-jogo { display: grid; gap: 16px; max-width: 760px; padding: 20px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); }
    .form-jogo .linha { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
    .form-jogo label, .form-jogo legend { display: grid; gap: 6px; font-size: 12.5px; color: var(--muted); }
    .form-jogo fieldset { border: 0; padding: 0; margin: 0; display: grid; gap: 6px; }
    .form-jogo input[type=text], .form-jogo input[type=date], .form-jogo select, .form-jogo textarea {
      width: 100%; padding: 9px 12px; background: var(--bg); color: var(--text);
      border: 1px solid var(--border); border-radius: var(--radius-sm); font: inherit; font-size: 14px;
    }
    .form-jogo input[type=file] { color: var(--muted); font-size: 13px; }
    .form-jogo textarea { min-height: 110px; resize: vertical; }
    .form-jogo .opcoes { display: flex; flex-wrap: wrap; gap: 8px 18px; }
    .form-jogo .opcoes label { display: flex; align-items: center; gap: 6px; color: var(--text); font-size: 14px; }
    .form-jogo small { color: var(--muted); font-size: 11.5px; }
    .previa { display: none; object-fit: contain; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--bg); }
    .previa--logo { max-width: 240px; max-height: 100px; }
    .previa--hero { width: 100%; max-height: 180px; object-fit: cover; }
    .lista-erros { margin: 0; padding-left: 18px; }
  </style>

  <main class="content content--full">
    <div class="content__main">

      <div>
        <h1 class="pagina-titulo">Cadastrar jogo</h1>
        <p class="pagina-sub">Adicione um novo jogo ao catálogo da loja.</p>
      </div>

      <?php if ($erros): ?>
        <div class="flash flash--erro" role="alert">
          <ul class="lista-erros"><?php foreach ($erros as $erro): ?><li><?= e($erro) ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <form class="form-jogo" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

        <label>Título *
          <input type="text" name="titulo" maxlength="100" value="<?= e($v['titulo']) ?>" required>
        </label>

        <fieldset>
          <legend>Plataformas *</legend>
          <div class="opcoes">
            <?php foreach ($plataformasOk as $p): ?>
              <label><input type="checkbox" name="plataformas[]" value="<?= e($p) ?>" <?= in_array($p, $v['plataformas'], true) ? 'checked' : '' ?>><?= e($p) ?></label>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <div class="linha">
          <label>Gênero *
            <input type="text" name="genero" maxlength="50" list="generos" value="<?= e($v['genero']) ?>" required>
            <datalist id="generos"><?php foreach ($generosExistentes as $g): ?><option value="<?= e($g) ?>"><?php endforeach; ?></datalist>
          </label>
          <label>Desenvolvedora
            <input type="text" name="desenvolvedora" maxlength="100" value="<?= e($v['desenvolvedora']) ?>">
          </label>
        </div>

        <div class="linha">
          <label>Data de lançamento *
            <input type="date" name="lancamento" value="<?= e($v['lancamento']) ?>" required>
          </label>
          <label>Classificação indicativa
            <select name="idade">
              <?php foreach ($idadesOk as $valor => $rotulo): ?>
                <option value="<?= $valor ?>" <?= (string)$valor === $v['idade'] ? 'selected' : '' ?>><?= e($rotulo) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
        </div>

        <div class="linha">
          <label>Preço (R$) *
            <input type="text" name="preco" inputmode="decimal" placeholder="199,90" value="<?= e($v['preco']) ?>" required>
          </label>
          <label>Preço original (R$)
            <input type="text" name="preco_original" inputmode="decimal" placeholder="249,90" value="<?= e($v['preco_original']) ?>">
            <small>Só se estiver em promoção: é o preço "de", usado para calcular o desconto.</small>
          </label>
        </div>

        <label>Descrição
          <textarea name="descricao"><?= e($v['descricao']) ?></textarea>
        </label>

        <div class="linha">
          <label>Capa (<?= e($imagens['capa']['aceita']) ?>, até 5 MB)
            <input type="file" name="capa" accept="image/jpeg,image/png,image/webp" data-previa="previa-capa">
            <small>Proporção vertical (3:4). Aparece inteira nos cards.</small>
            <img class="previa" id="previa-capa" alt="Prévia da capa" style="aspect-ratio:3/4;width:140px">
          </label>
          <label>Logo (<?= e($imagens['logo']['aceita']) ?>, até 3 MB)
            <input type="file" name="logo" accept="image/png,image/webp" data-previa="previa-logo">
            <small>Com fundo transparente. Substitui o nome do jogo no destaque da página inicial.</small>
            <img class="previa previa--logo" id="previa-logo" alt="Prévia da logo">
          </label>
        </div>

        <label>Banner / hero (<?= e($imagens['hero']['aceita']) ?>, até 8 MB)
          <input type="file" name="hero" accept="image/jpeg,image/png,image/webp" data-previa="previa-hero">
          <small>Imagem horizontal, de preferência 1920 x 600 ou maior. É o fundo do destaque da página inicial.</small>
          <img class="previa previa--hero" id="previa-hero" alt="Prévia do banner">
        </label>

        <div class="opcoes">
          <label><input type="checkbox" name="destaque" <?= $v['destaque'] ? 'checked' : '' ?>>Mostrar como destaque na página inicial</label>
        </div>

        <div>
          <button class="btn btn--primary" type="submit">Cadastrar jogo</button>
        </div>
      </form>
    </div>
  </main>

  <script>
    // Prévia das imagens escolhidas (só visual; a validação de verdade é feita no servidor)
    document.querySelectorAll('input[type=file][data-previa]').forEach(function (campo) {
      campo.addEventListener('change', function () {
        var img = document.getElementById(campo.dataset.previa);
        var arquivo = campo.files[0];
        if (arquivo && arquivo.type.indexOf('image/') === 0) {
          img.src = URL.createObjectURL(arquivo);
          img.style.display = 'block';
        } else {
          img.style.display = 'none';
        }
      });
    });
  </script>

<?php require __DIR__ . '/../includes/footer.php'; ?>