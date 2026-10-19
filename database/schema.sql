-- Gameshelf: estrutura do banco (PostgreSQL)
<<<<<<< HEAD
-- Pode ser rodado em um banco novo ou em cima de um banco já existente.
-- As tabelas usam IF NOT EXISTS. A única parte que remove algo é o bloco
-- "Limpeza da versão beta", no fim, que apaga colunas antigas que não existem mais.
=======
<<<<<<< HEAD
-- Pode ser rodado em um banco novo ou em cima de um banco já existente.
-- As tabelas usam IF NOT EXISTS. A única parte que remove algo é o bloco
-- "Limpeza da versão beta", no fim, que apaga colunas antigas que não existem mais.
=======
-- Pode ser rodado em um banco novo ou em cima do que você já criou:
-- tudo usa IF NOT EXISTS, então não apaga nada.
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420

CREATE TABLE IF NOT EXISTS usuarios (
    id      SERIAL PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
<<<<<<< HEAD
    senha   VARCHAR(255),          -- hash (bcrypt), por isso o tamanho
    nivel   INT DEFAULT 0          -- 0 = cliente, 1 = administrador
);

-- Bancos antigos guardavam a senha em VARCHAR(60); o hash precisa de mais espaço.
=======
<<<<<<< HEAD
    senha   VARCHAR(255),          -- hash (bcrypt), por isso o tamanho
    nivel   INT DEFAULT 0          -- 0 = cliente, 1 = administrador
);

-- Bancos antigos guardavam a senha em VARCHAR(60); o hash precisa de mais espaço.
=======
    senha   VARCHAR(255),
    nivel   INT DEFAULT 0
);

-- A senha agora é guardada como hash (bcrypt), que ocupa mais espaço.
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420
ALTER TABLE usuarios ALTER COLUMN senha TYPE VARCHAR(255);

CREATE TABLE IF NOT EXISTS jogos (
    id             SERIAL PRIMARY KEY,
    titulo         VARCHAR(100) NOT NULL,
<<<<<<< HEAD
    capa           VARCHAR(500),   -- arquivo em uploads/capas/ ou link http(s)
    plataforma     VARCHAR(100),   -- separadas por vírgula, sem espaço: PC,PS,Xbox
=======
<<<<<<< HEAD
    capa           VARCHAR(500),   -- arquivo em uploads/capas/ ou link http(s)
    plataforma     VARCHAR(100),   -- separadas por vírgula, sem espaço: PC,PS,Xbox
=======
    capa           VARCHAR(500),
    plataforma     VARCHAR(100),
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420
    genero         VARCHAR(50),
    desenvolvedora VARCHAR(100),
    lancamento     DATE NOT NULL,
    descricao      TEXT,
<<<<<<< HEAD
    idade          INTEGER,        -- classificação indicativa (0 = livre)
=======
<<<<<<< HEAD
    idade          INTEGER,        -- classificação indicativa (0 = livre)
    preco          DECIMAL(10,2) NOT NULL,
    destaque       BOOLEAN DEFAULT FALSE
);

-- Colunas que bancos criados em versões anteriores podem não ter:
--   preco_original -> preço "de" (usado para mostrar o desconto)
--   logo           -> arquivo em uploads/logos/ (aparece no destaque da página inicial)
--   hero           -> arquivo em uploads/heros/ (fundo do destaque da página inicial)
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS preco_original DECIMAL(10,2);
=======
    nota           DECIMAL(3,1),
    idade          INTEGER,
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420
    preco          DECIMAL(10,2) NOT NULL,
    destaque       BOOLEAN DEFAULT FALSE
);

-- Colunas que bancos criados em versões anteriores podem não ter:
--   preco_original -> preço "de" (usado para mostrar o desconto)
--   logo           -> arquivo em uploads/logos/ (aparece no destaque da página inicial)
--   hero           -> arquivo em uploads/heros/ (fundo do destaque da página inicial)
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS preco_original DECIMAL(10,2);
<<<<<<< HEAD
=======
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS qtd_avaliacoes INTEGER DEFAULT 0;
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS vendas INTEGER DEFAULT 0;
--   logo -> arquivo da logo do jogo (aparece no destaque da página inicial)
--   hero -> arquivo do banner horizontal (fundo do destaque da página inicial)
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS logo VARCHAR(500);
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS hero VARCHAR(500);

CREATE TABLE IF NOT EXISTS favoritos (
    usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    jogo_id    INTEGER NOT NULL REFERENCES jogos(id) ON DELETE CASCADE,
    criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, jogo_id)
);

CREATE TABLE IF NOT EXISTS carrinho (
    usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    jogo_id    INTEGER NOT NULL REFERENCES jogos(id) ON DELETE CASCADE,
    criado_em  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, jogo_id)
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420
);

-- ---------------------------------------------------------------------------
-- Limpeza da versão beta
-- Avaliações, estoque e vendas saíram do projeto. Se o seu banco veio de uma
-- versão anterior, estas linhas removem as colunas que sobraram (e os dados
-- delas). Em um banco novo elas não fazem nada.
-- ---------------------------------------------------------------------------
ALTER TABLE jogos DROP COLUMN IF EXISTS nota;
ALTER TABLE jogos DROP COLUMN IF EXISTS qtd_avaliacoes;
ALTER TABLE jogos DROP COLUMN IF EXISTS estoque;
ALTER TABLE jogos DROP COLUMN IF EXISTS vendas;
<<<<<<< HEAD
=======
=======
);
>>>>>>> 858de2cc89f3f4bf5b48a48ee034e6e94423db6c
>>>>>>> a0062fae2e46bfae4498c664b9a6665f09788420
