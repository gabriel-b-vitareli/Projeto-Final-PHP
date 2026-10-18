<?php
require_once __DIR__ . '/../includes/admin-nivel1.php';
<<<<<<< HEAD
require_once __DIR__ . '/../includes/imagens.php';
=======
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$jogo = $id ? buscarJogo($conexao, $id) : false;
if (!$jogo) {
    flash('Jogo não encontrado.', 'erro');
    header('Location: /pages/gerenciar-jogos.php');
    exit();
}
<<<<<<< HEAD

$plataformasOk = ['PC', 'PS', 'Xbox', 'Switch'];
$idadesOk = [0 => 'Livre', 10 => '10+', 12 => '12+', 14 => '14+', 16 => '16+', 18 => '18+'];
$imagens = configImagens();
=======
$plataformasOk = ['PC', 'PS', 'Xbox', 'Switch'];
$idadesOk = [0, 10, 12, 14, 16, 18];
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
$erros = [];
$v = [
    'titulo' => $jogo['titulo'],
    'plataformas' => listaPlataformas($jogo),
    'genero' => $jogo['genero'] ?? '',
    'desenvolvedora' => $jogo['desenvolvedora'] ?? '',
    'lancamento' => $jogo['lancamento'],
    'descricao' => $jogo['descricao'] ?? '',
    'idade' => (string)($jogo['idade'] ?? 0),
    'preco' => number_format((float)$jogo['preco'], 2, ',', ''),
    'preco_original' => $jogo['preco_original'] !== null ? number_format((float)$jogo['preco_original'], 2, ',', '') : '',
    'destaque' => (bool)$jogo['destaque'],
];
<<<<<<< HEAD

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Arquivo maior que o post_max_size do PHP chega aqui com tudo vazio
    if (empty($_POST) && empty($_FILES) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        $erros[] = 'O envio total passou do limite do servidor (post_max_size = ' . ini_get('post_max_size') . '). Use imagens menores ou aumente esse limite no php.ini.';
    } elseif (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
=======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
        $erros[] = 'Sessão expirada. Atualize a página e tente novamente.';
    } else {
        $v['titulo'] = trim((string)($_POST['titulo'] ?? ''));
        $v['plataformas'] = array_values(array_intersect($plataformasOk, (array)($_POST['plataformas'] ?? [])));
        $v['genero'] = trim((string)($_POST['genero'] ?? ''));
        $v['desenvolvedora'] = trim((string)($_POST['desenvolvedora'] ?? ''));
        $v['lancamento'] = trim((string)($_POST['lancamento'] ?? ''));
        $v['descricao'] = trim((string)($_POST['descricao'] ?? ''));
        $v['idade'] = (string)($_POST['idade'] ?? '0');
        $v['preco'] = trim((string)($_POST['preco'] ?? ''));
        $v['preco_original'] = trim((string)($_POST['preco_original'] ?? ''));
        $v['destaque'] = isset($_POST['destaque']);
<<<<<<< HEAD

        if ($v['titulo'] === '' || strlen($v['titulo']) > 100) {
            $erros[] = 'Informe um título com até 100 caracteres.';
        }
        if (!$v['plataformas']) {
            $erros[] = 'Selecione ao menos uma plataforma.';
        }
        if ($v['genero'] === '' || strlen($v['genero']) > 50) {
            $erros[] = 'Informe um gênero com até 50 caracteres.';
        }
        if (strlen($v['desenvolvedora']) > 100) {
            $erros[] = 'A desenvolvedora pode ter até 100 caracteres.';
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

        // ----- Imagens (todas opcionais: sem arquivo novo, a atual é mantida) -----
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
            $salvos = [];   // arquivos novos gravados, pra apagar se o banco falhar
            $novos = [];    // campo => nome do arquivo novo
            try {
                foreach ($prontas as $campo => $img) {
                    $gravada = salvarImagem($img, $imagens[$campo]);
                    $salvos[] = $gravada['caminho'];
                    $novos[$campo] = $gravada['nome'];
                }

                // As colunas de imagem só entram no UPDATE quando há arquivo novo.
                // Os nomes das colunas vêm de configImagens(), nunca do usuário.
                $sql = 'UPDATE jogos SET titulo=:titulo, plataforma=:plataforma, genero=:genero, desenvolvedora=:dev,
                               lancamento=:lancamento, descricao=:descricao, idade=:idade, preco=:preco,
                               preco_original=:original, destaque=:destaque';
                foreach ($novos as $campo => $nome) {
                    $sql .= ", $campo=:img_$campo";
                }
                $sql .= ' WHERE id=:id';

                $st = $conexao->prepare($sql);
                $st->bindValue(':titulo', $v['titulo']);
                $st->bindValue(':plataforma', implode(',', $v['plataformas']));
                $st->bindValue(':genero', $v['genero']);
                $st->bindValue(':dev', $v['desenvolvedora'] !== '' ? $v['desenvolvedora'] : null);
                $st->bindValue(':lancamento', $v['lancamento']);
                $st->bindValue(':descricao', $v['descricao'] !== '' ? $v['descricao'] : null);
                $st->bindValue(':idade', (int)$v['idade'], PDO::PARAM_INT);
                $st->bindValue(':preco', number_format($preco, 2, '.', ''));
                $st->bindValue(':original', $precoOriginal !== null ? number_format($precoOriginal, 2, '.', '') : null);
                $st->bindValue(':destaque', $v['destaque'], PDO::PARAM_BOOL);
                foreach ($novos as $campo => $nome) {
                    $st->bindValue(":img_$campo", $nome);
                }
                $st->bindValue(':id', $id, PDO::PARAM_INT);
                $st->execute();

                // Banco atualizado: agora sim apaga do disco as imagens que foram substituídas
                foreach ($novos as $campo => $nome) {
                    apagarImagemLocal($jogo[$campo] ?? '', $imagens[$campo]);
                }

                $_SESSION['csrf'] = bin2hex(random_bytes(32));
                flash('Jogo atualizado com sucesso.');
                header('Location: /pages/gerenciar-jogos.php');
                exit();
            } catch (Throwable $ex) {
                // Se algo falhou, não deixa as imagens novas órfãs (as antigas continuam intactas)
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
$urlAtual = ['capa' => capaUrl($jogo), 'logo' => logoUrl($jogo), 'hero' => heroUrl($jogo)];
=======
        if ($v['titulo'] === '' || strlen($v['titulo']) > 100) $erros[] = 'Informe um título com até 100 caracteres.';
        if (!$v['plataformas']) $erros[] = 'Selecione ao menos uma plataforma.';
        if ($v['genero'] === '' || strlen($v['genero']) > 50) $erros[] = 'Informe um gênero com até 50 caracteres.';
        if (strlen($v['desenvolvedora']) > 100) $erros[] = 'A desenvolvedora pode ter até 100 caracteres.';
        $data = DateTime::createFromFormat('Y-m-d', $v['lancamento']);
        if (!$data || $data->format('Y-m-d') !== $v['lancamento']) $erros[] = 'Informe uma data de lançamento válida.';
        if (!in_array((int)$v['idade'], $idadesOk, true)) $erros[] = 'Classificação indicativa inválida.';
        $preco = str_replace(',', '.', $v['preco']);
        $original = $v['preco_original'] === '' ? null : str_replace(',', '.', $v['preco_original']);
        if (!is_numeric($preco) || (float)$preco < 0 || (float)$preco > 99999999.99) $erros[] = 'Informe um preço válido.';
        if ($original !== null && (!is_numeric($original) || (float)$original <= (float)$preco || (float)$original > 99999999.99)) $erros[] = 'O preço original deve ser válido e maior que o preço atual.';
        if (!$erros) {
            $sql = 'UPDATE jogos SET titulo=:titulo, plataforma=:plataforma, genero=:genero, desenvolvedora=:dev, lancamento=:lancamento, descricao=:descricao, idade=:idade, preco=:preco, preco_original=:original, destaque=:destaque WHERE id=:id';
            $st = $conexao->prepare($sql);
            $st->execute([
                ':titulo' => $v['titulo'],
                ':plataforma' => implode(',', $v['plataformas']),
                ':genero' => $v['genero'],
                ':dev' => $v['desenvolvedora'] !== '' ? $v['desenvolvedora'] : null,
                ':lancamento' => $v['lancamento'],
                ':descricao' => $v['descricao'] !== '' ? $v['descricao'] : null,
                ':idade' => (int)$v['idade'],
                ':preco' => number_format((float)$preco, 2, '.', ''),
                ':original' => $original !== null ? number_format((float)$original, 2, '.', '') : null,
                ':destaque' => $v['destaque'] ? 'true' : 'false',
                ':id' => $id,
            ]);
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
            flash('Jogo atualizado com sucesso.');
            header('Location: /pages/gerenciar-jogos.php');
            exit();
        }
    }
}
$generosExistentes = listarGeneros($conexao);
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
$paginaAtual = 'admin';
$tituloPagina = 'Editar jogo';
require __DIR__ . '/../includes/header.php';
?>
<main class="content content--full">
    <div class="content__main">
        <?php exibirFlash(); ?>
        <h1 class="pagina-titulo">Editar jogo</h1>
<<<<<<< HEAD
        <p class="pagina-sub">Altere os dados de <?= e($jogo['titulo']) ?>. Para trocar uma imagem, escolha um arquivo novo; os campos de imagem em branco mantêm a atual.</p>
        <?php if ($erros): ?>
            <div class="flash flash--erro" role="alert">
                <ul class="lista-erros"><?php foreach ($erros as $erro): ?><li><?= e($erro) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>
        <form class="form-jogo" method="post" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

            <label>Título *
                <input type="text" name="titulo" maxlength="100" required value="<?= e($v['titulo']) ?>">
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
                    <input type="text" name="genero" maxlength="50" required list="generos" value="<?= e($v['genero']) ?>">
                    <datalist id="generos"><?php foreach ($generosExistentes as $g): ?><option value="<?= e($g) ?>"><?php endforeach; ?></datalist>
                </label>
                <label>Desenvolvedora
                    <input type="text" name="desenvolvedora" maxlength="100" value="<?= e($v['desenvolvedora']) ?>">
                </label>
            </div>

            <div class="linha">
                <label>Data de lançamento *
                    <input type="date" name="lancamento" required value="<?= e($v['lancamento']) ?>">
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
                    <input type="text" name="preco" inputmode="decimal" required value="<?= e($v['preco']) ?>">
                </label>
                <label>Preço original (R$)
                    <input type="text" name="preco_original" inputmode="decimal" value="<?= e($v['preco_original']) ?>">
                    <small>Só se estiver em promoção: é o preço "de", usado para calcular o desconto.</small>
                </label>
            </div>

            <label>Descrição
                <textarea name="descricao"><?= e($v['descricao']) ?></textarea>
            </label>

            <div class="linha">
                <label>Capa (<?= e($imagens['capa']['aceita']) ?>, até 5 MB)
                    <?php if ($urlAtual['capa']): ?>
                        <img class="imagem-atual imagem-atual--capa" src="<?= e($urlAtual['capa']) ?>" alt="Capa atual">
                    <?php else: ?>
                        <span class="imagem-vazia">Este jogo ainda não tem capa.</span>
                    <?php endif; ?>
                    <input type="file" name="capa" accept="image/jpeg,image/png,image/webp" data-previa="previa-capa">
                    <small>Proporção vertical (3:4). Aparece inteira nos cards.</small>
                    <img class="previa previa--capa" id="previa-capa" alt="Prévia da nova capa">
                </label>
                <label>Logo (<?= e($imagens['logo']['aceita']) ?>, até 3 MB)
                    <?php if ($urlAtual['logo']): ?>
                        <img class="imagem-atual imagem-atual--logo" src="<?= e($urlAtual['logo']) ?>" alt="Logo atual">
                    <?php else: ?>
                        <span class="imagem-vazia">Este jogo ainda não tem logo.</span>
                    <?php endif; ?>
                    <input type="file" name="logo" accept="image/png,image/webp" data-previa="previa-logo">
                    <small>Com fundo transparente. Substitui o nome do jogo no destaque da página inicial.</small>
                    <img class="previa previa--logo" id="previa-logo" alt="Prévia da nova logo">
                </label>
            </div>

            <label>Banner / hero (<?= e($imagens['hero']['aceita']) ?>, até 8 MB)
                <?php if ($urlAtual['hero']): ?>
                    <img class="imagem-atual imagem-atual--hero" src="<?= e($urlAtual['hero']) ?>" alt="Banner atual">
                <?php else: ?>
                    <span class="imagem-vazia">Este jogo ainda não tem banner.</span>
                <?php endif; ?>
                <input type="file" name="hero" accept="image/jpeg,image/png,image/webp" data-previa="previa-hero">
                <small>Imagem horizontal, de preferência 1920 x 600 ou maior. É o fundo do destaque da página inicial.</small>
                <img class="previa previa--hero" id="previa-hero" alt="Prévia do novo banner">
            </label>

            <label class="checkbox-inline"><input type="checkbox" name="destaque" value="1" <?= $v['destaque'] ? 'checked' : '' ?>>Mostrar como destaque na página inicial</label>

            <div class="admin-game__actions">
                <button class="btn btn--primary" type="submit">Salvar alterações</button>
                <a class="btn btn--ghost" href="/pages/gerenciar-jogos.php">Cancelar</a>
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
=======
        <p class="pagina-sub">Altere os dados de <?= e($jogo['titulo']) ?>. A capa e as imagens atuais serão mantidas.</p>
        <?php if ($erros): ?><div class="flash flash--erro">
                <ul><?php foreach ($erros as $erro): ?><li><?= e($erro) ?></li><?php endforeach; ?></ul>
            </div><?php endif; ?>
        <form class="form-jogo" method="post">
            <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
            <label>Título<input type="text" name="titulo" maxlength="100" required value="<?= e($v['titulo']) ?>"></label>
            <fieldset>
                <legend>Plataformas</legend>
                <div class="opcoes"><?php foreach ($plataformasOk as $p): ?><label><input type="checkbox" name="plataformas[]" value="<?= e($p) ?>" <?= in_array($p, $v['plataformas'], true) ? 'checked' : '' ?>> <?= e($p) ?></label><?php endforeach; ?></div>
            </fieldset>
            <div class="linha"><label>Gênero<input type="text" name="genero" maxlength="50" required list="generos" value="<?= e($v['genero']) ?>"><datalist id="generos"><?php foreach ($generosExistentes as $g): ?><option value="<?= e($g) ?>"><?php endforeach; ?></datalist></label>
                <label>Desenvolvedora<input type="text" name="desenvolvedora" maxlength="100" value="<?= e($v['desenvolvedora']) ?>"></label>
            </div>
            <div class="linha"><label>Lançamento<input type="date" name="lancamento" required value="<?= e($v['lancamento']) ?>"></label>
                <label>Classificação indicativa<select name="idade"><?php foreach ([0 => 'Livre', 10 => '10+', 12 => '12+', 14 => '14+', 16 => '16+', 18 => '18+'] as $n => $rotulo): ?><option value="<?= $n ?>" <?= (int)$v['idade'] === $n ? 'selected' : '' ?>><?= e($rotulo) ?></option><?php endforeach; ?></select></label>
            </div>
            <div class="linha"><label>Preço atual (R$)<input type="text" name="preco" required value="<?= e($v['preco']) ?>"></label><label>Preço original (opcional)<input type="text" name="preco_original" value="<?= e($v['preco_original']) ?>"><small>Preencha apenas se houver desconto.</small></label></div>
            <label>Descrição<textarea name="descricao" rows="5"><?= e($v['descricao']) ?></textarea></label>
            <label class="checkbox-inline"><input type="checkbox" name="destaque" value="1" <?= $v['destaque'] ? 'checked' : '' ?>> Exibir como jogo em destaque</label>
            <div class="admin-game__actions"><button class="btn btn--primary" type="submit">Salvar alterações</button><a class="btn btn--ghost" href="/pages/gerenciar-jogos.php">Cancelar</a></div>
        </form>
    </div>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
