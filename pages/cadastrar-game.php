<?php
require_once __DIR__ . '/../login/verifica-login.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/componentes.php';
require_once __DIR__ . '/../includes/imagens.php';

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
$imagens = configImagens();

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
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
            $res = validarImagem($campo, $cfg);
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
                    $gravada = salvarImagem($img, $imagens[$campo]);
                    $salvos[] = $gravada['caminho'];
                    $nomes[$campo] = $gravada['nome'];
                }

                $sql = "INSERT INTO jogos
                            (titulo, capa, logo, hero, plataforma, genero, desenvolvedora, lancamento, descricao, idade,
                             preco, preco_original, destaque)
                        VALUES
                            (:titulo, :capa, :logo, :hero, :plataforma, :genero, :dev, :lancamento, :descricao, :idade,
                             :preco, :original, :destaque)
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
                header('Location: ' . url('pages/jogo.php?id=' . $novoId));
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
            <img class="previa previa--capa" id="previa-capa" alt="Prévia da capa">
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