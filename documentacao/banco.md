Criando a tabela de jogos:
```sql
CREATE TABLE jogos( 
    id SERIAL PRIMARY KEY, 
    titulo VARCHAR(100) NOT NULL, 
    capa VARCHAR(500), 
    plataforma VARCHAR(30) NOT NULL, 
    genero VARCHAR(50) NOT NULL, 
    desenvolvedora VARCHAR(100), 
    lancamento DATE NOT NULL, 
    status VARCHAR(60) NOT NULL, 
    estrelas INT, 
    avaliacao TEXT, 
    conclusao DATE, 
    cadastrado_por INT NOT NULL
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