<?php
$conn = new mysqli('localhost', 'root', '', 'barbearia_db');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM colaboradores WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $colaborador = $result->fetch_assoc();
    echo json_encode($colaborador);
} else {
    echo json_encode([]);
}

$conn->close();
?>
