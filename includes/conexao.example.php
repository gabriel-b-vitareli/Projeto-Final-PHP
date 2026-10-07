<?php
// Copie este arquivo para "conexao.php" (que fica fora do Git) e ajuste os dados.
$host   = "localhost";
$porta  = "5432";
$dbname = "gameshelf";
$user   = "seu_usuario";
$pass   = "sua_senha";

try {
    $conexao = new PDO(
        "pgsql:host=$host;port=$porta;dbname=$dbname",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // Em produção não mostre o erro cru; aqui, pra estudo, ajuda a achar o problema.
    die("Erro ao conectar no banco: " . $e->getMessage());
}
