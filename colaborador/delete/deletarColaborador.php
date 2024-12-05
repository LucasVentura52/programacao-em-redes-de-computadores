<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli('localhost', 'root', '', 'barbearia_db');

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $checkStatusSql = "SELECT status FROM colaboradores WHERE id = ?";
    $checkStmt = $conn->prepare($checkStatusSql);
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkStmt->bind_result($statusAtual);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($statusAtual === 'inativo') {
        echo "O colaborador já está inativo.";
    } else {
        $sql = "UPDATE colaboradores SET status = 'inativo' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Colaborador atualizado para inativo com sucesso.";
        } else {
            echo "Erro ao atualizar colaborador: " . $conn->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
