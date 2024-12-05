<?php
$conn = new mysqli('localhost', 'root', '', 'barbearia_db');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $query = "SELECT status FROM servicos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    if ($status === 'inativo') {
        echo 'already_inativo';
    } else {
        $query = "UPDATE servicos SET status = 'inativo' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }

        $stmt->close();
    }
}

$conn->close();
?>
