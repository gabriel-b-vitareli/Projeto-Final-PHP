# Gameshelf

<<<<<<< HEAD
Loja virtual de jogos feita em PHP puro (PDO) com PostgreSQL. Esta é a **versão beta**: o fluxo do cliente vai da vitrine até o carrinho, e a equipe administra o catálogo por um painel próprio. Pagamento e entrega dos jogos ficam para uma versão futura.
=======
Loja virtual de jogos feita em PHP puro (PDO) com PostgreSQL. Projeto de estudo: o pagamento e a entrega dos jogos ainda não existem.
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c

## Como rodar

1. **Banco**: crie um banco (ex.: `gameshelf`) e rode os dois arquivos, nesta ordem:

   ```bash
   psql -U seu_usuario -d gameshelf -f database/schema.sql
   psql -U seu_usuario -d gameshelf -f database/seed.sql
   ```

<<<<<<< HEAD
   O `schema.sql` também pode ser rodado em cima de um banco que já existe: ele cria o que falta e remove as colunas antigas de avaliação, estoque e vendas (veja o bloco "Limpeza da versão beta" no fim do arquivo).
=======
   O `schema.sql` pode ser rodado em cima do banco que você já tem: ele só adiciona o que falta.
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c

2. **Conexão**: copie `includes/conexao.example.php` para `includes/conexao.php` e coloque seus dados. Esse arquivo não vai pro Git.

3. **Servidor**: dentro da pasta do projeto (a raiz precisa ser a pasta do Gameshelf, porque os links começam com `/`):

   ```bash
   php -S localhost:8000
   ```

<<<<<<< HEAD
   A extensão `pdo_pgsql` precisa estar ativa no `php.ini`. Para enviar imagens grandes, confira `upload_max_filesize` e `post_max_size`.

4. Abra `http://localhost:8000` e crie uma conta.

5. **Administrador**: toda conta nova é cliente (`nivel = 0`). Para ganhar acesso ao painel, rode:

   ```sql
   UPDATE usuarios SET nivel = 1 WHERE usuario = 'seu_usuario';
   ```

## O que a loja faz

**Conta**
- Cadastro e login com senha em `password_hash`, mensagens de erro no próprio formulário e sessão renovada no login.
- Contas antigas com senha em texto puro entram uma última vez e são convertidas para hash automaticamente.
- Todas as páginas internas exigem login.

**Vitrine**
- Home com dados do banco: destaque, em alta (promoções com maior desconto), novidades, mais favoritados e resumo do carrinho.
- Loja com busca (título, gênero, desenvolvedora e plataforma), filtro por plataforma e gênero e ordenação (mais populares, lançamentos, menor preço, maior preço, nome).
- Página do jogo com descrição, dados técnicos, classificação indicativa, preço e desconto.

**Favoritos**
- Coração em qualquer card e na página do jogo, mais uma página com a lista de favoritos.

**Carrinho**
- Adicionar, remover e ver o total. Jogo digital: um de cada, sem quantidade. O contador aparece no menu.
- O carrinho é o fim do fluxo nesta versão: não existe finalização de compra.

**Administração (nível 1)**
- *Gerenciar jogos*: lista todos os jogos, com editar e excluir (a exclusão pede confirmação e também apaga as imagens do disco).
- *Cadastrar jogo*: dados completos mais envio de capa, logo e banner.
- *Editar jogo*: altera todos os dados e também troca capa, logo e banner. Campos de imagem em branco mantêm a imagem atual; ao trocar, a imagem antiga é apagada do disco.
- Quem não é administrador recebe um 404 comum nessas páginas, e elas nem aparecem no menu.

## Fora do escopo da beta

Finalização de compra e pagamento, biblioteca de jogos comprados, avaliações e comentários, controle de estoque e vendas, e páginas de perfil e configurações da conta. Nada disso tem tela, tabela ou código no projeto.

## Imagens dos jogos

Cada jogo tem três imagens opcionais, enviadas pelo painel de administração:

