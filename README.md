# Gameshelf

Loja virtual de jogos feita em PHP puro (PDO) com PostgreSQL. Esta é a **versão beta**: o fluxo do cliente vai da vitrine até o carrinho, e a equipe administra o catálogo por um painel próprio. Pagamento e entrega dos jogos ficam para uma versão futura.

## Como rodar

1. **Banco**: crie um banco (ex.: `gameshelf`) e rode os dois arquivos, nesta ordem:

   ```bash
   psql -U seu_usuario -d gameshelf -f database/schema.sql
   psql -U seu_usuario -d gameshelf -f database/seed.sql
   ```

   O `schema.sql` também pode ser rodado em cima de um banco que já existe: ele cria o que falta e remove as colunas antigas de avaliação, estoque e vendas (veja o bloco "Limpeza da versão beta" no fim do arquivo).

2. **Conexão**: copie `includes/conexao.example.php` para `includes/conexao.php` e coloque seus dados. Esse arquivo não vai pro Git.

3. **Servidor**: dentro da pasta do projeto:

   ```bash
   php -S localhost:8000
   ```

   Os endereços das páginas são calculados automaticamente (`includes/config.php`), então o projeto funciona tanto na raiz do site (`http://localhost:8000/`) quanto numa subpasta de um servidor (`http://servidor/gameshelf/`), sem configurar nada. Para o deploy num servidor, veja a seção "Deploy em servidor Linux" mais abaixo.

   A extensão `pdo_pgsql` precisa estar ativa no `php.ini`. Para enviar imagens grandes, confira `upload_max_filesize` e `post_max_size`.

4. Abra `http://localhost:8000` e crie uma conta.

5. **Administrador**: toda conta nova é cliente (`nivel = 0`). Para ganhar acesso ao painel, rode:

   ```sql
   UPDATE usuarios SET nivel = 1 WHERE usuario = 'seu_usuario';
   ```

## Deploy em servidor Linux (Apache + PHP + PostgreSQL)

Exemplo para Debian/Ubuntu, enviando os arquivos pelo MobaXterm (SSH/SFTP).

1. **Pacotes** (no terminal SSH do servidor):

   ```bash
   sudo apt update
   sudo apt install apache2 php libapache2-mod-php php-pgsql postgresql
   ```

2. **Enviar o projeto**: no MobaXterm, arraste a pasta do projeto para o painel SFTP à esquerda. Como `/var/www/html` costuma exigir `sudo`, envie para a sua home e mova:

   ```bash
   sudo mv ~/Projeto-Final-PHP /var/www/html/gameshelf
   ```

3. **Banco**:

   ```bash
   sudo -u postgres psql -c "CREATE USER gameshelf WITH PASSWORD 'troque-esta-senha';"
   sudo -u postgres psql -c "CREATE DATABASE gameshelf OWNER gameshelf;"
   cd /var/www/html/gameshelf
   psql -h localhost -U gameshelf -d gameshelf -f database/schema.sql
   psql -h localhost -U gameshelf -d gameshelf -f database/seed.sql
   ```

4. **Conexão**: `cp includes/conexao.example.php includes/conexao.php` e ajuste usuário, senha e banco (o `conexao.php` não vai pro Git, então cada ambiente tem o seu).

5. **Permissão de escrita nos uploads** (o painel de administração grava imagens aqui):

   ```bash
   sudo chown -R www-data:www-data /var/www/html/gameshelf/uploads
   ```

6. **Acessar**: `http://IP-DO-SERVIDOR/gameshelf/`. Se preferir que o projeto fique na raiz do endereço, aponte o `DocumentRoot` do Apache para a pasta do projeto: o código funciona igual.

7. **Antes de deixar no ar**: apague o `info.php` (ele mostra a configuração do PHP para qualquer visitante) e use uma senha forte no banco.

Nginx com PHP-FPM também funciona sem mudanças no código.

**Se algo der errado**

- *Links ou CSS quebrados*: a detecção automática do endereço falhou (proxy reverso, `Alias` incomum). Crie `includes/config.local.php` com `<?php define('BASE_URL', '/gameshelf');` (use `''` se o projeto estiver na raiz). Esse arquivo também não vai pro Git.
- *"could not find driver"*: falta o `php-pgsql`; instale e rode `sudo systemctl restart apache2`.
- *Upload de imagem falha*: confira o passo 5 e os limites `upload_max_filesize` e `post_max_size` do `php.ini`.

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

```sql
UPDATE jogos SET capa = 'elden-ring.jpg' WHERE titulo = 'Elden Ring';
```

As pastas de imagens enviadas ficam fora do Git (veja `uploads/.gitignore`).

## Estrutura

```
index.php            landing page
login/               login, cadastro, logout, verifica-login
pages/               páginas internas
  inicial, loja, jogo, favoritos, carrinho       (clientes)
  gerenciar-jogos, cadastrar-game, editar-jogo   (administradores)
acoes/               recebem os POST (favoritar, carrinho) e redirecionam
includes/            config (endereço-base e url()), conexao, functions (banco),
                     componentes (HTML reutilizável), imagens (upload e preço),
                     admin-nivel1, header/footer, icones
database/            schema.sql e seed.sql
style/               global, login, homepage e app (complementos)
uploads/             logos do site, ícones e imagens dos jogos
documentacao/        requisitos, paleta de cores e banco de dados
```

## Convenções do código

- Toda página interna começa com `login/verifica-login.php`, antes de qualquer HTML. As páginas de administração usam `includes/admin-nivel1.php`, que já inclui essa verificação.
- Todo texto vindo do banco ou do usuário passa por `e()` antes de aparecer na tela.
- Toda consulta usa `prepare` com parâmetros. Nada de variável dentro da string SQL (a ordenação vem de uma lista fixa).
- Alterações (favoritar, carrinho, editar, excluir) são sempre POST. As de administração levam token CSRF.
- Redirecionamentos para a página de origem passam por `urlSegura()`, que só aceita caminhos internos do projeto.
- Nenhum endereço é escrito começando com `/` no código. Links, CSS, imagens, formulários e redirecionamentos usam `url('pages/loja.php')`, que acrescenta a subpasta do servidor quando existir. Caminhos de arquivo no disco usam `__DIR__`.
