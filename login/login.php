<?php
// A lógica vem ANTES de qualquer HTML, senão o redirecionamento (header) não funciona.
require_once __DIR__ . '/../includes/functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Quem já está logado vai direto pra home
if (isset($_SESSION['id'])) {
    header("Location: /pages/inicial.php");
    exit();
}

$erro = '';
$usuarioDigitado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioDigitado = trim((string)($_POST['usuario'] ?? ''));
    $senhaDigitada   = (string)($_POST['senha'] ?? '');

    $usuario = $usuarioDigitado !== '' ? consultarUsuario($conexao, $usuarioDigitado) : false;

    // Mesma mensagem para "usuário não existe" e "senha errada":
    // assim ninguém descobre quais usuários existem.
    if ($usuario && verificarSenha($conexao, $usuario, $senhaDigitada)) {
        session_regenerate_id(true);
        $_SESSION['id'] = (int)$usuario['id'];
        header("Location: /pages/inicial.php");
        exit();
    }
    $erro = 'Usuário ou senha incorretos.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/login.css">
    <link rel="shortcut icon" href="/uploads/favicon.ico" type="image/x-icon">
    <title>Login</title>
</head>

<body>
  <main class="pagina">

    <!-- Lado esquerdo -->
    <section class="apresentacao">
      <div class="logo">
        <img src="/uploads/banner-maior.png" alt="Logo do site" width="450">
      </div>

      <h1>Sua próxima jornada<br><span>começa aqui.</span></h1>
      <p class="subtitulo">Compre, jogue e viva grandes histórias.</p>

      <ul class="beneficios">
        <li>
          <span class="beneficio-icone"><img src="/uploads/controle-icon.png" alt=""></span>
          <div>
            <strong>Os melhores jogos</strong>
            <small>Lançamentos, clássicos e muito mais.</small>
          </div>
        </li>
        <li>
          <span class="beneficio-icone"><img src="/uploads/estrela-icon.png" alt=""></span>
          <div>
            <strong>Os melhores preços</strong>
            <small>Ofertas imperdíveis todos os dias.</small>
          </div>
        </li>
        <li>
          <span class="beneficio-icone"><img src="/uploads/grafico-icon.png" alt=""></span>
          <div>
            <strong>Estatisticamente melhor que a concorrência</strong>
            <small>Melhores preços, melhores jogos, melhores histórias.</small>
          </div>
        </li>
      </ul>
    </section>

    <!-- Card de login -->
    <section class="card">
      <h2>Bem-vindo <span>de volta!</span></h2>
      <p class="card-subtitulo">Faça login para acessar.</p>

      <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'ok'): ?>
        <p class="mensagem mensagem--ok">Conta criada! Agora é só entrar.</p>
      <?php endif; ?>
      <?php if ($erro): ?>
        <p class="mensagem mensagem--erro"><?= e($erro) ?></p>
      <?php endif; ?>

      <form method="POST">
        <label for="usuario">Nome de usuário</label>
        <input type="text" id="usuario" name="usuario" value="<?= e($usuarioDigitado) ?>" placeholder="Digite seu nome de usuário" required autofocus>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

        <button type="submit" class="botao-entrar">Entrar</button>
      </form>

      <p class="cadastro">Ainda não tem uma conta? <a href="/login/cadastrar.php">Cadastre-se</a></p>
    </section>

  </main>
</body>

</html>
