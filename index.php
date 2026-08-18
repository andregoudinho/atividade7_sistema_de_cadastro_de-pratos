<?php
include "conexao.php";

$sql = "SELECT 
pratos.id_prato, 
pratos.nome, 
pratos.descricao, 
pratos.preco, 
pratos.categoria, 
usuarios.nome AS usuario

FROM pratos INNER JOIN usuarios ON pratos.id_usuario = usuarios.id_usuario"; 

$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Sistema do Restaurante</h1>

    <nav>
        <a href="cadastrar_usuario.php">Cadastrar Usuário</a>
        <a href="cadastrar_prato.php">Cadastrar Prato</a>
        <a href="pratos_usuario.php">Pratos por Usuário</a>
    </nav>

    <h2>Lista de Pratos</h2>
    <table>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Usuário</th>
                <th>Ações</th>

            </tr>
            <?php while ($prato = mysqli_fetch_assoc($resultado)) { ?>
                <tr>
                    <td><?php echo $prato['nome']; ?></td>
                    <td><?php echo $prato['descricao']; ?></td>
                    <td><?php echo $prato['preco']; ?></td>
                    <td><?php echo $prato['categoria']; ?></td>
                    <td><?php echo $prato['usuario']; ?></td>

                    <td>
                        <a href="editar_prato.php?id=<?php echo $prato['id_prato']; ?>">Editar</a>
                        <a href="excluir_prato.php?id=<?php echo $prato['id_prato']; ?>">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
    </table>
</body>
</html>