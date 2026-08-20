<?php
include "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    if ($nome == "" || $email == "") {
        die("Preencha todos os campos.");
    }

    $sql = "INSERT INTO usuario (nome, email) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);

    if (!$stmt) {
        die("Erro na preparação da consulta.");
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $email);
    mysqli_stmt_execute($stmt);

    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h1 class="mb-4">Cadastrar Usuário</h1>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">
            Cadastrar
        </button>

        <a href="../index.php" class="btn btn-secondary">
            Voltar
        </a>

    </form>

</div>

</body>
</html>