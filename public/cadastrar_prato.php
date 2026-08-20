<?php
include "../conexao.php";

$mensagem = "";

$usuarios = $conexao->query("SELECT id, nome FROM usuario ORDER BY nome");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco = trim($_POST["preco"]);
    $categoria = trim($_POST["categoria"]);
    $usuario_id = $_POST["usuario_id"];

    if ($nome == "" || $descricao == "" || $preco == "" || $categoria == "" || $usuario_id == "") {
        $mensagem = "Preencha todos os campos antes de cadastrar o prato.";
    } elseif (!is_numeric($preco)) {
        $mensagem = "O preço precisa ser um número.";
    } else {

        $sql = $conexao->prepare("INSERT INTO prato 
        (nome, descricao, preco, categoria, usuario_responsavel) 
        VALUES (?, ?, ?, ?, ?)");

        $sql->bind_param("ssdsi", $nome, $descricao, $preco, $categoria, $usuario_id);

        if ($sql->execute()) {
            $mensagem = "Prato cadastrado com sucesso!";
        } else {
            $mensagem = "Não foi possível cadastrar o prato.";
        }

        $sql->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Prato</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h1 class="mb-4">Cadastrar Prato</h1>

    <div class="mb-4">
        <a href="../index.php" class="btn btn-secondary">
            Início
        </a>

        <a href="cadastrar_usuario.php" class="btn btn-success">
            Cadastrar Usuário
        </a>

        <a href="cadastrar_prato.php" class="btn btn-success">
            Cadastrar Prato
        </a>

        <a href="listar_pratos.php" class="btn btn-success">
            Listar Pratos
        </a>

        <a href="listar_prato_usuario.php" class="btn btn-success">
            Pratos por Usuário
        </a>
    </div>

    <?php if ($mensagem != "") { ?>

        <div class="alert alert-info">
            <?php echo $mensagem; ?>
        </div>

    <?php } ?>

    <?php if ($usuarios->num_rows == 0) { ?>

        <div class="alert alert-warning">
            Você precisa cadastrar um usuário antes de cadastrar um prato.

            <a href="cadastrar_usuario.php">
                Clique aqui para cadastrar.
            </a>
        </div>

    <?php } else { ?>

        <div class="card">

            <div class="card-body">

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nome do prato</label>

                        <input 
                            type="text" 
                            name="nome" 
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>

                        <textarea 
                            name="descricao" 
                            class="form-control"
                            rows="3"
                            required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Preço</label>

                        <input 
                            type="text" 
                            name="preco" 
                            class="form-control"
                            placeholder="Ex: 29.90"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Categoria</label>

                        <input 
                            type="text" 
                            name="categoria" 
                            class="form-control"
                            placeholder="Ex: Massas, Lanches, Sobremesas"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Usuário responsável</label>

                        <select 
                            name="usuario_id" 
                            class="form-select"
                            required>

                            <option value="">
                                Selecione o usuário
                            </option>

                            <?php while ($usuario = $usuarios->fetch_assoc()) { ?>

                                <option value="<?php echo $usuario['id']; ?>">
                                    <?php echo htmlspecialchars($usuario['nome']); ?>
                                </option>

                            <?php } ?>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Cadastrar Prato
                    </button>

                    <a href="../index.php" class="btn btn-secondary">
                        Voltar
                    </a>

                </form>

            </div>

        </div>

    <?php } ?>

</div>

</body>
</html>