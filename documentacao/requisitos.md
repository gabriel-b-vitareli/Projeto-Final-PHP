# Sistema de Catálogo Pessoal de Jogos

# Requisitos do Sistema — Catálogo Pessoal de Jogos

## Requisitos Funcionais

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF01 | Cadastrar jogo | O sistema deve permitir ao usuário cadastrar um novo jogo em seu catálogo. | Alta |
| RF02 | Informar título | O sistema deve permitir informar o título do jogo. | Alta |
| RF03 | Informar capa | O sistema deve permitir adicionar uma imagem de capa ao jogo. | Média |
| RF04 | Informar plataforma | O sistema deve permitir informar a plataforma em que o jogo foi jogado. | Alta |
| RF05 | Informar gênero | O sistema deve permitir informar o gênero do jogo. | Média |
| RF06 | Informar desenvolvedora | O sistema deve permitir informar a desenvolvedora ou publicadora do jogo. | Baixa |
| RF07 | Informar ano de lançamento | O sistema deve permitir registrar o ano de lançamento do jogo. | Baixa |
| RF08 | Informar status | O sistema deve permitir definir o status do jogo, como "Quero jogar", "Jogando", "Zerado" ou "Abandonado". | Alta |
| RF09 | Avaliar com estrelas | O sistema deve permitir ao usuário atribuir uma avaliação ao jogo utilizando estrelas. | Alta |
| RF10 | Escrever avaliação | O sistema deve permitir ao usuário escrever uma avaliação ou comentário pessoal sobre o jogo. | Alta |
| RF11 | Registrar data de conclusão | O sistema deve permitir registrar a data em que o jogo foi concluído, quando aplicável. | Baixa |
| RF12 | Listar jogos | O sistema deve exibir todos os jogos cadastrados no catálogo. | Alta |
| RF13 | Visualizar detalhes | O sistema deve permitir visualizar todas as informações cadastradas de um jogo. | Alta |
| RF14 | Editar jogo | O sistema deve permitir alterar as informações de um jogo já cadastrado. | Alta |
| RF15 | Excluir jogo | O sistema deve permitir excluir um jogo do catálogo. | Alta |
| RF16 | Confirmar exclusão | O sistema deve solicitar confirmação antes de excluir um jogo. | Média |
| RF17 | Pesquisar jogos | O sistema deve permitir pesquisar jogos pelo título. | Média |
| RF18 | Filtrar por plataforma | O sistema deve permitir filtrar os jogos de acordo com a plataforma. | Média |
| RF19 | Filtrar por status | O sistema deve permitir filtrar os jogos de acordo com seu status. | Média |
| RF20 | Filtrar por gênero | O sistema deve permitir filtrar os jogos por gênero. | Baixa |
| RF21 | Ordenar catálogo | O sistema deve permitir ordenar os jogos por critérios como título, avaliação ou ano de lançamento. | Baixa |
| RF22 | Exibir estatísticas | O sistema deve apresentar informações resumidas do catálogo, como quantidade de jogos cadastrados e média das avaliações. | Baixa |
| RF23 | Exibir jogos recentes | O sistema deve permitir visualizar os jogos adicionados ou atualizados recentemente. | Baixa |
| RF24 | Registrar plataforma | O sistema deve permitir associar cada jogo à plataforma em que foi jogado, como PC, PlayStation, Xbox, Nintendo Switch, etc. | Alta |
| RF25 | Impedir cadastro incompleto | O sistema deve validar os campos obrigatórios antes de cadastrar um jogo. | Alta |

---

## Requisitos Não Funcionais

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
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

---

## Requisitos Funcionais do CRUD

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
