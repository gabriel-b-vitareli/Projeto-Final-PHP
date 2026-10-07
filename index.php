<?php
session_start();
if (isset($_SESSION['id'])) {
    header("Location: /pages/inicial.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="shortcut icon" href="/uploads/favicon.ico" type="image/x-icon">
    <style>
        .botoes-login {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border-radius: 25px;
            position: relative;
            /* Necessário para posicionar o brilho */
            overflow: hidden;
            /* Mantém o brilho dentro das bordas arredondadas */

            /* Transição Suave */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);

            /* ESTADO PADRÃO */
            background-color: transparent;
            color: #b0b0b0;
            border: 1px solid #332A42;
        }

        /* Camada interna do brilho reativo */
        .botoes-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.25),
                    transparent);
            transition: left 0.5s ease;
        }

        /* ESTADO HOVER */
        .botoes-login:hover {
            background-color: #8B5CF6;
            color: #FAF5FF;
            border-color: #A78BFA;
            transform: translateY(-2px);
            /* Leve elevação ao passar o mouse */

            /* Brilho Neon Externo Expandido */
            box-shadow:
                0 0 12px rgba(139, 92, 246, 0.6),
                0 0 24px rgba(167, 139, 250, 0.3);
        }

        /* Animação do raio de luz cruzando o botão */
        .botoes-login:hover::before {
            left: 100%;
        }

        footer {
            height: 50px;
            background-color: #15121F;
            /* Fundo secundário */
            border: 1px solid #332A42;
            /* Borda do card/painel */
            padding: 1rem 2rem;
            /* Espaçamento interno */
            text-align: center;
            /* Centralização do texto */
            color: #A8A29E;
            /* Texto secundário/suave */
            font-size: 0.85rem;
            /* Tamanho de fonte reduzido */
            box-shadow: 0 40px 20px rgba(0, 0, 0, 0.4);
            /* Sombra suave */
        }

        header {
            background-color: #15121F;
            /* Fundo secundário */
            border: 1px solid #332A42;
            /* Borda do card/painel */
            padding: 1rem 2rem;
            /* Espaçamento interno */
            text-align: center;
            /* Centralização do texto */
            color: #A8A29E;
            /* Texto secundário/suave */
            font-size: 0.85rem;
            /* Tamanho de fonte reduzido */
            box-shadow: 0 40px 20px rgba(0, 0, 0, 0.4);
            /* Sombra suave */
        }

        /* Contêiner principal das colunas */
        .servicos-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            max-width: 900px;
            margin: 0 auto;
        }

        /* Coluna individual */
        .servico-item {
            flex: 1;
            text-align: center;
            padding: 0 1.5rem;
            /* Linha vertical separadora à direita */
            border-right: 1px solid #332A42;
        }

        /* Remove a linha separadora do último item */
        .servico-item:last-child {
            border-right: none;
        }

        /* Ícone no topo */
        .servico-item .icone {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        /* Título */
        .servico-item h3 {
            color: #FAF5FF;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        /* Número destacado no título */
        .servico-item h3 span {
            color: #C084FC;
        }

        /* Descrição abaixo do título */
        .servico-item p {
            color: #A8A29E;
            font-size: 0.85rem;
            line-height: 1.4;
            margin: 0;
        }

        .icone {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            margin: 0 auto 16px;
            /* centraliza a caixa e dá espaço pro título */
        }

        .icone img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
    <title>GameShelf</title>
</head>

<body>

    <header>
        <div align='center'>
            <img src="/uploads/banner.png" alt="Banner GameShelf" height='50px'>
        </div>
    </header>
    <br>
    <div align='center'>
        <h1>Organize, avalie e registre<br>toda sua jornada gamer.</h1>
        <br>
        <p>Acompanhe seus jogos concluídos, crie diários de avaliação e<br>gerencie seu catálogo pessoal em um só lugar.</p>
    </div>

    <br>

    <div align='center'>
        <a class='botoes-login' href="/login/cadastrar.php">CRIAR CONTA GRÁTIS</a>
        <a class='botoes-login' href="/login/login.php">JÁ TENHO UMA CONTA</a>
    </div>

    <br>
    <br>

    <div class="servicos-container">

        <div class="servico-item">
            <div class="icone"><img src="/uploads/pasta-icon.png" alt="🗂️"></div>
            <h3><span>1.</span> Organização Total</h3>
            <p>Cadastre jogos por plataforma, gênero e status</p>
        </div>

        <div class="servico-item">
            <div class="icone"><img src="/uploads/estrela-icon.png" alt="⭐"></div>
            <h3><span>2.</span> Avaliações e Notas</h3>
            <p>Atribua estrelas e escreva resenhas</p>
        </div>

        <div class="servico-item">
            <div class="icone"><img src="/uploads/grafico-icon.png" alt="📊"></div>
            <h3><span>3.</span> Estatísticas e Filtros</h3>
            <p>Consulte dados do seu acervo e aplique filtros</p>
        </div>

    </div>

    <br><br>

    <div align='center'>
        <footer>
            &copy; 2026 GameShelf - Seu catálogo pessoal
        </footer>
    </div>
</body>

</html>