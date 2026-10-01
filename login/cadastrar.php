<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/global.css">
    <title>Cadastre-se</title>
</head>
<body>
    <?php 
    include '../includes/header.php';
    include '../includes/functions.php';
    ?>
    <div align='center'> 
    <h1>Criar Conta</h1>
    <p>Faça parte da nossa comunidade e comece seu acervo!</p>
    <form action="" method="POST">

        <label for="email">Email:</label><br>
        <input type="email" name="email" required id="email"><br><br>

        <label for="username">Senha:</label><br>
        <input type="password" name="senha" required id="senha"><br><br>

        <input type="submit" value="Cadastrar Usuário">
    </form>

    </div>

    <?php 

    if(isset($_POST['email']) and isset($_POST['senha'])){
        echo "<hr>";
        cadastrarUsuario($conexao, $_POST['email'], $_POST['senha']);
    }

    ?>
</body>
</html>