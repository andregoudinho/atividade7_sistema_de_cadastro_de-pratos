<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    if ($nome == "" || $email == "") {
        die("Prencha todos os campos.");
    }

    $sql = "INSERT INTO usuario (nome, email) VALUES (?,?)";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        die("Erro na preparação da consulta.");
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $nome, $email);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastrar Usuário</h1>

    <form method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <button type="submit">Cadastrar</button>
    </form>
    <br>
    <a href="index.php">Voltar</a>
    
</body>
</html>