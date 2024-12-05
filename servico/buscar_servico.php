<?php
$conn = new mysqli('localhost', 'root', '', 'barbearia_db');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM servicos WHERE id = $id";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Serviço não encontrado']);
    }
} else {
    echo json_encode(['error' => 'ID não fornecido']);
}

$conn->close();
?>
