# Gameshelf

Loja virtual de jogos feita em PHP puro (PDO) com PostgreSQL. Projeto de estudo: o pagamento e a entrega dos jogos ainda não existem.

## Como rodar

1. **Banco**: crie um banco (ex.: `gameshelf`) e rode os dois arquivos, nesta ordem:

   ```bash
   psql -U seu_usuario -d gameshelf -f database/schema.sql
   psql -U seu_usuario -d gameshelf -f database/seed.sql
   ```

   O `schema.sql` pode ser rodado em cima do banco que você já tem: ele só adiciona o que falta.

2. **Conexão**: copie `includes/conexao.example.php` para `includes/conexao.php` e coloque seus dados. Esse arquivo não vai pro Git.

3. **Servidor**: dentro da pasta do projeto (a raiz precisa ser a pasta do Gameshelf, porque os links começam com `/`):

   ```bash
   php -S localhost:8000
   ```

   A extensão `pdo_pgsql` precisa estar ativa no `php.ini`.

4. Abra `http://localhost:8000`.

## Capas dos jogos

Coloque as imagens em `uploads/capas/` e preencha a coluna `capa`:

```sql
UPDATE jogos SET capa = 'elden-ring.jpg' WHERE titulo = 'Elden Ring';
```

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

## Estrutura

```
index.php            landing page
login/               login, cadastro, logout, verifica-login
pages/               páginas internas (inicial, loja, jogo, carrinho, favoritos...)
acoes/               recebem os POST (favoritar, carrinho) e redirecionam
includes/            conexao, functions (banco), componentes (HTML reutilizável), header/footer
database/            schema.sql e seed.sql
style/               global, login, homepage e app (complementos)
uploads/             logos, ícones e capas
documentacao/        requisitos, paleta e banco
```

## Convenções do código

- Toda página interna começa com `login/verifica-login.php`, antes de qualquer HTML.
- Todo texto vindo do banco ou do usuário passa por `e()` antes de aparecer na tela.
- Toda consulta usa `prepare` com parâmetros. Nada de variável dentro da string SQL.
- Alterações (favoritar, carrinho) são sempre POST.
