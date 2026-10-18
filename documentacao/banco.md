# Banco de dados

PostgreSQL. O arquivo `database/schema.sql` cria tudo (e pode ser rodado de novo sem perder dados de tabelas existentes); `database/seed.sql` insere os jogos de exemplo.

## Visão geral

```
usuarios 1 ──< favoritos >── 1 jogos
usuarios 1 ──< carrinho  >── 1 jogos
```

Favoritos e carrinho são tabelas de ligação entre usuário e jogo. Apagar um usuário ou um jogo apaga também as linhas ligadas a ele (`ON DELETE CASCADE`).

## usuarios

```sql
CREATE TABLE usuarios (
    id      SERIAL PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha   VARCHAR(255),
    nivel   INT DEFAULT 0
);
```

| Coluna | Descrição |
|---|---|
| `usuario` | Nome de login, único sem diferenciar maiúsculas e minúsculas na aplicação. De 3 a 30 caracteres: letras, números, ponto, hífen e underline. |
| `senha` | Hash gerado por `password_hash` (bcrypt), por isso 255 caracteres. |
| `nivel` | `0` = cliente, `1` = administrador. Não há tela para mudar; é feito por SQL. |

## jogos

```sql
CREATE TABLE jogos (
    id             SERIAL PRIMARY KEY,
    titulo         VARCHAR(100) NOT NULL,
    capa           VARCHAR(500),
    plataforma     VARCHAR(100),
    genero         VARCHAR(50),
    desenvolvedora VARCHAR(100),
    lancamento     DATE NOT NULL,
    descricao      TEXT,
    idade          INTEGER,
    preco          DECIMAL(10,2) NOT NULL,
    destaque       BOOLEAN DEFAULT FALSE,
    preco_original DECIMAL(10,2),
    logo           VARCHAR(500),
    hero           VARCHAR(500)
);
```

| Coluna | Descrição |
|---|---|
| `capa`, `logo`, `hero` | Nome do arquivo em `uploads/capas/`, `uploads/logos/` e `uploads/heros/`, ou um link `http(s)://` completo. Vazio = sem imagem. |
| `plataforma` | Lista separada por vírgula, sem espaço: `PC,PS,Xbox`. Valores aceitos no painel: PC, PS, Xbox, Switch. |
| `idade` | Classificação indicativa: 0 (livre), 10, 12, 14, 16 ou 18. |
| `preco` | Preço atual. |
| `preco_original` | Preço "de". Quando é maior que `preco`, o site mostra o desconto e o jogo entra em "Em alta". |
| `destaque` | Jogo exibido no topo da página inicial. Sem nenhum marcado, vale o lançamento mais recente. |

## favoritos

```sql
CREATE TABLE favoritos (
    usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    jogo_id    INTEGER NOT NULL REFERENCES jogos(id) ON DELETE CASCADE,
    criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, jogo_id)
);
```

A chave primária composta impede favoritar o mesmo jogo duas vezes. A contagem de favoritos de cada jogo também define o ranking "Mais populares" na loja e o painel "Mais favoritados" na home.

## carrinho

```sql
CREATE TABLE carrinho (
    usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    jogo_id    INTEGER NOT NULL REFERENCES jogos(id) ON DELETE CASCADE,
    criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, jogo_id)
);
```

Jogo digital: um de cada, então não há coluna de quantidade. O total é a soma dos preços atuais dos jogos no carrinho.

## Fora do banco nesta versão

Não existem tabelas de pedidos, pagamentos, biblioteca, avaliações nem colunas de estoque e vendas. Bancos criados em versões anteriores perdem as colunas `nota`, `qtd_avaliacoes`, `estoque` e `vendas` ao rodar o `schema.sql` de novo.
