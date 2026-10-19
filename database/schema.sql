-- Gameshelf: estrutura do banco (PostgreSQL)
-- Pode ser rodado em um banco novo ou em cima de um banco já existente.
-- As tabelas usam IF NOT EXISTS. A única parte que remove algo é o bloco
-- "Limpeza da versão beta", no fim, que apaga colunas antigas que não existem mais.

CREATE TABLE IF NOT EXISTS usuarios (
    id      SERIAL PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha   VARCHAR(255),          -- hash (bcrypt), por isso o tamanho
    nivel   INT DEFAULT 0          -- 0 = cliente, 1 = administrador
);

-- Bancos antigos guardavam a senha em VARCHAR(60); o hash precisa de mais espaço.
ALTER TABLE usuarios ALTER COLUMN senha TYPE VARCHAR(255);

CREATE TABLE IF NOT EXISTS jogos (
    id             SERIAL PRIMARY KEY,
    titulo         VARCHAR(100) NOT NULL,
    capa           VARCHAR(500),   -- arquivo em uploads/capas/ ou link http(s)
    plataforma     VARCHAR(100),   -- separadas por vírgula, sem espaço: PC,PS,Xbox
    genero         VARCHAR(50),
    desenvolvedora VARCHAR(100),
    lancamento     DATE NOT NULL,
    descricao      TEXT,
    idade          INTEGER,        -- classificação indicativa (0 = livre)
    preco          DECIMAL(10,2) NOT NULL,
    destaque       BOOLEAN DEFAULT FALSE
);

-- Colunas que bancos criados em versões anteriores podem não ter:
--   preco_original -> preço "de" (usado para mostrar o desconto)
--   logo           -> arquivo em uploads/logos/ (aparece no destaque da página inicial)
--   hero           -> arquivo em uploads/heros/ (fundo do destaque da página inicial)
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS preco_original DECIMAL(10,2);
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