| Imagem | Pasta | Formatos | Limite | Onde aparece |
|---|---|---|---|---|
| Capa | `uploads/capas/` | JPG, PNG, WebP | 5 MB | cards, página do jogo, carrinho |
| Logo | `uploads/logos/` | PNG, WebP (fundo transparente) | 3 MB | destaque da home, no lugar do título |
| Banner | `uploads/heros/` | JPG, PNG, WebP | 8 MB | fundo do destaque da home |

O servidor confere o conteúdo real do arquivo (não a extensão), salva com nome aleatório e cria as pastas sozinho. Sem capa, o card mostra o título do jogo. Também é possível apontar uma imagem por SQL, com o nome do arquivo ou um link `http(s)://` completo:
=======
   A extensão `pdo_pgsql` precisa estar ativa no `php.ini`.

4. Abra `http://localhost:8000`.

## Capas dos jogos

Coloque as imagens em `uploads/capas/` e preencha a coluna `capa`:
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c

```sql
UPDATE jogos SET capa = 'elden-ring.jpg' WHERE titulo = 'Elden Ring';
```

<<<<<<< HEAD
As pastas de imagens enviadas ficam fora do Git (veja `uploads/.gitignore`).
=======
Também aceita um link `http(s)://` completo. Sem capa, o card mostra o título.

## O que já funciona

- Cadastro e login (senha com `password_hash`, mensagens de erro no próprio formulário, sessão renovada no login)
- Contas antigas com senha em texto puro entram uma última vez e são convertidas para hash automaticamente
- Home com dados do banco: destaque, em alta (promoções mais vendidas), novidades, mais vendidos
- Loja com busca, filtro por plataforma e gênero e ordenação
- Página do jogo
- Favoritos (coração em qualquer card)
- Carrinho (adicionar, remover, total)

## O que ainda é só visual

- Finalizar compra / pagamento (botão desativado de propósito)
- Meus Jogos, Perfil, Configurações e Cadastrar jogo (páginas em construção)
- Botões de tema e notificações no topo
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c

## Estrutura

```
index.php            landing page
login/               login, cadastro, logout, verifica-login
<<<<<<< HEAD
pages/               páginas internas
  inicial, loja, jogo, favoritos, carrinho       (clientes)
  gerenciar-jogos, cadastrar-game, editar-jogo   (administradores)
acoes/               recebem os POST (favoritar, carrinho) e redirecionam
includes/            conexao, functions (banco), componentes (HTML reutilizável),
                     imagens (upload e preço), admin-nivel1, header/footer, icones
database/            schema.sql e seed.sql
style/               global, login, homepage e app (complementos)
uploads/             logos do site, ícones e imagens dos jogos
documentacao/        requisitos, paleta de cores e banco de dados
=======
pages/               páginas internas (inicial, loja, jogo, carrinho, favoritos...)
acoes/               recebem os POST (favoritar, carrinho) e redirecionam
includes/            conexao, functions (banco), componentes (HTML reutilizável), header/footer
database/            schema.sql e seed.sql
style/               global, login, homepage e app (complementos)
uploads/             logos, ícones e capas
documentacao/        requisitos, paleta e banco
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
```

## Convenções do código

<<<<<<< HEAD
- Toda página interna começa com `login/verifica-login.php`, antes de qualquer HTML. As páginas de administração usam `includes/admin-nivel1.php`, que já inclui essa verificação.
- Todo texto vindo do banco ou do usuário passa por `e()` antes de aparecer na tela.
- Toda consulta usa `prepare` com parâmetros. Nada de variável dentro da string SQL (a ordenação vem de uma lista fixa).
- Alterações (favoritar, carrinho, editar, excluir) são sempre POST. As de administração levam token CSRF.
- Redirecionamentos para a página de origem passam por `urlSegura()`, que só aceita caminhos internos.
=======
- Toda página interna começa com `login/verifica-login.php`, antes de qualquer HTML.
- Todo texto vindo do banco ou do usuário passa por `e()` antes de aparecer na tela.
- Toda consulta usa `prepare` com parâmetros. Nada de variável dentro da string SQL.
- Alterações (favoritar, carrinho) são sempre POST.
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
