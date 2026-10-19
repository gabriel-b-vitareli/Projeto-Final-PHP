<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420
# Gameshelf: Requisitos (versão beta)

Loja virtual de jogos digitais. Na beta, o cliente navega pelo catálogo, favorita jogos e monta um carrinho; a equipe administra o catálogo. Todos os requisitos abaixo estão implementados.

## Perfis de usuário

| Perfil | Como é definido | O que pode fazer |
|---|---|---|
| Visitante | Não está logado | Ver a landing page, criar conta e entrar |
| Cliente | `usuarios.nivel = 0` | Tudo da loja: vitrine, busca, favoritos e carrinho |
| Administrador | `usuarios.nivel = 1` | Tudo do cliente, mais cadastrar, editar e excluir jogos |
<<<<<<< HEAD
=======

## Requisitos Funcionais

### Conta e acesso

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF01 | Criar conta | O visitante cria uma conta com nome de usuário e senha, confirmando a senha. | Alta |
| RF02 | Validar cadastro | O nome de usuário tem de 3 a 30 caracteres (letras, números, ponto, hífen, underline) e é único sem diferenciar maiúsculas e minúsculas; a senha tem no mínimo 6 caracteres e deve bater com a confirmação. | Alta |
| RF03 | Entrar | O usuário entra com nome e senha. Erro de login usa a mesma mensagem para usuário inexistente e senha errada. | Alta |
| RF04 | Sair | O usuário encerra a sessão pelo menu. | Alta |
| RF05 | Restringir acesso | As páginas internas só abrem para usuários logados; os demais vão para o login. | Alta |

### Vitrine

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF06 | Página inicial | Mostra o jogo em destaque, "Em alta" (promoções com maior desconto), "Novidades", "Mais favoritados" e o resumo do carrinho. | Alta |
| RF07 | Listar jogos | A loja lista todos os jogos do catálogo em cards com capa, plataformas, título e preço (com desconto, quando houver). | Alta |
| RF08 | Pesquisar | Busca por título, gênero, desenvolvedora ou plataforma, sem diferenciar maiúsculas e minúsculas. A busca está disponível no topo de todas as páginas internas. | Alta |
| RF09 | Filtrar por plataforma | Filtra por PC, PS, Xbox ou Switch. | Média |
| RF10 | Filtrar por gênero | Filtra pelos gêneros existentes no catálogo. | Média |
| RF11 | Ordenar | Ordena por mais populares, lançamentos, menor preço, maior preço ou nome (A-Z). | Média |
| RF12 | Ver detalhes | A página do jogo mostra capa, plataformas, descrição, gênero, desenvolvedora, data de lançamento, classificação indicativa, preço e percentual de desconto. | Alta |
| RF13 | Sinalizar lançamentos | Jogos lançados nos últimos 90 dias recebem a marca "Lançamento" nas Novidades. | Baixa |

### Favoritos

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF14 | Favoritar | O cliente marca ou desmarca um jogo como favorito pelo coração, em qualquer card ou na página do jogo. | Média |
| RF15 | Listar favoritos | Uma página lista os jogos favoritos, dos mais recentes para os mais antigos. | Média |

### Carrinho

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF16 | Adicionar ao carrinho | O cliente adiciona um jogo pela página do jogo ou pelo destaque da home. Adicionar de novo não duplica o item. | Alta |
| RF17 | Remover do carrinho | O cliente remove um jogo pela página do carrinho ou pelo resumo lateral da home. | Alta |
| RF18 | Ver carrinho | A página do carrinho lista os itens e mostra o total. | Alta |
| RF19 | Contador no menu | O menu lateral mostra a quantidade de itens no carrinho. | Baixa |

