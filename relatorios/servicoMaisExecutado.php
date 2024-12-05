<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barbearia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mes = isset($_GET['mes']) ? intval($_GET['mes']) : date('n');
$ano = isset($_GET['ano']) ? intval($_GET['ano']) : date('Y');

$sql = "
    SELECT s.id, s.nome, COUNT(a.id) AS total_executado, SUM(s.preco) AS valor_acumulado
    FROM servicos s
    JOIN agendamentos a ON s.id = a.servico_id
    WHERE MONTH(a.data_hora) = $mes
      AND YEAR(a.data_hora) = $ano
    GROUP BY s.id
    ORDER BY total_executado DESC
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Ranking de Serviços</h2>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>Posição</th><th>Nome</th><th>Total Executado</th><th>Valor Acumulado</th></tr></thead><tbody>";

    $contador = 1;
    $total_executado = 0;
    $total_valor = 0;

    while ($row = $result->fetch_assoc()) {
        $total_executado += $row["total_executado"];
        $total_valor += $row["valor_acumulado"];
        echo "<tr><td>" . $contador++ . "</td><td>" . $row["nome"] . "</td><td>" . $row["total_executado"] . "</td><td>R$ " . number_format($row["valor_acumulado"], 2, ',', '.') . "</td></tr>";
    }

    echo "<tr><td colspan='2'><strong>Total Geral</strong></td><td><strong>" . $total_executado . "</strong></td><td><strong>R$ " . number_format($total_valor, 2, ',', '.') . "</strong></td></tr>";

    echo "</tbody></table>";
} else {
    echo "<h2>Nenhum serviço foi executado neste mês.</h2>";
}

$conn->close();
?>
