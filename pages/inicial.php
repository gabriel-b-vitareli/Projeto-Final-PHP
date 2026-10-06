<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gameshelf</title>
    <link rel="stylesheet" href="../style/homepage.css">
</head>

<body>

    <?php
    session_start();
    require_once '../includes/functions.php';
    require_once '../login/verifica-login.php';
    require_once '../includes/conexao.php';
    ?>

    <!-- Barra lateral -->
    <aside class="sidebar">
        <div class="logo">
            <img src="../uploads/banner.png" alt="Logo do site" width="450">
        </div>

        <nav class="menu" aria-label="Menu principal">
            <a class="active" href="#" aria-current="page"><svg class="i">
                    <use href="#home" />
                </svg>Início</a>
            <a href="/pages/catalogo.php"><svg class="i">
                    <use href="#pad" />
                </svg>Meu Catálogo</a>
            <a href="/pages/estatisticas.php"><svg class="i">
                    <use href="#chart" />
                </svg>Estatísticas</a>
            <a href="/pages/favoritos.php"><svg class="i">
                    <use href="#heart" />
                </svg>Favoritos</a>
            <a href="/pages/configuracoes.php"><svg class="i">
                    <use href="#gear" />
                </svg>Configurações</a>
        </nav>

        <a class="btn-add" href="#cadastrar-jogo"><svg class="i">
                <use href="#plus" />
            </svg>Cadastrar jogo</a>

        <div class="quote">
            <svg class="i">
                <use href="#pad" />
            </svg>
            <p>Grandes jogos<br>não são apenas jogados,<br>eles são vividos.</p>
        </div>
    </aside>

    <!-- Conteúdo -->
    <div class="main">
        <header class="topbar">
            <label class="search">
                <svg class="i">
                    <use href="#search" />
                </svg>
                <input type="search" placeholder="Buscar por um jogo...">
            </label>
            <div class="top-actions">
                <button class="icon-btn" aria-label="Alternar tema"><svg class="i">
                        <use href="#sun" />
                    </svg></button>
                <button class="icon-btn" aria-label="Notificações"><svg class="i">
                        <use href="#bell" />
                    </svg><i class="dot"></i></button>
                <button class="icon-btn user" aria-label="Menu do usuário">
                    <span class="avatar"></span><span>
                    </span>
                    <svg class="i" style="width:16px;height:16px">
                        <use href="#chev" />
                    </svg>
                </button>
            </div>
        </header>

        <div class="layout">
            <main>
                <section class="hero">
                    <h1>Bem-vindo de volta, <?php ?></h1>
                    <p>Seu catálogo, suas conquistas, seus jogos. Tudo em um só lugar.</p>
                    <div class="art" aria-hidden="true"></div>
                    <div class="hero-pad"></div>
                    <div class="stats">
                        <div class="stat">
                            <div class="ic"><svg class="i">
                                    <use href="#pad" />
                                </svg></div>
                            <div><small>Total de jogos</small><b>0</b></div>
                        </div>
                        <div class="stat s">
                            <div class="ic"><svg class="i" style="fill:currentColor">
                                    <use href="#star" />
                                </svg></div>
                            <div><small>Média de avaliação</small><b>0.0</b></div>
                        </div>
                        <div class="stat g">
                            <div class="ic"><svg class="i">
                                    <use href="#check" />
                                </svg></div>
                            <div><small>Jogos zerados</small><b>0</b></div>
                        </div>
                        <div class="stat">
                            <div class="ic"><svg class="i">
                                    <use href="#clock" />
                                </svg></div>
                            <div><small>Em andamento</small><b>0</b></div>
                        </div>
                    </div>
                </section>

                <section class="section">
                    <div class="sec-head">
                        <svg class="i">
                            <use href="#clock" />
                        </svg>
                        <div>
                            <h2>Jogos recentes</h2>
                            <p>Seus últimos jogos adicionados ou atualizados.</p>
                        </div>
                        <a class="link" href="#">Ver todos <svg class="i" style="width:15px;height:15px">
                                <use href="#arrow" />
                            </svg></a>
                    </div>
                    <div class="games-grid" id="jogos-recentes"></div>
                </section>

                <section class="section" style="border-top:0;padding-top:0">
                    <div class="sec-head">
                        <svg class="i">
                            <use href="#pad" />
                        </svg>
                        <div>
                            <h2>Por plataforma</h2>
                            <p>Filtre seu catálogo por plataforma.</p>
                        </div>
                    </div>
                    <div class="platforms">
                        <button class="chip active">Todas</button>
                        <button class="chip"><svg class="i">
                                <use href="#monitor" />
                            </svg>PC</button>
                        <button class="chip"><svg class="i">
                                <use href="#ps" />
                            </svg>PlayStation</button>
                        <button class="chip"><svg class="i">
                                <use href="#xbox" />
                            </svg>Xbox</button>
                        <button class="chip"><svg class="i">
                                <use href="#switch" />
                            </svg>Nintendo Switch</button>
                        <button class="chip"><svg class="i">
                                <use href="#phone" />
                            </svg>Mobile</button>
                    </div>
                </section>
            </main>

            <aside class="side">
                <section class="panel">
                    <h3><svg class="i">
                            <use href="#chart" />
                        </svg>Resumo do catálogo</h3>
                    <div class="summary">
                        <div class="donut">
                            <div><b>0</b>jogos no total</div>
                        </div>
                        <ul class="legend">
                            <li style="--c:var(--green)">Zerado<em>0</em></li>
                            <li style="--c:var(--p)">Jogando<em>0</em></li>
                            <li style="--c:var(--yellow)">Quero jogar<em>0</em></li>
                            <li style="--c:var(--pink)">Abandonado<em>0</em></li>
                        </ul>
                    </div>
                </section>

                <section class="panel">
                    <h3><svg class="i">
                            <use href="#filter" />
                        </svg>Filtros rápidos</h3>
                    <label class="field"><span>Plataforma</span>
                        <select>
                            <option>Todas</option>
                            <option>PC</option>
                            <option>PlayStation</option>
                            <option>Xbox</option>
                            <option>Nintendo Switch</option>
                            <option>Mobile</option>
                        </select>
                    </label>
                    <label class="field"><span>Status</span>
                        <select>
                            <option>Todos</option>
                            <option>Zerado</option>
                            <option>Jogando</option>
                            <option>Quero jogar</option>
                            <option>Abandonado</option>
                        </select>
                    </label>
                    <label class="field"><span>Gênero</span>
                        <select>
                            <option>Todos</option>
                        </select>
                    </label>
                    <button class="clear"><svg class="i" style="width:18px;height:18px">
                            <use href="#refresh" />
                        </svg>Limpar filtros</button>
                </section>

                <section class="panel">
                    <h3><svg class="i">
                            <use href="#star" />
                        </svg>Jogo em destaque</h3>
                    <div class="featured">
                        <div class="cover"></div>
                        <div class="info">
                            <a class="btn-details" href="#">Ver detalhes <svg class="i" style="width:15px;height:15px">
                                    <use href="#arrow" />
                                </svg></a>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </div>

</body>

</html>