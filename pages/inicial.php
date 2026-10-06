<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gameshelf</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style/homepage.css">
  <link rel="shortcut icon" href="../uploads/favicon.ico" type="image/x-icon">
</head>
<body>

<!--
  CONTRATO DE DADOS (para quando houver backend/template engine)
  ---------------------------------------------------------------
  Cada jogo é um <article data-game-id="..."> com:
    - capa:        <img src="{game.cover}">
    - nome:        {game.title}
    - plataformas: <li data-platform="pc|ps|xbox"> (um por plataforma)
    - nota:        <data value="{game.rating}">  + total de avaliações
    - preço:       <data value="{game.price}"> / preço original em <s>
    - desconto:    .badge--discount (renderizar só se houver desconto)
    - lançamento:  .badge--new (renderizar só se for lançamento)
  Cada <ul> / .grid abaixo é um loop: repita apenas o <li>/<article> interno.
  Imagens ficam em assets/games/ e assets/banners/.
-->

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="i-home" viewBox="0 0 24 24"><path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></symbol>
  <symbol id="i-bag" viewBox="0 0 24 24"><path d="M6 8h12l1 12H5z"/><path d="M9 8a3 3 0 0 1 6 0"/></symbol>
  <symbol id="i-pad" viewBox="0 0 24 24"><path d="M6 8h12a4 4 0 0 1 4 4v3a3 3 0 0 1-5.200 2L15 15H9l-1.800 2A3 3 0 0 1 2 15v-3a4 4 0 0 1 4-4z"/><path d="M7 11v3M5.500 12.500h3"/><circle cx="16" cy="11.500" r=".8"/></symbol>
  <symbol id="i-heart" viewBox="0 0 24 24"><path d="M12 20s-8-5-8-11a4.500 4.500 0 0 1 8-2.500A4.500 4.500 0 0 1 20 9c0 6-8 11-8 11z"/></symbol>
  <symbol id="i-cart" viewBox="0 0 24 24"><path d="M3 4h2l2.500 11h10L20 7H6"/><circle cx="9" cy="19" r="1.500"/><circle cx="17" cy="19" r="1.500"/></symbol>
  <symbol id="i-gear" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="8" stroke-dasharray="3 2.500"/></symbol>
  <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></symbol>
  <symbol id="i-sun" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.900 4.900 7 7M17 17l2.100 2.100M4.900 19.100 7 17M17 7l2.100-2.100"/></symbol>
  <symbol id="i-bell" viewBox="0 0 24 24"><path d="M6 16v-5a6 6 0 0 1 12 0v5l2 2H4zM10 21h4"/></symbol>
  <symbol id="i-down" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></symbol>
  <symbol id="i-x" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6 6 18"/></symbol>
  <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
  <symbol id="i-star" viewBox="0 0 24 24"><path d="m12 3 2.800 5.800 6.200.9-4.500 4.400 1.100 6.200L12 17.300l-5.600 3 1.100-6.200L3 9.700l6.200-.9z"/></symbol>
  <symbol id="i-flame" viewBox="0 0 24 24"><path d="M12 3c1 4 5 6 5 11a5 5 0 0 1-10 0c0-2 1-3 2-4 0 2 1 3 2 3 0-4-1-6 1-10z"/></symbol>
  <symbol id="i-crown" viewBox="0 0 24 24"><path d="m3 8 4.500 4L12 5l4.500 7L21 8l-2 11H5z"/></symbol>
  <symbol id="i-trophy" viewBox="0 0 24 24"><path d="M8 4h8v6a4 4 0 0 1-8 0zM8 6H4v1a4 4 0 0 0 4 4M16 6h4v1a4 4 0 0 1-4 4M12 14v4M8 20h8"/></symbol>
  <symbol id="i-copy" viewBox="0 0 24 24"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V6a2 2 0 0 1 2-2h8"/></symbol>
  <symbol id="i-ticket" viewBox="0 0 24 24"><path d="M4 8h16v3a2 2 0 0 0 0 4v3H4v-3a2 2 0 0 0 0-4z"/></symbol>
</svg>

