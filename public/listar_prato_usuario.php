<?php
include "../conexao.php";

$sql = "SELECT 
    prato.id,
    prato.nome,
    prato.descricao,
    prato.preco,
    prato.categoria,
    usuario.nome AS nome_usuario
FROM prato
INNER JOIN usuario ON prato.usuario_responsavel = usuario.id
ORDER BY prato.id DESC";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratos por Usuário</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h1 class="mb-4">Pratos por Usuário</h1>

    <nav class="mb-4">
        <a href="../index.php" class="btn btn-success">
            Início
        </a>

        <a href="cadastrar_usuario.php" class="btn btn-success">
            Cadastrar Usuário
        </a>

        <a href="cadastrar_prato.php" class="btn btn-success">
            Cadastrar Prato
        </a>

        <a href="listar_prato_usuario.php" class="btn btn-success">
            Pratos por Usuário
        </a>
    </nav>

    <?php if ($resultado->num_rows == 0): ?>

        <p>Nenhum prato cadastrado ainda.</p>

    <?php else: ?>

    <div class="table-responsive">

        <table class="table table-striped table-bordered">

            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Cadastrado por</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                <?php while ($prato = $resultado->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($prato['nome']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($prato['descricao']); ?>
                    </td>

                    <td>
                        R$ <?php echo number_format($prato['preco'], 2, ',', '.'); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($prato['categoria']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($prato['nome_usuario']); ?>
                    </td>

                    <td>

                        <a href="editar_prato.php?id=<?php echo $prato['id']; ?>" 
                           class="btn btn-secondary btn-sm">
                            Editar
                        </a>

                        <a href="excluir_prato.php?id=<?php echo $prato['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Tem certeza que deseja excluir este prato?')">
                            Excluir
                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    <?php endif; ?>

</div>

</body>
</html>