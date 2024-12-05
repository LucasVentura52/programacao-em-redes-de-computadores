<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', '', 'barbearia_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $agendamento_id = $_POST['agendamento_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE agendamentos SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $agendamento_id);

    if ($stmt->execute()) {
        if ($status === 'cancelado') {
            echo json_encode(['status' => 'success', 'message' => 'Agendamento cancelado com sucesso!']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Agendamento confirmado com sucesso!']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar agendamento: ' . $conn->error]);
    }

    $stmt->close();
}
$conn->close();
exit();
?>
