-- Gameshelf: estrutura do banco (PostgreSQL)
-- Pode ser rodado em um banco novo ou em cima do que você já criou:
-- tudo usa IF NOT EXISTS, então não apaga nada.

CREATE TABLE IF NOT EXISTS usuarios (
    id      SERIAL PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha   VARCHAR(255),
    nivel   INT DEFAULT 0
);

-- A senha agora é guardada como hash (bcrypt), que ocupa mais espaço.
ALTER TABLE usuarios ALTER COLUMN senha TYPE VARCHAR(255);

CREATE TABLE IF NOT EXISTS jogos (
    id             SERIAL PRIMARY KEY,
    titulo         VARCHAR(100) NOT NULL,
    capa           VARCHAR(500),
    plataforma     VARCHAR(100),
    genero         VARCHAR(50),
    desenvolvedora VARCHAR(100),
    lancamento     DATE NOT NULL,
    descricao      TEXT,
    nota           DECIMAL(3,1),
    idade          INTEGER,
    preco          DECIMAL(10,2) NOT NULL,
    estoque        INTEGER DEFAULT 0,
    destaque       BOOLEAN DEFAULT FALSE
);

-- Colunas novas, necessárias pra loja:
--   preco_original -> preço "de" (pra mostrar o desconto)
--   qtd_avaliacoes -> quantas pessoas avaliaram (o "12.4k" do card)
--   vendas         -> usada no ranking de mais vendidos
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS preco_original DECIMAL(10,2);
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS qtd_avaliacoes INTEGER DEFAULT 0;
ALTER TABLE jogos ADD COLUMN IF NOT EXISTS vendas INTEGER DEFAULT 0;
--   logo -> arquivo da logo do jogo (aparece no destaque da página inicial)
--   hero -> arquivo do banner horizontal (fundo do destaque da página inicial)
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