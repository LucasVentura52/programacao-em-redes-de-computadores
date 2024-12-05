<?php
$conn = new mysqli('localhost', 'root', '', 'barbearia_db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $id = intval($_POST['id']);
    $nome = $conn->real_escape_string($_POST['nome']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $preco = floatval($_POST['preco']);

    $query = "UPDATE servicos SET nome = '$nome', descricao = '$descricao', preco = $preco WHERE id = $id";

    if ($conn->query($query)) {
        echo json_encode(["success" => true, "message" => "Serviço atualizado com sucesso!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao atualizar serviço: " . $conn->error]);
    }
} 
$conn->close();
?>
