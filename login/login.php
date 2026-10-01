<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/global.css">
    <title>Login</title>
</head>

<body>
    <?php
    include '../includes/header.php';
    include '../includes/functions.php';
    session_start();
    ?>
    <h1>Fazer Login</h1>
    <div class="caixa">
        <form action="" method="POST">
            <label for="username">E-Mail:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Senha:</label>
            <input type="password" id="senha" name="senha" required><br><br>

            <input class=".btn" type="submit" value="Entrar">
        </form>
    </div>
    <hr>
    Não tem uma conta? Clique <a href="/login/cadastrar.php">aqui</a>.

    <?php
    if (isset($_POST['email']) and isset($_POST['senha'])) {
        $usuario = consultarUsuario($conexao, $_POST['email']);
        if ($_POST['email'] == $usuario['email'] && $_POST['senha'] == $usuario['senha']) {
            $_SESSION['id'] = $usuario['id'];
            echo "<hr>Login aceito.";
            sleep(5);
            header("Location: ../index.php");
        } else {
            echo "<hr>Usuário inexistente. Tente novamente";
        }
    }
    ?>
</body>

</html>