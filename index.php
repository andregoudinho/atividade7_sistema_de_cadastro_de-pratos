<?php
include("conexao.php");

$sql = "SELECT 
prato.id,
prato.nome,
prato.descricao,
prato.preco,
prato.categoria,
usuario.nome AS usuario

FROM prato 
INNER JOIN usuario ON prato.usuario_responsavel = usuario.id";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
    <h1 class="mb-4">Sistema do Restaurante</h1>

    <nav class="mb-4">
        <a href="cadastrar_usuario.php" class="btn btn-success">
            Cadastrar Usuário
        </a>
        <a href="cadastrar_prato.php" class="btn btn-success">
            Cadastrar Prato
        </a>
        <a href="pratos_usuario.php" class="btn btn-success">
            Pratos por Usuário
        </a>
    </nav>

    <h2 class="mb-3">Lista de Pratos</h2>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">

            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($prato = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo $prato['nome']; ?></td>
                        <td><?php echo $prato['descricao']; ?></td>
                        <td>
                            R$ <?php echo number_format($prato['preco'], 2, ',', '.'); ?>
                        </td>
                        <td><?php echo $prato['categoria']; ?></td>
                        <td><?php echo $prato['usuario']; ?></td>
                        <td>
                            <a href="editar_prato.php?id=<?php echo $prato['id']; ?>" 
                               class="btn btn-secondary btn-sm">
                                Editar
                            </a>
                            <a href="excluir_prato.php?id=<?php echo $prato['id']; ?>" 
                               class="btn btn-danger btn-sm">
                                Excluir
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>