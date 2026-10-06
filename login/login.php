<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/login.css">
    <title>Login</title>
</head>

<body>
    <?php
    include '../includes/functions.php';
    session_start();
    ?>
  <main class="pagina">
 
    <!-- Lado esquerdo -->
    <section class="apresentacao">
      <div class="logo">
        <img src="../uploads/banner-maior.png" alt="Logo do site" width="450">
      </div>
 
      <h1>Todos os seus jogos,<br><span>em um só lugar.</span></h1>
      <p class="subtitulo">Cadastre, avalie e acompanhe sua jornada no mundo dos games.</p>
 
      <ul class="beneficios">
        <li>
          <span class="beneficio-icone"><img src="../uploads/controle-icon.png" alt="🎮"></span>
          <div>
            <strong>Organize seu catálogo</strong>
            <small>Tenha todos os seus jogos em um só lugar.</small>
          </div>
        </li>
        <li>
          <span class="beneficio-icone"><img src="../uploads/estrela-icon.png" alt="⭐"></span>
          <div>
            <strong>Avalie e comente</strong>
            <small>Registre suas experiências e opiniões.</small>
          </div>
        </li>
        <li>
          <span class="beneficio-icone"><img src="../uploads/grafico-icon.png" alt="📊"></span>
          <div>
            <strong>Acompanhe seu progresso</strong>
            <small>Veja suas conquistas e estatísticas.</small>
          </div>
        </li>
      </ul>
    </section>
 
    <!-- Card de login -->
    <section class="card">
      <h2>Bem-vindo <span>de volta!</span></h2>
      <p class="card-subtitulo">Faça login para acessar seu catálogo.</p>
 
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