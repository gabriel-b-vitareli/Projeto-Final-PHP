<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/login.css">
    <title>Cadastre-se</title>
</head>

<body>
    <?php
    // include '../includes/header.php';
    // include '../includes/functions.php';
    ?>
    <main class="pagina">

        <!-- Lado esquerdo -->
        <section class="apresentacao">
            <div class="logo">
                <img src="../uploads/banner-maior.png" alt="Logo do site" width="450">
            </div>

            <h1>Comece sua jornada<br>no <span>mundo dos games.</span></h1>
            <p class="subtitulo">Crie sua conta e tenha seu próprio catálogo, avalie seus jogos e acompanhe sua evolução.</p>

            <ul class="beneficios beneficios-linha">
                <li>
                    <span class="beneficio-icone"><img src="../uploads/controle-icon.png" alt="🎮"></span>
                    <strong>Organize seu catálogo</strong>
                </li>
                <li>
                    <span class="beneficio-icone"><img src="../uploads/estrela-icon.png" alt="⭐"></span>
                    <strong>Avalie e comente</strong>
                </li>
                <li>
                    <span class="beneficio-icone"><img src="../uploads/grafico-icon.png" alt="📊"></span>
                    <strong>Acompanhe seu progresso</strong>
                </li>
            </ul>

            <p class="frase-rodape">Mais que um catálogo,<br><span>é o seu universo de jogos.</span></p>
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

            <form>
                <label for="usuario">Nome de usuário</label>
                <input type="text" id="usuario" placeholder="Escolha um nome de usuário">

                <label for="email">E-mail</label>
                <input type="text" id="email" placeholder="Digite seu e-mail">

                <label for="senha">Senha</label>
                <input type="password" id="senha" placeholder="Crie uma senha">

                <label for="confirmar-senha">Confirmar senha</label>
                <input type="password" id="confirmar-senha" placeholder="Confirme sua senha">

                <button type="submit" class="botao-entrar">Criar conta</button>

                <div class="divisor"><span>ou</span></div>

                <button type="button" class="botao-google">Cadastrar com Google</button>
            </form>

            <p class="cadastro">Já tem uma conta? <a href="login.php">Faça login</a></p>
        </section>

    </main>
    <?php

    // if(isset($_POST['email']) and isset($_POST['senha'])){
    //     echo "<hr>";
    //     cadastrarUsuario($conexao, $_POST['email'], $_POST['senha']);
    // }

    ?>
</body>

</html>