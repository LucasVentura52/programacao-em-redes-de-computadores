<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nomeColaborador'];
    $sobrenome = $_POST['sobrenomeColaborador'];
    $cpf = $_POST['cpfColaborador'];
    $data_nascimento = $_POST['dataNascimentoColaborador'];
    $telefone = $_POST['telefoneColaborador'];
    $email = $_POST['emailColaborador'];
    $cargo = $_POST['cargo'];

    $conn = new mysqli('localhost', 'root', '', 'barbearia_db');

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Conexão falhou: " . $conn->connect_error]);
        exit;
    }

    $checkCpfSql = "SELECT COUNT(*) as count FROM colaboradores WHERE cpf = '$cpf'";
    $result = $conn->query($checkCpfSql);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(["success" => false, "message" => "CPF já cadastrado."]);
        $conn->close();
        exit;
    }

    $sql = "INSERT INTO colaboradores (nome, sobrenome, cpf, data_nascimento, telefone, email, cargo)
            VALUES ('$nome', '$sobrenome', '$cpf', '$data_nascimento', '$telefone', '$email', '$cargo')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Cadastro realizado com sucesso!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro: " . $conn->error]);
    }

    $conn->close();
}
?>
