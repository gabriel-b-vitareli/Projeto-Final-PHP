<?php
require_once __DIR__ . '/../includes/admin-nivel1.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$jogo = $id ? buscarJogo($conexao, $id) : false;
if (!$jogo) {
    flash('Jogo não encontrado.', 'erro');
    header('Location: /pages/gerenciar-jogos.php');
    exit();
}
$plataformasOk = ['PC', 'PS', 'Xbox', 'Switch'];
$idadesOk = [0, 10, 12, 14, 16, 18];
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
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
$paginaAtual = 'admin';
$tituloPagina = 'Editar jogo';
require __DIR__ . '/../includes/header.php';
?>
<main class="content content--full">
    <div class="content__main">
        <?php exibirFlash(); ?>
        <h1 class="pagina-titulo">Editar jogo</h1>
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