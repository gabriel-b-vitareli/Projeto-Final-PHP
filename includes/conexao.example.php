<?php 
$host = "localhost"; // Endereço do servidor de banco de dados. Manter "localhost" se o banco estiver na mesma máquina do servidor web.
$dbname = "gameshelf"; // Nome do banco de dados que você criou no PostgreSQL. Se o método padrão foi realizado, deve-se manter "gameshelf".
$user = "gameshelf"; // Nome do usuário do banco de dados. 
$pass = "12345"; // Senha do usuário do banco de dados. 

try {
    $conexao = new PDO(
        "pgsql:host=$host;
        dbname=$dbname",
        $user,
        $pass
    );
} catch (PDOException $e) {
    echo "Erro: " .$e->getMessage();
}
?>