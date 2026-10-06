<?php 
require_once __DIR__ .'/../includes/conexao.php';

function cadastrarUsuario($conexao, $usuario, $senha){
    $sql = "INSERT INTO usuarios (usuario, senha) VALUES (:usuario, :senha)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":usuario",$usuario);
    $stmt->bindParam(":senha",$senha);

    $stmt->execute();
}

function consultarUsuario($conexao,$usuario){
    $sql = "SELECT id, usuario, senha FROM usuarios WHERE usuario = :usuario";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}

function consultarNome($conexao, $id){
    $sql = "SELECT usuario FROM usuarios WHERE id = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $username = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retorna apenas a string se encontrar o usuário, ou falso se não existir
    return $username ? $username['usuario'] : false;
}

?>