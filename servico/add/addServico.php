<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    

    $conn = new mysqli('localhost', 'root', '', 'barbearia_db');

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Conexão falhou: " . $conn->connect_error]);
        exit;
    }

    $checkServicoSql = "SELECT COUNT(*) as count FROM servicos WHERE nome = '$nome'";
    $result = $conn->query($checkServicoSql);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(["success" => false, "message" => "Serviço já cadastrado."]);
        $conn->close();
        exit;
    }

    $sql = "INSERT INTO servicos (nome, descricao, preco)
            VALUES ('$nome', '$descricao', '$preco')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Serviço cadastrado com sucesso!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro: " . $conn->error]);
    }

    $conn->close();
}
?>
