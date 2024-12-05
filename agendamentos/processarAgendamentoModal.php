<!-- Modal para Processar Agendamento -->
<div class="modal fade" id="processarAgendamentoModal" tabindex="-1" aria-labelledby="processarAgendamentoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="processarAgendamentoModalLabel">Processar Agendamento</h5>
            </div>
            <div class="modal-body" style="height: 100%">

                <form id="processarAgendamentoForm" method="POST">
                    <div class="form-group">
                        <label for="data_agendamento">Selecionar Data</label>
                        <div class="input-group icon">
                            <span>
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="date" class="form-control" id="data_agendamento" name="data_agendamento">
                        </div>
                    </div>

                    <div class="input-group icon">
                        <label for="agendamento_id">Selecionar Agendamento</label>
                        <div class="input-group icon">
                            <span>
                                <i class="fas fa-list"></i>
                            </span>
                            <select class="form-control" id="agendamento_id" name="agendamento_id" required>
                                <?php
                                $conn = new mysqli('localhost', 'root', '', 'barbearia_db');
                                $result = $conn->query("
                SELECT agendamentos.id, 
                       clientes.nome AS cliente_nome, 
                       colaboradores.nome AS colaborador_nome, 
                       servicos.nome AS servico_nome, 
                       agendamentos.data_hora, 
                       agendamentos.status
                FROM 
                    agendamentos
                JOIN 
                    clientes ON agendamentos.cliente_id = clientes.id
                JOIN 
                    colaboradores ON agendamentos.colaborador_id = colaboradores.id
                JOIN 
                    servicos ON agendamentos.servico_id = servicos.id
                WHERE 
                    agendamentos.status = 'pendente'
            ");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>
                        {$row['cliente_nome']} - {$row['servico_nome']} ({$row['colaborador_nome']}) - {$row['data_hora']}
                      </option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="status">Status</label>
                        <div class="input-group icon">
                            <span>
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <select class="form-control" id="status" name="status" required>
                                <option value="confirmado">Confirmado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">Cancelar</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                    </div>
                    <div id="message"></div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#data_agendamento').on('change', function () {
            var dataSelecionada = $(this).val();
            if (dataSelecionada) {
                carregarAgendamentos(dataSelecionada);
            }
        });

        function carregarAgendamentos(data) {
            $.ajax({
                type: 'POST',
                url: 'agendamentos/carregar_agendamentos.php',
                data: { data: data },
                dataType: 'json',
                success: function (response) {
                    var options = '';
                    if (response.length > 0) {
                        response.forEach(function (agendamento) {
                            options += `<option value="${agendamento.id}">
                                    ${agendamento.cliente_nome} - ${agendamento.servico_nome} 
                                    (${agendamento.colaborador_nome}) - ${agendamento.data_hora}
                                 </option>`;
                        });
                    } else {
                        options = '<option value="">Nenhum agendamento encontrado para essa data.</option>';
                    }
                    $('#agendamento_id').html(options);
                }
            });
        }

    });
</script>


<script>
    $(document).ready(function () {
        $('#processarAgendamentoForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'agendamentos/processar_agendamento.php',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: 'Sucesso!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#processarAgendamentoForm')[0].reset();
                        $('#processarAgendamentoModal').modal('hide');
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: response.message,
                            showConfirmButton: true
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Erro ao atualizar agendamento. Tente novamente.",
                        showConfirmButton: true
                    });
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>