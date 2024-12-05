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
    SELECT DATE(a.data_hora) AS dia, 
           COUNT(a.id) AS total_agendamentos,
           SUM(s.preco) AS valor_acumulado
    FROM agendamentos a
    JOIN servicos s ON a.servico_id = s.id
    WHERE MONTH(a.data_hora) = $mes
      AND YEAR(a.data_hora) = $ano
      AND a.status = 'confirmado'
    GROUP BY dia
    ORDER BY total_agendamentos DESC
";

$result = $conn->query($sql);
?>

<div>
    <h2>Ranking de dias com mais agendamentos</h2>
    
    <?php if ($result->num_rows > 0) { ?>
        <table class="table table-striped">
            <thead>
    <tr>
        <th>Posição</th>
        <th>Data</th>
        <th>Total de Agendamentos</th>
        <th>Valor Acumulado</th>
    </tr>
</thead>
<tbody>
    <?php 
    $contador = 1;
    $total_posicoes = 0;
    $total_agendamentos = 0;
    $total_valor = 0;

    while ($row = $result->fetch_assoc()) {
        $total_posicoes++;
        $total_agendamentos += $row['total_agendamentos'];
        $total_valor += $row['valor_acumulado'];
    ?>
        <tr>
            <td><?php echo $contador++; ?></td>
            <td><?php echo date('d/m/Y', strtotime($row['dia'])); ?></td>
            <td><?php echo $row['total_agendamentos']; ?></td>
            <td>R$ <?php echo number_format($row['valor_acumulado'], 2, ',', '.'); ?></td>
        </tr>
    <?php } ?>
    
    <tr>
        <td colspan="2"><strong>Total Geral</strong></td>
        <td><strong><?php echo $total_agendamentos; ?></strong></td>
        <td><strong>R$ <?php echo number_format($total_valor, 2, ',', '.'); ?></strong></td>
    </tr>
</tbody>

    <?php } else { ?>
        <h2>Nenhum agendamento confirmado neste mês.</h2>
    <?php } ?>
</div>


<?php
$conn->close();
?>
