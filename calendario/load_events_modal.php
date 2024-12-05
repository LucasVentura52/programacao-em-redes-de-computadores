<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barbearia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$date = $_GET['date'];

$sql = "SELECT a.id, a.data_hora, a.status, c.nome AS cliente_nome, s.nome AS servico_nome, col.nome AS colaborador_nome 
        FROM agendamentos a
        JOIN clientes c ON a.cliente_id = c.id
        JOIN servicos s ON a.servico_id = s.id
        JOIN colaboradores col ON a.colaborador_id = col.id
        WHERE a.status = 'pendente' AND DATE(a.data_hora) = ?
        ORDER BY a.data_hora ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'title' => $row['cliente_nome'] . ' - ' . $row['servico_nome'] . ' (Colaborador: ' . $row['colaborador_nome'] . ') <span class="status-bolinha"></span>',
            'start' => $row['data_hora'],
            'color' => '#ffc107'
        ];
    }
}

$conn->close();

echo json_encode($events);
?>
