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
    // include '../includes/header.php';
    // include '../includes/functions.php';
    // session_start();
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
 
      <form>
        <label for="usuario">E-mail ou usuário</label>
        <input type="text" id="usuario" placeholder="Digite seu e-mail ou usuário">
 
        <label for="senha">Senha</label>
        <input type="password" id="senha" placeholder="Digite sua senha">
 
        <button type="submit" class="botao-entrar">Entrar</button>
 
        <div class="divisor"><span>ou</span></div>
 
        <button type="button" class="botao-google">Entrar com Google</button>
      </form>
 
      <p class="cadastro">Ainda não tem uma conta? <a href="/login/cadastrar.php">Cadastre-se</a></p>
    </section>
 
  </main>
    <?php
    // if (isset($_POST['email']) and isset($_POST['senha'])) {
    //     $usuario = consultarUsuario($conexao, $_POST['email']);
    //     if ($_POST['email'] == $usuario['email'] && $_POST['senha'] == $usuario['senha']) {
    //         $_SESSION['id'] = $usuario['id'];
    //         echo "<hr>Login aceito.";
    //         sleep(5);
    //         header("Location: ../index.php");
    //     } else {
    //         echo "<hr>Usuário inexistente. Tente novamente";
    //     }
    // }
    ?>
</body>

</html>