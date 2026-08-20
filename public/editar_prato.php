<?php
include "../conexao.php";

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $categoria = $_POST["categoria"];
    $usuario = $_POST["usuario_responsavel"];

    $sql = "UPDATE prato SET
            nome='$nome',
            descricao='$descricao',
            preco='$preco',
            categoria='$categoria',
            usuario_responsavel='$usuario'
            WHERE id='$id'";

    mysqli_query($conexao, $sql);

    header("Location: listar_pratos.php");
    exit;
}

$sql = "SELECT * FROM prato WHERE id='$id'";
$resultado = mysqli_query($conexao, $sql);
$prato = mysqli_fetch_assoc($resultado);

$usuarios = mysqli_query($conexao, "SELECT * FROM usuario ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Prato</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h1 class="mb-4">Sistema do Restaurante</h1>

    <div class="mb-4">

        <a href="cadastrar_usuario.php" class="btn btn-success">
            Cadastrar Usuário
        </a>

        <a href="cadastrar_prato.php" class="btn btn-success">
            Cadastrar Prato
        </a>

        <a href="listar_pratos.php" class="btn btn-success">
            Listar Pratos
        </a>

        <a href="pratos_por_usuario.php" class="btn btn-success">
            Pratos por Usuário
        </a>

    </div>

    <h2 class="mb-4">Editar Prato</h2>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Nome</label>

            <input
                type="text"
                name="nome"
                class="form-control"
                value="<?php echo $prato['nome']; ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>

            <textarea
                name="descricao"
                class="form-control"
                required
            ><?php echo $prato['descricao']; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Preço</label>

            <input
                type="text"
                name="preco"
                class="form-control"
                value="<?php echo $prato['preco']; ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria</label>

            <input
                type="text"
                name="categoria"
                class="form-control"
                value="<?php echo $prato['categoria']; ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Usuário</label>

            <select name="usuario_responsavel" class="form-select" required>

                <?php while ($usuario = mysqli_fetch_assoc($usuarios)) { ?>

                    <option
                        value="<?php echo $usuario['id']; ?>"
                        <?php
                        if ($usuario['id'] == $prato['usuario_responsavel']) {
                            echo "selected";
                        }
                        ?>
                    >
                        <?php echo $usuario['nome']; ?>
                    </option>

                <?php } ?>

            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Salvar
        </button>

        <a href="listar_pratos.php" class="btn btn-secondary">
            Voltar
        </a>

    </form>

</div>

</body>
</html>