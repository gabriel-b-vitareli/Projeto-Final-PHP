Criando a tabela de jogos:
```sql
CREATE TABLE jogos( 
    id SERIAL PRIMARY KEY, 
    titulo VARCHAR(100) NOT NULL, 
    capa VARCHAR(500), 
    plataforma VARCHAR(100), 
    genero VARCHAR(50), 
    desenvolvedora VARCHAR(100), 
    lancamento DATE NOT NULL, 
    descricao TEXT, 
    nota DECIMAL(3,1), 
    idade INTEGER,
    preco DECIMAL(10,2) NOT NULL,
    estoque INTEGER DEFAULT 0,
    destaque BOOLEAN DEFAULT FALSE
);
```

Tabela de usuários:

```sql
CREATE TABLE usuarios(
    id SERIAL PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(60)
);
```