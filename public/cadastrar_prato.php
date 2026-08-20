<?php
include "conexao.php";

$mensagem = "";

$usuarios = $conexao->query("SELECT id, nome FROM usuarios ORDER BY nome");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco = trim($_POST["preco"]);
    $categoria = trim($_POST["categoria"]);
    $usuario_id = $_POST["usuario_id"];

    if ($nome == "" || $descricao == "" || $preco == "" || $categoria == "" || $usuario_id == "") {
        $mensagem = "erro:Preencha todos os campos antes de cadastrar o prato.";
    } elseif (!is_numeric($preco)) {
        $mensagem = "erro:O preço precisa ser um número.";
    } else {
        $sql = $conexao->prepare("INSERT INTO pratos (nome, descricao, preco, categoria, usuario_id) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("ssdsi", $nome, $descricao, $preco, $categoria, $usuario_id);

        if ($sql->execute()) {
            $mensagem = "sucesso:Prato cadastrado com sucesso!";
        } else {
            $mensagem = "erro:Não foi possível cadastrar o prato.";
        }

        $sql->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Prato</title>
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
    <h1>Cadastrar Prato</h1>

    <?php if ($mensagem != "") {
        $partes = explode(":", $mensagem, 2);
        $tipo = $partes[0];
        $texto = $partes[1];
        $classe = ($tipo == "sucesso") ? "mensagem-sucesso" : "mensagem-erro";
        echo "<div class='$classe'>$texto</div>";
    } ?>

    <?php if ($usuarios->num_rows == 0): ?>
        <div class="mensagem-erro">
            Você precisa cadastrar um usuário antes de cadastrar um prato.
            <a href="cadastrar_usuario.php">Clique aqui para cadastrar</a>.
        </div>
    <?php else: ?>

    <form method="POST" action="cadastrar_prato.php">
        <label for="nome">Nome do prato</label>
        <input type="text" name="nome" id="nome">

        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" rows="3"></textarea>

        <label for="preco">Preço (ex: 29.90)</label>
        <input type="text" name="preco" id="preco">

        <label for="categoria">Categoria (ex: Entrada, Prato Principal, Sobremesa)</label>
        <input type="text" name="categoria" id="categoria">

        <label for="usuario_id">Cadastrado por</label>
        <select name="usuario_id" id="usuario_id">
            <option value="">Selecione o usuário</option>
            <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                <option value="<?php echo $usuario['id']; ?>"><?php echo htmlspecialchars($usuario['nome']); ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Cadastrar Prato</button>
    </form>

    <?php endif; ?>
</div>

</body>
</html>