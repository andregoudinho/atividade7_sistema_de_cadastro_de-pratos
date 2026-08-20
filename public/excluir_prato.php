<?php
include "conexao.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id !== null && is_numeric ($id)) {

    $sql = $conexao->prepare("DELETE FROM pratos WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $sql->close();
}
header("Location: listar_pratos.php?msg=Prato excluído com sucesso!");
exit;
?>