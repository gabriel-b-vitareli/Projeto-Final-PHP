<?php 
require_once __DIR__ .'/../includes/conexao.php';

function cadastrarUsuario($conexao, $email, $senha){
    $sql = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email",$email);
    $stmt->bindParam(":senha",$senha);

    $stmt->execute();
    echo "Usuário cadastrado com sucesso!";
}

function consultarUsuario($conexao,$email){
    $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    return $usuario;
}

?>