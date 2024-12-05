<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST['cliente_id'];
    $colaborador_id = $_POST['colaborador_id'];
    $servico_id = $_POST['servico_id'];
    $data_hora = $_POST['data_hora'];
    $status = 'pendente';
    $override_warning = isset($_POST['override_warning']) && $_POST['override_warning'] === 'true';

    $conn = new mysqli('localhost', 'root', '', 'barbearia_db');

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Falha na conexão: ' . $conn->connect_error]);
        exit;
    }

    $checkSql = "SELECT * FROM agendamentos 
                 WHERE cliente_id = '$cliente_id' 
                 AND colaborador_id = '$colaborador_id' 
                 AND servico_id = '$servico_id' 
                 AND data_hora = '$data_hora'
                 AND status != 'cancelado'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Agendamento duplicado! Já existe um agendamento para este horário.']);
    } else {
        if (!$override_warning) {
            $checkProximitySql = "SELECT * FROM agendamentos 
                                  WHERE colaborador_id = '$colaborador_id' 
                                  AND ABS(TIMESTAMPDIFF(MINUTE, data_hora, '$data_hora')) < 30
                                  AND status != 'cancelado'";
            $proximityResult = $conn->query($checkProximitySql);

            if ($proximityResult->num_rows > 0) {
                echo json_encode(['status' => 'warning', 'message' => 'Existe um agendamento próximo a este horário. Deseja confirmar ou cancelar?']);
                $conn->close();
                exit;
            }
        }

        $checkClienteSql = "SELECT * FROM agendamentos 
                    WHERE cliente_id = '$cliente_id' 
                    AND DATE(data_hora) = DATE('$data_hora') 
                    AND status != 'cancelado'";
        $clienteResult = $conn->query($checkClienteSql);

        if ($clienteResult->num_rows > 0 && !$override_warning) {
            echo json_encode(['status' => 'warning', 'message' => 'Já existe um agendamento para este cliente. Deseja confirmar ou cancelar?']);
            $conn->close();
            exit;
        }

        $sql = "INSERT INTO agendamentos (cliente_id, colaborador_id, servico_id, data_hora, status) VALUES ('$cliente_id', '$colaborador_id', '$servico_id', '$data_hora', '$status')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Cadastro realizado com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $conn->error]);
        }
    }

    $conn->close();
}
?>