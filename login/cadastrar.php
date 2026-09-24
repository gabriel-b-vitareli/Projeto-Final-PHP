<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se</title>
</head>
<body>
    <?php 
    include '../includes/header.php';
    ?>
    <h1>Cadastrar</h1>
    <form action="" method="POST">

        <label for="email">Email:</label>
        <input type="email" name="email" required id="email"><br><br>

        <label for="username">Nome de Usuário:</label>
        <input type="text" name="username" id="username"><br><br>


    </form>
</body>
</html>