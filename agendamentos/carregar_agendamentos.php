<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', '', 'barbearia_db');

if (isset($_POST['data'])) {
    $data = $_POST['data'];

    $stmt = $conn->prepare("
        SELECT agendamentos.id, 
               clientes.nome AS cliente_nome, 
               colaboradores.nome AS colaborador_nome, 
               servicos.nome AS servico_nome, 
               agendamentos.data_hora, 
               agendamentos.status
        FROM 
            agendamentos
        JOIN 
            clientes ON agendamentos.cliente_id = clientes.id
        JOIN 
            colaboradores ON agendamentos.colaborador_id = colaboradores.id
        JOIN 
            servicos ON agendamentos.servico_id = servicos.id
        WHERE 
            agendamentos.status = 'pendente' 
            AND DATE(agendamentos.data_hora) = ?
        ORDER BY agendamentos.data_hora ASC");

    $stmt->bind_param('s', $data);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $agendamentos = [];
    while ($row = $result->fetch_assoc()) {
        $agendamentos[] = $row;
    }

    echo json_encode($agendamentos);
}

$conn->close();
?>
