<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
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

    $checkCpfSql = "SELECT COUNT(*) as count FROM clientes WHERE cpf = '$cpf' AND id != '$id'";
    $result = $conn->query($checkCpfSql);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(["success" => false, "message" => "CPF já cadastrado para outro cliente."]);
        $conn->close();
        exit;
    }

    $status_sql = "SELECT status FROM clientes WHERE id='$id'";
    $status_result = $conn->query($status_sql);

    if ($status_result->num_rows > 0) {
        $status_row = $status_result->fetch_assoc();
        if ($status_row['status'] == 'inativo') {
            $sql = "UPDATE clientes SET 
                        nome='$nome', 
                        sobrenome='$sobrenome', 
                        cpf='$cpf', 
                        data_nascimento='$data_nascimento', 
                        telefone='$telefone', 
                        email='$email', 
                        endereco='$endereco', 
                        status='ativo' 
                    WHERE id='$id'";
        } else {
            $sql = "UPDATE clientes SET 
                        nome='$nome', 
                        sobrenome='$sobrenome', 
                        cpf='$cpf', 
                        data_nascimento='$data_nascimento', 
                        telefone='$telefone', 
                        email='$email', 
                        endereco='$endereco' 
                    WHERE id='$id'";
        }

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Cliente atualizado com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Cliente não encontrado."]);
    }

    $conn->close();
}
?>
