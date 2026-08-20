<?php
include "conexao.php";

$usuarios = $conexao->query("SELECT id, nome FROM usuarios ORDER BY nome");

$pratos = null;
$usuario_selecionado = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : "";

if ($usuario_selecionado != "") {
    $sql = $conexao->prepare("SELECT * FROM pratos WHERE usuario_id = ? ORDER BY nome");
    $sql->bind_param("i", $usuario_selecionado);
    $sql->execute();
    $pratos = $sql->get_result();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pratos por Usuário</title>
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
    <h1>Pratos Cadastrados por Usuário</h1>

    <form method="GET" action="listar_prato_usuario.php">
        <label for="usuario_id">Selecione o usuário</label>
        <select name="usuario_id" id="usuario_id" onchange="this.form.submit()">
            <option value="">-- Selecione --</option>
            <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                <option value="<?php echo $usuario['id']; ?>" <?php if ($usuario['id'] == $usuario_selecionado) echo "selected"; ?>>
                    <?php echo htmlspecialchars($usuario['nome']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if ($pratos !== null): ?>
        <?php if ($pratos->num_rows == 0): ?>
            <p style="margin-top:15px;">Esse usuário ainda não cadastrou nenhum prato.</p>
        <?php else: ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Categoria</th>
            </tr>
            <?php while ($prato = $pratos->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($prato['nome']); ?></td>
                <td><?php echo htmlspecialchars($prato['descricao']); ?></td>
                <td>R$ <?php echo number_format($prato['preco'], 2, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($prato['categoria']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>