<?php
$conn = new mysqli('localhost', 'root', '', 'barbearia_db');

$statusFiltro = isset($_GET['status']) ? $_GET['status'] : 'ativo';

$query = "SELECT * FROM servicos WHERE status = '$statusFiltro'";
$result = $conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $statusClass = $row['status'] == 'ativo' ? 'text-success' : 'text-danger';
        echo "<tr>
                <td><i class='$statusClass fas fa-circle'></i></td>
                <td>{$row['nome']}</td>
                <td>{$row['descricao']}</td>
                <td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>
                <td>
                    <a href='#' class='btn btn-sm btn-outline-primary' data-toggle='modal' data-target='#editarServicoModal' onclick='carregarDadosServico({$row['id']})'>
                        <i class='fas fa-edit'></i> Editar
                    </a>
                    <a href='#' class='btn btn-sm btn-outline-danger ms-2' onclick='confirmDeleteService({$row['id']})'>
                        <i class='fas fa-trash-alt'></i> Inativar
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>Erro ao buscar serviços: " . $conn->error . "</td></tr>";
}

$conn->close();
?>
