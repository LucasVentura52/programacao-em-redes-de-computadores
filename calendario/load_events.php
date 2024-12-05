<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barbearia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT a.id, 
               MIN(a.data_hora) AS data_hora, 
               a.status, 
               c.nome AS cliente_nome, 
               s.nome AS servico_nome 
        FROM agendamentos a
        JOIN clientes c ON a.cliente_id = c.id
        JOIN servicos s ON a.servico_id = s.id
        WHERE a.status = 'pendente'
        GROUP BY DATE(a.data_hora)
        ORDER BY a.data_hora ASC";

$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'title' => $row['cliente_nome'] . ' - ' . $row['servico_nome'],
            'start' => $row['data_hora'],
            'color' => '#ffc107'
        ];
    }
}

$conn->close();

echo json_encode($events);
?>
