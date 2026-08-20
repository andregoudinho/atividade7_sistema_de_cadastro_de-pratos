<?php
include "conexao.php";

$mensagem = "";

$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);

if ($id === null) {
    header("Location: listar_pratos.php");
    exit;
}

$usuarios = $conexao->query("SELECT id, nome FROM usuarios ORDER BY nome");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco = trim($_POST["preco"]);
    $categoria = trim($_POST["categoria"]);
    $usuario_id = $_POST["usuario_id"];

    if ($nome == "" || $descricao == "" || $preco == "" || $categoria == "" || $usuario_id == "") {
        $mensagem = "erro:Preencha todos os campos antes de salvar.";
    } elseif (!is_numeric($preco)) {
        $mensagem = "erro:O preço precisa ser um número.";
    } else {
        $sql = $conexao->prepare("UPDATE pratos SET nome = ?, descricao = ?, preco = ?, categoria = ?, usuario_id = ? WHERE id = ?");
        $sql->bind_param("ssdsii", $nome, $descricao, $preco, $categoria, $usuario_id, $id);
        $sql->execute();
        $sql->close();

        header("Location: listar_pratos.php?msg=Prato atualizado com sucesso!");
        exit;
    }
}

$sql = $conexao->prepare("SELECT * FROM pratos WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$prato = $sql->get_result()->fetch_assoc();
$sql->close();

if (!$prato) {
    header("Location: listar_pratos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Prato</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header>
    <nav>
        <a href="index.php">Início</a>
        <a href="cadastrar_usuario.php">Cadastrar Usuário</a>
        <a href="cadastrar_prato.php">Cadastrar Prato</a>
        <a href="listar_pratos.php">Listar Pratos</a>
        <a href="listar_prato_usuario.php">Pratos por Usuário</a>
    </nav>
</header>

<div class="container">
    <h1>Editar Prato</h1>

    <?php if ($mensagem != "") {
        $partes = explode(":", $mensagem, 2);
        echo "<div class='mensagem-erro'>" . $partes[1] . "</div>";
    } ?>

    <form method="POST" action="editar_prato.php">
        <input type="hidden" name="id" value="<?php echo $prato['id']; ?>">

        <label for="nome">Nome do prato</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($prato['nome']); ?>">

        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" rows="3"><?php echo htmlspecialchars($prato['descricao']); ?></textarea>

        <label for="preco">Preço</label>
        <input type="text" name="preco" id="preco" value="<?php echo $prato['preco']; ?>">

        <label for="categoria">Categoria</label>
        <input type="text" name="categoria" id="categoria" value="<?php echo htmlspecialchars($prato['categoria']); ?>">

        <label for="usuario_id">Cadastrado por</label>
        <select name="usuario_id" id="usuario_id">
            <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                <option value="<?php echo $usuario['id']; ?>" <?php if ($usuario['id'] == $prato['usuario_id']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($usuario['nome']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Salvar Alterações</button>
    </form>
</div>

</body>
</html>