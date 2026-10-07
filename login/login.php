<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/login.css">
    <link rel="shortcut icon" href="../uploads/favicon.ico" type="image/x-icon">
    <title>Login</title>
</head>

<body>
    <?php
    include '../includes/functions.php';
    include '../includes/conexao.php';
    session_start();
    ?>
  <main class="pagina">
 
    <!-- Lado esquerdo -->
    <section class="apresentacao">
      <div class="logo">
        <img src="../uploads/banner-maior.png" alt="Logo do site" width="450">
      </div>
 
      <h1>Sua próxima jornada<br><span>começa aqui.</span></h1>
      <p class="subtitulo">Compre, jogue e viva grandes histórias.</p>
 
      <ul class="beneficios">
        <li>
          <span class="beneficio-icone"><img src="../uploads/controle-icon.png" alt="🎮"></span>
          <div>
            <strong>Os melhores jogos</strong>
            <small>Lançamentos, clássicos e muito mais.</small>
          </div>
        </li>
        <li>
          <span class="beneficio-icone"><img src="../uploads/estrela-icon.png" alt="⭐"></span>
          <div>
            <strong>Os melhores preços</strong>
            <small>Ofertas imperdíveis todos os dias.</small>
          </div>
        </li>
        <li>
          <span class="beneficio-icone"><img src="../uploads/grafico-icon.png" alt="📊"></span>
          <div>
            <strong>Estatísticamente melhor que a concorrência</strong>
            <small>Melhores preços, melhores jogos, melhores histórias.</small>
          </div>
        </li>
      </ul>
    </section>
 
    <!-- Card de login -->
    <section class="card">
      <h2>Bem-vindo <span>de volta!</span></h2>
      <p class="card-subtitulo">Faça login para acessar.</p>
 
      <form method="POST">
        <label for="usuario">Nome de usuário</label>
        <input type="text" id="usuario" name="usuario" placeholder="Digite seu e-mail ou usuário" required>
 
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
 
        <button type="submit" class="botao-entrar">Entrar</button>
      </form>
 
      <p class="cadastro">Ainda não tem uma conta? <a href="/login/cadastrar.php">Cadastre-se</a></p>
    </section>
 
  </main>
    <?php
    if (isset($_POST['usuario']) and isset($_POST['senha'])) {
        $usuario = consultarUsuario($conexao, $_POST['usuario']);
        if ($_POST['usuario'] == $usuario['usuario'] && $_POST['senha'] == $usuario['senha']) {
            $_SESSION['id'] = $usuario['id'];
            header("Location: ../pages/inicial.php");
        } else {
            echo "<hr>Usuário inexistente. Tente novamente";
        }
    }
    ?>
</body>

</html>