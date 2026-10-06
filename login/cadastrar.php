<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/login.css">
    <link rel="shortcut icon" href="../uploads/favicon.ico" type="image/x-icon">
    <title>Cadastre-se</title>
</head>

<body>
    <?php
    include '../includes/functions.php';
    include '../includes/conexao.php';
    ?>
    <main class="pagina">

        <!-- Lado esquerdo -->
        <section class="apresentacao">
            <div class="logo">
                <img src="../uploads/banner-maior.png" alt="Logo do site" width="450">
            </div>

            <h1>Comece sua jornada<br>no <span>mundo dos games.</span></h1>
            <p class="subtitulo">Crie sua conta e garanta os melhores jogos, pelos melhores preços.</p>

            <ul class="beneficios beneficios-linha">
                <li>
                    <span class="beneficio-icone"><img src="../uploads/controle-icon.png" alt="🎮"></span>
                    <strong>Jogue os melhores jogos</strong>
                </li>
                <li>
                    <span class="beneficio-icone"><img src="../uploads/estrela-icon.png" alt="⭐"></span>
                    <strong>Avalie e comente</strong>
                </li>
                <li>
                    <span class="beneficio-icone"><img src="../uploads/grafico-icon.png" alt="📊"></span>
                    <strong>Pague os melhores preços</strong>
                </li>
            </ul>

            <p class="frase-rodape">Mais jogos,<br><span>mais histórias.</span></p>
        </section>

        <!-- Card de cadastro -->
        <section class="card">
            <div class="card-cabecalho">
                <span class="beneficio-icone icone-card"><img src="../uploads/user-icon.png" alt="👤"></span>
                <div>
                    <h2>Crie sua <span>conta</span></h2>
                    <p class="card-subtitulo">É rápido, gratuito e leva apenas alguns minutos.</p>
                </div>
            </div>

            <form method="POST">
                <label for="email">Nome de usuário</label>
                <input type="text" id="username" name="username" placeholder="Digite seu nome de usuário" required>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>

                <label for="confirmar-senha">Confirmar senha</label>
                <input type="password" id="confirmar-senha" name="confirmar-senha" placeholder="Confirme sua senha" required>

                <button type="submit" class="botao-entrar">Criar conta</button>

                <div class="divisor"><span>ou</span></div>
            </form>

            <p class="cadastro">Já tem uma conta? <a href="login.php">Faça login</a></p>
        </section>

    </main>
    <?php

    if(isset($_POST['username']) and isset($_POST['senha']) and isset($_POST['confirmar-senha'])){
        if($_POST['senha'] == $_POST['confirmar-senha']){
            cadastrarUsuario($conexao, $_POST['username'], $_POST['senha']);
            echo '<p class="cadastro">Conta cadastrada com sucesso!</p>';
        } else{
            echo '<p class="cadastro">Suas senhas não batem.</p>';
        }
    }

    ?>
</body>

</html>