### Administração (nível 1)

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF20 | Gerenciar jogos | Lista todos os jogos com atalhos para editar e excluir. | Alta |
| RF21 | Cadastrar jogo | Cadastra título, plataformas, gênero, desenvolvedora, lançamento, classificação, preço, preço original, descrição e destaque. | Alta |
| RF22 | Enviar imagens | No cadastro, envia capa, logo e banner (todos opcionais). | Média |
| RF23 | Editar jogo | Altera todos os dados de um jogo já cadastrado. | Alta |
| RF24 | Trocar imagens | Na edição, substitui capa, logo e banner. Campos em branco mantêm a imagem atual; a imagem substituída é apagada do disco. | Média |
| RF25 | Excluir jogo | Remove o jogo (com seus favoritos e itens de carrinho) e apaga suas imagens do disco, após confirmação do administrador. | Alta |
| RF26 | Validar jogo | O sistema valida os campos antes de salvar: título, ao menos uma plataforma, gênero, data válida, preço válido e preço original maior que o atual. | Alta |
=======
# Sistema de Catálogo Pessoal de Jogos
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420

## Requisitos Funcionais

### Conta e acesso

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF01 | Criar conta | O visitante cria uma conta com nome de usuário e senha, confirmando a senha. | Alta |
| RF02 | Validar cadastro | O nome de usuário tem de 3 a 30 caracteres (letras, números, ponto, hífen, underline) e é único sem diferenciar maiúsculas e minúsculas; a senha tem no mínimo 6 caracteres e deve bater com a confirmação. | Alta |
| RF03 | Entrar | O usuário entra com nome e senha. Erro de login usa a mesma mensagem para usuário inexistente e senha errada. | Alta |
| RF04 | Sair | O usuário encerra a sessão pelo menu. | Alta |
| RF05 | Restringir acesso | As páginas internas só abrem para usuários logados; os demais vão para o login. | Alta |

<<<<<<< HEAD
### Vitrine

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF06 | Página inicial | Mostra o jogo em destaque, "Em alta" (promoções com maior desconto), "Novidades", "Mais favoritados" e o resumo do carrinho. | Alta |
| RF07 | Listar jogos | A loja lista todos os jogos do catálogo em cards com capa, plataformas, título e preço (com desconto, quando houver). | Alta |
| RF08 | Pesquisar | Busca por título, gênero, desenvolvedora ou plataforma, sem diferenciar maiúsculas e minúsculas. A busca está disponível no topo de todas as páginas internas. | Alta |
| RF09 | Filtrar por plataforma | Filtra por PC, PS, Xbox ou Switch. | Média |
| RF10 | Filtrar por gênero | Filtra pelos gêneros existentes no catálogo. | Média |
| RF11 | Ordenar | Ordena por mais populares, lançamentos, menor preço, maior preço ou nome (A-Z). | Média |
| RF12 | Ver detalhes | A página do jogo mostra capa, plataformas, descrição, gênero, desenvolvedora, data de lançamento, classificação indicativa, preço e percentual de desconto. | Alta |
| RF13 | Sinalizar lançamentos | Jogos lançados nos últimos 90 dias recebem a marca "Lançamento" nas Novidades. | Baixa |

### Favoritos

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF14 | Favoritar | O cliente marca ou desmarca um jogo como favorito pelo coração, em qualquer card ou na página do jogo. | Média |
| RF15 | Listar favoritos | Uma página lista os jogos favoritos, dos mais recentes para os mais antigos. | Média |

### Carrinho

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF16 | Adicionar ao carrinho | O cliente adiciona um jogo pela página do jogo ou pelo destaque da home. Adicionar de novo não duplica o item. | Alta |
| RF17 | Remover do carrinho | O cliente remove um jogo pela página do carrinho ou pelo resumo lateral da home. | Alta |
| RF18 | Ver carrinho | A página do carrinho lista os itens e mostra o total. | Alta |
| RF19 | Contador no menu | O menu lateral mostra a quantidade de itens no carrinho. | Baixa |