<div class="app">

  <!-- ============ SIDEBAR ============ -->
  <aside class="sidebar">
    <a class="logo" href="/">
      <div class="logo">
        <img src="../uploads/banner-maior.png" alt="Logo do site" width="450">
      </div>
    </a>

    <nav class="nav" aria-label="Principal">
      <a class="nav__item is-active" href="/" aria-current="page"><svg class="icon fill"><use href="#i-home"/></svg><span>Início</span></a>
      <a class="nav__item" href="/pages/loja.php"><svg class="icon"><use href="#i-bag"/></svg><span>Loja</span></a>
      <a class="nav__item" href="/pages/meus-jogos.php"><svg class="icon"><use href="#i-pad"/></svg><span>Meus Jogos</span></a>
      <a class="nav__item" href="/pages/favoritos.php"><svg class="icon"><use href="#i-heart"/></svg><span>Favoritos</span></a>
      <a class="nav__item" href="/pages/carrinho.php"><svg class="icon"><use href="#i-cart"/></svg><span>Carrinho</span><span class="count">3</span></a>
      <a class="nav__item" href="/pages/configuracoes.php"><svg class="icon"><use href="#i-gear"/></svg><span>Configurações</span></a>
    </nav>
  </aside>

  <!-- ============ TOPO ============ -->
  <header class="topbar">
    <label class="search">
      <svg class="icon"><use href="#i-search"/></svg>
      <input type="search" name="q" placeholder="Buscar por jogos, gêneros, plataformas...">
    </label>
    <div class="topbar__actions">
      <button class="icon-btn" type="button" aria-label="Alternar tema"><svg class="icon"><use href="#i-sun"/></svg></button>
      <button class="icon-btn has-dot" type="button" aria-label="Notificações"><svg class="icon"><use href="#i-bell"/></svg></button>
      <a class="user" href="/perfil">
        <img class="user__avatar" src="assets/users/avatar.jpg" alt="">
        <span>(nome do usuario vem aqui depois)</span>
        <svg class="icon"><use href="#i-down"/></svg>
      </a>
    </div>
  </header>

  <!-- ============ CONTEÚDO ============ -->
  <main class="content">
    <div class="content__main">

      <!-- Destaque (hero) — um item por slide -->
      <section class="hero" aria-label="Destaque">
        <img class="hero__bg" src="assets/banners/sekiro.jpg" alt="">
        <div class="hero__body">
          <h1>NomedoJogo<small>Segundo nome do jogo</small></h1>
          <p class="hero__desc">Descrição do jogo</p>
          <p class="hero__price">
            <s>R$ preço do jogo</s>
          </p>
          <div class="hero__actions">
            <a class="btn btn--primary" href="#"><svg class="icon"><use href="#i-cart"/></svg>Comprar agora</a>
         </div>
        </div>
      </section>

      <!-- Em alta agora -->
      <section class="section">
        <header class="section__head">
          <svg class="icon section__icon"><use href="#i-flame"/></svg>
          <div><h2>Em alta agora</h2><p>Os jogos mais vendidos da semana.</p></div>
          <a class="link" href="/pages/loja.php">Ver todos <svg class="icon"><use href="#i-arrow"/></svg></a>
        </header>

        <ul class="grid">
          <!-- LOOP: jogos em alta -->
          <li><article class="card" data-game-id="elden-ring">
            <a class="card__cover" href="/jogo/elden-ring"><img src="assets/games/elden-ring.jpg" alt="" loading="lazy"></a>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <ul class="platforms"><li>PC</li><li>PS</li><li class="x">Xbox</li></ul>
              <h3 class="card__title">Elden Ring</h3>
              <p class="rating"><svg class="icon fill"><use href="#i-star"/></svg><data value="4.9">4.9</data> <span>(12.4k)</span></p>
              <p class="price"><data value="199.90">R$ 199,90</data><s>R$ 249,90</s><span class="badge badge--discount">-20%</span></p>
            </div>
          </article></li>
          <li><article class="card" data-game-id="hogwarts-legacy">
            <a class="card__cover" href="/jogo/hogwarts-legacy"><img src="assets/games/hogwarts-legacy.jpg" alt="" loading="lazy"></a>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <ul class="platforms"><li>PC</li><li>PS</li><li class="x">Xbox</li></ul>
              <h3 class="card__title">Hogwarts Legacy</h3>
              <p class="rating"><svg class="icon fill"><use href="#i-star"/></svg><data value="4.7">4.7</data> <span>(8.9k)</span></p>
              <p class="price"><data value="179.90">R$ 179,90</data><s>R$ 229,90</s><span class="badge badge--discount">-22%</span></p>
            </div>
          </article></li>
          <li><article class="card" data-game-id="red-dead-redemption-2">
            <a class="card__cover" href="/jogo/red-dead-redemption-2"><img src="assets/games/red-dead-redemption-2.jpg" alt="" loading="lazy"></a>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <ul class="platforms"><li>PC</li><li>PS</li><li class="x">Xbox</li></ul>
              <h3 class="card__title">Red Dead Redemption 2</h3>
              <p class="rating"><svg class="icon fill"><use href="#i-star"/></svg><data value="4.8">4.8</data> <span>(15.2k)</span></p>
              <p class="price"><data value="149.90">R$ 149,90</data><s>R$ 199,90</s><span class="badge badge--discount">-25%</span></p>
            </div>
          </article></li>
          <li><article class="card" data-game-id="god-of-war-ragnarok">
            <a class="card__cover" href="/jogo/god-of-war-ragnarok"><img src="assets/games/god-of-war-ragnarok.jpg" alt="" loading="lazy"></a>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <ul class="platforms"><li>PS</li></ul>
              <h3 class="card__title">God of War Ragnarök</h3>
              <p class="rating"><svg class="icon fill"><use href="#i-star"/></svg><data value="4.9">4.9</data> <span>(10.7k)</span></p>
              <p class="price"><data value="199.90">R$ 199,90</data><s>R$ 249,90</s><span class="badge badge--discount">-20%</span></p>
            </div>
          </article></li>
          <li><article class="card" data-game-id="the-last-of-us-part-1">
            <a class="card__cover" href="/jogo/the-last-of-us-part-1"><img src="assets/games/the-last-of-us-part-1.jpg" alt="" loading="lazy"></a>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <ul class="platforms"><li>PS</li></ul>
              <h3 class="card__title">The Last of Us Part I</h3>
              <p class="rating"><svg class="icon fill"><use href="#i-star"/></svg><data value="4.8">4.8</data> <span>(13.6k)</span></p>
              <p class="price"><data value="189.90">R$ 189,90</data><s>R$ 239,90</s><span class="badge badge--discount">-21%</span></p>
            </div>
          </article></li>
        </ul>
      </section>

      <!-- Novidades -->
      <section class="section">
        <header class="section__head">
          <svg class="icon section__icon"><use href="#i-star"/></svg>
          <div><h2>Novidades na loja</h2><p>Lançamentos e jogos em destaque para você.</p></div>
          <a class="link" href="/loja?ordem=novidades">Ver todos <svg class="icon"><use href="#i-arrow"/></svg></a>
        </header>

        <ul class="grid">
          <!-- LOOP: novidades. Variante compacta: preço e nota na mesma linha -->
          <li><article class="card card--compact" data-game-id="starfield">
            <a class="card__cover" href="/jogo/starfield"><img src="assets/games/starfield.jpg" alt="" loading="lazy"></a>
            <span class="badge badge--new card__flag">Lançamento</span>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <h3 class="card__title">Starfield</h3>
              <ul class="platforms"><li>PC</li><li class="x">Xbox</li></ul>
              <p class="price"><data value="249.90">R$ 249,90</data><span class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.5 <span>(3.2k)</span></span></p>
            </div>
          </article></li>
          <li><article class="card card--compact" data-game-id="forza-motorsport">
            <a class="card__cover" href="/jogo/forza-motorsport"><img src="assets/games/forza-motorsport.jpg" alt="" loading="lazy"></a>
            <span class="badge badge--new card__flag">Lançamento</span>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <h3 class="card__title">Forza Motorsport</h3>
              <ul class="platforms"><li>PC</li><li class="x">Xbox</li></ul>
              <p class="price"><data value="299.90">R$ 299,90</data><span class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.7 <span>(2.8k)</span></span></p>
            </div>
          </article></li>
          <li><article class="card card--compact" data-game-id="baldurs-gate-3">
            <a class="card__cover" href="/jogo/baldurs-gate-3"><img src="assets/games/baldurs-gate-3.jpg" alt="" loading="lazy"></a>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <h3 class="card__title">Baldur's Gate 3</h3>
              <ul class="platforms"><li>PC</li><li>PS</li></ul>
              <p class="price"><data value="249.90">R$ 249,90</data><span class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.9 <span>(25.4k)</span></span></p>
            </div>
          </article></li>
          <li><article class="card card--compact" data-game-id="marvels-spider-man-2">
            <a class="card__cover" href="/jogo/marvels-spider-man-2"><img src="assets/games/marvels-spider-man-2.jpg" alt="" loading="lazy"></a>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <h3 class="card__title">Marvel's Spider-Man 2</h3>
              <ul class="platforms"><li>PS</li></ul>
              <p class="price"><data value="299.90">R$ 299,90</data><span class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.8 <span>(18.7k)</span></span></p>
            </div>
          </article></li>
          <li><article class="card card--compact" data-game-id="alan-wake-2">
            <a class="card__cover" href="/jogo/alan-wake-2"><img src="assets/games/alan-wake-2.jpg" alt="" loading="lazy"></a>
            <button class="fav" type="button" aria-label="Favoritar"><svg class="icon"><use href="#i-heart"/></svg></button>
            <div class="card__body">
              <h3 class="card__title">Alan Wake 2</h3>
              <ul class="platforms"><li>PC</li><li>PS</li></ul>
              <p class="price"><data value="249.90">R$ 249,90</data><span class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.6 <span>(9.1k)</span></span></p>
            </div>
          </article></li>
        </ul>
      </section>
    </div>

    <!-- ============ COLUNA DIREITA ============ -->
    <aside class="content__side">

      <!-- Carrinho -->
      <section class="panel">
        <h2 class="panel__title"><svg class="icon"><use href="#i-cart"/></svg>Meu carrinho <span class="count">3</span></h2>
        <ul class="cart">
          <!-- LOOP: itens do carrinho -->
          <li class="cart__item" data-game-id="elden-ring">
            <img src="assets/games/elden-ring.jpg" alt="">
            <div><h3>Elden Ring</h3><data value="199.90">R$ 199,90</data></div>
            <button type="button" aria-label="Remover Elden Ring"><svg class="icon"><use href="#i-x"/></svg></button>
          </li>
          <li class="cart__item" data-game-id="hogwarts-legacy">
            <img src="assets/games/hogwarts-legacy.jpg" alt="">
            <div><h3>Hogwarts Legacy</h3><data value="179.90">R$ 179,90</data></div>
            <button type="button" aria-label="Remover Hogwarts Legacy"><svg class="icon"><use href="#i-x"/></svg></button>
          </li>
          <li class="cart__item" data-game-id="god-of-war-ragnarok">
            <img src="assets/games/god-of-war-ragnarok.jpg" alt="">
            <div><h3>God of War Ragnarök</h3><data value="199.90">R$ 199,90</data></div>
            <button type="button" aria-label="Remover God of War Ragnarök"><svg class="icon"><use href="#i-x"/></svg></button>
          </li>
        </ul>
        <a class="btn btn--primary btn--block" href="/checkout">Finalizar compra <svg class="icon"><use href="#i-arrow"/></svg></a>
      </section>

      <!-- Cupom -->
      <section class="panel promo">
        <div class="promo__head">
          <span class="promo__icon"><svg class="icon"><use href="#i-ticket"/></svg></span>
          <div>
            <h2>Ganhe 10% de desconto na sua primeira compra!</h2>
            <p>Use o cupom <b>BEMVINDO10</b><br>no checkout.</p>
          </div>
        </div>
        <div class="coupon"><code>BEMVINDO10</code><button type="button" aria-label="Copiar cupom"><svg class="icon"><use href="#i-copy"/></svg></button></div>
      </section>

      <!-- Mais vendidos -->
      <section class="panel">
        <h2 class="panel__title"><svg class="icon"><use href="#i-trophy"/></svg>Mais vendidos</h2>
        <ol class="rank">
          <!-- LOOP: ranking (o número vem do contador do loop) -->
          <li class="rank__item" data-game-id="elden-ring">
            <span class="rank__pos">1</span>
            <img src="assets/games/elden-ring.jpg" alt="">
            <div><h3>Elden Ring</h3><data value="199.90">R$ 199,90</data><p class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.9</p></div>
          </li>
          <li class="rank__item" data-game-id="red-dead-redemption-2">
            <span class="rank__pos">2</span>
            <img src="assets/games/red-dead-redemption-2.jpg" alt="">
            <div><h3>Red Dead Redemption 2</h3><data value="149.90">R$ 149,90</data><p class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.8</p></div>
          </li>
          <li class="rank__item" data-game-id="god-of-war-ragnarok">
            <span class="rank__pos">3</span>
            <img src="assets/games/god-of-war-ragnarok.jpg" alt="">
            <div><h3>God of War Ragnarök</h3><data value="199.90">R$ 199,90</data><p class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.9</p></div>
          </li>
          <li class="rank__item" data-game-id="hogwarts-legacy">
            <span class="rank__pos">4</span>
            <img src="assets/games/hogwarts-legacy.jpg" alt="">
            <div><h3>Hogwarts Legacy</h3><data value="179.90">R$ 179,90</data><p class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.7</p></div>
          </li>
          <li class="rank__item" data-game-id="the-last-of-us-part-1">
            <span class="rank__pos">5</span>
            <img src="assets/games/the-last-of-us-part-1.jpg" alt="">
            <div><h3>The Last of Us Part I</h3><data value="189.90">R$ 189,90</data><p class="rating"><svg class="icon fill"><use href="#i-star"/></svg>4.8</p></div>
          </li>
        </ol>
      </section>
    </aside>
  </main>
</div>
</body>
</html>