<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php 
    include '../includes/header.php';
    ?>
    <h1>Fazer Login</h1>
    <div class="caixa">
    <form action="" method="POST">
        <label for="username">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="password">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <input type="submit" value="Entrar">
    </form>
    </div>
    <hr>
    Não tem uma conta? Clique <a href="/login/cadastrar.php">aqui</a>.
</body>
</html>