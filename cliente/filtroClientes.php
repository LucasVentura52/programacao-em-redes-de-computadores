<?php
$conn = new mysqli('localhost', 'root', '', 'barbearia_db');

$statusFiltro = isset($_GET['status']) ? $_GET['status'] : 'ativo';
$query = "SELECT * FROM clientes WHERE status = '$statusFiltro'";
$result = $conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $statusClass = $row['status'] == 'ativo' ? 'text-success' : 'text-danger';
        echo "<tr>
                <td><i class='$statusClass fas fa-circle'></i></td>
                <td>{$row['nome']}</td>
                <td>{$row['sobrenome']}</td>
                <td>{$row['telefone']}</td>
                <td>{$row['email']}</td>
                <td>
                    <a href='#' class='btn btn-sm btn-outline-primary' data-toggle='modal' data-target='#editarClienteModal' onclick='carregarDados({$row['id']})'>
                        <i class='fas fa-edit'></i> Editar
                    </a>
                    <a href='#' class='btn btn-sm btn-outline-danger ms-2' onclick='confirmDelete({$row['id']})'>
                        <i class='fas fa-trash-alt'></i> Inativar
                    </a>
                </td>
              </tr>";
    }
    
} else {
    echo "<tr><td colspan='7'>Erro ao buscar clientes: " . $conn->error . "</td></tr>";
}

$conn->close();
?>
