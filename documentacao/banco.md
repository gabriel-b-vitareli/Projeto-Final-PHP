Criando a tabela de jogos:
```sql
CREATE TABLE jogos( 
    id SERIAL PRIMARY KEY, 
    titulo VARCHAR(100) NOT NULL, 
    capa VARCHAR(500), 
    plataforma VARCHAR(30) NOT NULL, 
    genero VARCHAR(50) NOT NULL, 
    desenvolvedora VARCHAR(100), 
    lancamento INT, 
    status VARCHAR(60) NOT NULL, 
    estrelas INT, 
    avaliacao TEXT, 
    conclusao DATE, 
    cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```