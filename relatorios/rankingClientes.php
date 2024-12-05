<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barbearia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'cliente';
$mes = isset($_GET['mes']) ? intval($_GET['mes']) : date('n');
$ano = isset($_GET['ano']) ? intval($_GET['ano']) : date('Y');

if ($tipo === 'cliente') {
    $campo_id = 'cliente_id';
    $tabela = 'clientes';
    $nome_coluna = 'nome';
} else {
    $campo_id = 'colaborador_id';
    $tabela = 'colaboradores';
    $nome_coluna = 'nome';
}

$sql = "
    SELECT $tabela.$nome_coluna AS nome, COUNT(a.id) AS agendamentos, SUM(s.preco) AS valor_acumulado
    FROM $tabela
    JOIN agendamentos a ON $tabela.id = a.$campo_id
    JOIN servicos s ON a.servico_id = s.id
    WHERE MONTH(a.data_hora) = $mes
      AND YEAR(a.data_hora) = $ano
      AND a.status = 'confirmado'
    GROUP BY $tabela.id
    ORDER BY agendamentos DESC, valor_acumulado DESC
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Ranking de " . ucfirst($tipo) . "</h2>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>Posição</th><th>Nome</th><th>Agendamentos</th><th>Valor Acumulado</th></tr></thead><tbody>";

    $count = 1;
    $total_agendamentos = 0;
    $total_valor = 0;
    
    while ($row = $result->fetch_assoc()) {
        $total_agendamentos += $row["agendamentos"];
        $total_valor += $row["valor_acumulado"];
        echo "<tr><td>" . $count . "</td><td>" . $row["nome"] . "</td><td>" . $row["agendamentos"] . "</td><td>R$ " . number_format($row["valor_acumulado"], 2, ',', '.') . "</td></tr>";
        $count++;
    }

    echo "<tr><td colspan='2'><strong>Total Geral</strong></td><td><strong>" . $total_agendamentos . "</strong></td><td><strong>R$ " . number_format($total_valor, 2, ',', '.') . "</strong></td></tr>";
    echo "</tbody></table>";
} else {
    echo "<h2>Nenhum registro encontrado.</h2>";
}

$conn->close();
?>
