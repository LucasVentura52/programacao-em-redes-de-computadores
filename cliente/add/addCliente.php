<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];

    $conn = new mysqli('localhost', 'root', '', 'barbearia_db');

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Conexão falhou: " . $conn->connect_error]);
        exit;
    }

    $checkCpfSql = "SELECT COUNT(*) as count FROM clientes WHERE cpf = '$cpf'";
    $result = $conn->query($checkCpfSql);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(["success" => false, "message" => "CPF já cadastrado."]);
        $conn->close();
        exit;
    }

    $sql = "INSERT INTO clientes (nome, sobrenome, cpf, data_nascimento, telefone, email, endereco)
            VALUES ('$nome', '$sobrenome', '$cpf', '$data_nascimento', '$telefone', '$email', '$endereco')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Cadastro realizado com sucesso!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro: " . $conn->error]);
    }

    $conn->close();
}
?>
