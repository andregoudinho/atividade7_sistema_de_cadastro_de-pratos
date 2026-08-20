<?php
include "conexao.php";

$sql = "SELECT pratos.id, pratos.nome, pratos.descricao, pratos.preco, pratos.categoria, usuarios.nome AS nome_usuario
        FROM pratos
        INNER JOIN usuarios ON pratos.usuario_id = usuarios.id
        ORDER BY pratos.id DESC";

$resultado = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listar Pratos</title>
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
    <h1>Pratos Cadastrados</h1>

    <?php if (isset($_GET['msg'])): ?>
        <div class="mensagem-sucesso"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>

    <?php if ($resultado->num_rows == 0): ?>
        <p>Nenhum prato cadastrado ainda.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Categoria</th>
            <th>Cadastrado por</th>
            <th>Ações</th>
        </tr>
        <?php while ($prato = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($prato['nome']); ?></td>
            <td><?php echo htmlspecialchars($prato['descricao']); ?></td>
            <td>R$ <?php echo number_format($prato['preco'], 2, ',', '.'); ?></td>
            <td><?php echo htmlspecialchars($prato['categoria']); ?></td>
            <td><?php echo htmlspecialchars($prato['nome_usuario']); ?></td>
            <td class="acoes">
                <a href="editar_prato.php?id=<?php echo $prato['id']; ?>">Editar</a>
                <a href="excluir_prato.php?id=<?php echo $prato['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este prato?')">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>
</div>

</body>
</html>