### Administração (nível 1)

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF20 | Gerenciar jogos | Lista todos os jogos com atalhos para editar e excluir. | Alta |
| RF21 | Cadastrar jogo | Cadastra título, plataformas, gênero, desenvolvedora, lançamento, classificação, preço, preço original, descrição e destaque. | Alta |
| RF22 | Enviar imagens | No cadastro, envia capa, logo e banner (todos opcionais). | Média |
| RF23 | Editar jogo | Altera todos os dados de um jogo já cadastrado. | Alta |
| RF24 | Trocar imagens | Na edição, substitui capa, logo e banner. Campos em branco mantêm a imagem atual; a imagem substituída é apagada do disco. | Média |
| RF25 | Excluir jogo | Remove o jogo (com seus favoritos e itens de carrinho) e apaga suas imagens do disco, após confirmação do administrador. | Alta |
| RF26 | Validar jogo | O sistema valida os campos antes de salvar: título, ao menos uma plataforma, gênero, data válida, preço válido e preço original maior que o atual. | Alta |
=======
---
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420

## Requisitos Não Funcionais

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420
| RNF01 | Tecnologia | PHP puro com PDO e banco relacional PostgreSQL. | Alta |
| RNF02 | Segurança de senhas | Senhas guardadas com `password_hash`; contas antigas em texto puro são convertidas no primeiro login. | Alta |
| RNF03 | Injeção de SQL | Toda consulta usa `prepare` com parâmetros; a ordenação vem de uma lista fixa. | Alta |
| RNF04 | XSS | Todo texto vindo do banco ou do usuário é escapado com `e()` antes de ser exibido. | Alta |
| RNF05 | CSRF | Ações de administração exigem token CSRF; alterações do cliente são feitas somente por POST. | Alta |
| RNF06 | Controle de acesso | As páginas de administração respondem 404 a quem não é nível 1, sem revelar que existem. | Alta |
| RNF07 | Redirecionamento seguro | Os retornos pós-ação só aceitam caminhos internos do site. | Média |
| RNF08 | Upload seguro | O servidor confere o conteúdo real da imagem (não a extensão), limita tipo e tamanho, usa nome aleatório e não deixa arquivos órfãos se o banco falhar. | Alta |
| RNF09 | Integridade dos dados | O banco usa chaves primárias, chaves estrangeiras com `ON DELETE CASCADE` e restrições `NOT NULL`/`UNIQUE`; a aplicação valida os campos antes de gravar. | Alta |
| RNF10 | Tratamento de erros | Erros de formulário e avisos de ação aparecem em mensagens claras na própria tela. | Alta |
| RNF11 | Confirmação de operações | A exclusão de jogo exige confirmação do administrador. | Alta |
| RNF12 | Organização do código | Código separado por responsabilidade: `login/`, `pages/`, `acoes/`, `includes/`, `database/` e `style/`. | Alta |
| RNF13 | Reutilização | Conexão com o banco centralizada em `includes/conexao.php`; consultas em `functions.php`; HTML repetido em `componentes.php`; upload em `imagens.php`. | Alta |
| RNF14 | Responsividade | A interface se adapta a computadores, tablets e celulares. | Média |
| RNF15 | Identidade visual | Tema escuro com a paleta descrita em `paleta-cores.md`, voltado ao universo dos videogames. | Média |
| RNF16 | Portabilidade | Roda com `php -S` e PostgreSQL, sem dependências externas além da extensão `pdo_pgsql`. | Média |
<<<<<<< HEAD
=======

## Fora do escopo da beta

Não fazem parte desta versão, e não existem no código nem no banco:

- Finalizar compra, pagamento e entrega: o fluxo do cliente termina no carrinho.
- Biblioteca de jogos comprados (Meus Jogos).
- Avaliações e comentários dos usuários.
- Controle de estoque e contagem de vendas.
- Páginas de perfil e de configurações da conta.
=======
| RNF01 | Usabilidade | A interface deve ser simples, intuitiva e fácil de utilizar. | Alta |
| RNF02 | Responsividade | O sistema deve funcionar adequadamente em computadores, tablets e smartphones. | Média |
| RNF03 | Desempenho | As páginas principais devem carregar rapidamente, sem consultas ou processos desnecessariamente pesados. | Média |
| RNF04 | Segurança | O sistema deve validar e tratar os dados enviados pelos formulários antes de armazená-los no banco de dados. | Alta |
| RNF05 | Integridade dos dados | O sistema deve evitar o armazenamento de dados inválidos ou incompletos nos campos obrigatórios. | Alta |
| RNF06 | Banco de dados | Os dados devem ser armazenados em um banco de dados relacional MySQL. | Alta |
| RNF07 | Organização do código | O código deve ser organizado em arquivos separados de acordo com suas responsabilidades. | Alta |
| RNF08 | Reutilização | A conexão com o banco de dados deve ser centralizada e reutilizada pelas páginas do sistema. | Alta |
| RNF09 | Manutenibilidade | O sistema deve possuir código organizado e comentado de forma que futuras alterações sejam facilitadas. | Média |
| RNF10 | Compatibilidade | O sistema deve funcionar nos principais navegadores modernos, como Chrome, Firefox, Edge e Safari. | Média |
| RNF11 | Interface visual | O sistema deve possuir uma identidade visual relacionada ao universo dos videogames. | Média |
| RNF12 | Legibilidade | Textos, botões, formulários e informações devem possuir boa legibilidade e organização visual. | Média |
| RNF13 | Tratamento de erros | O sistema deve apresentar mensagens claras ao usuário quando ocorrerem erros ou dados inválidos. | Alta |
| RNF14 | Confirmação de operações | Operações que possam causar perda de dados, como exclusão, devem exigir confirmação do usuário. | Alta |
| RNF15 | Escalabilidade | A estrutura do sistema deve permitir a inclusão de novos campos e funcionalidades futuramente. | Baixa |
| RNF16 | Armazenamento de imagens | As imagens de capa devem ser armazenadas de forma organizada e associadas corretamente aos jogos cadastrados. | Média |
| RNF17 | Privacidade | As avaliações e informações cadastradas pelo usuário devem pertencer ao seu catálogo pessoal e não devem ser expostas sem autorização. | Média |
| RNF18 | Acessibilidade | A interface deve utilizar elementos visuais e textuais de forma que as principais funcionalidades sejam compreensíveis para diferentes usuários. | Baixa |
| RNF19 | Portabilidade | O sistema deve poder ser executado em um ambiente PHP + MySQL sem depender de recursos específicos de um único computador. | Média |
| RNF20 | Backup | Os dados do catálogo devem poder ser incluídos em rotinas de backup do banco de dados. | Baixa |
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420

## Fora do escopo da beta

Não fazem parte desta versão, e não existem no código nem no banco:

<<<<<<< HEAD
- Finalizar compra, pagamento e entrega: o fluxo do cliente termina no carrinho.
- Biblioteca de jogos comprados (Meus Jogos).
- Avaliações e comentários dos usuários.
- Controle de estoque e contagem de vendas.
- Páginas de perfil e de configurações da conta.
=======
| Operação | Funcionalidade | Página sugerida |
|---|---|---|
| CREATE | Cadastrar um novo jogo | `cadastrar.php` |
| READ | Listar os jogos cadastrados | `index.php` |
| READ | Visualizar detalhes de um jogo | `visualizar.php` |
| UPDATE | Editar informações de um jogo | `editar.php` |
| DELETE | Excluir um jogo | `excluir.php` |

## Campos sugeridos para o cadastro de jogos

| Campo | Tipo sugerido | Obrigatório | Exemplo |
|---|---|---|---|
| ID | INT | Sim | 1 |
| Título | VARCHAR | Sim | Elden Ring |
| Capa | VARCHAR | Não | `elden-ring.jpg` |
| Plataforma | VARCHAR | Sim | PC |
| Gênero | VARCHAR | Sim | RPG |
| Desenvolvedora | VARCHAR | Não | FromSoftware |
| Ano de lançamento | INT | Não | 2022 |
| Status | VARCHAR | Sim | Zerado |
| Avaliação | INT | Não | 5 |
| Avaliação escrita | TEXT | Não | "Uma experiência incrível..." |
| Data de conclusão | DATE | Não | 2026-08-15 |
| Data de cadastro | DATETIME | Sim | 2026-09-24 15:30:00 |
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420
