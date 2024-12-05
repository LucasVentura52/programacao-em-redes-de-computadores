<!-- Modal para Cadastro de Agendamentos -->
<style>
    .icon span i {
        position: absolute;
        left: -23px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2rem;
        color: #6c757d;
        pointer-events: none;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<div class="modal fade" id="agendamentoModal" tabindex="-1" aria-labelledby="agendamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="agendamentoModalLabel">Cadastrar Agendamento</h5>
            </div>
            <div class="modal-body" style="height: 100%;">
                <form id="agendamentoForm" action="agendamentos/agendamento.php" method="POST">
                    <div class="form-group">
                     

                        <label for="cliente_id">Cliente</label>

                        <div class="input-group icon mb-2">
                            <span>
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="pesquisaCliente"
                                placeholder="Digite o nome do cliente para filtrar">
                        </div>

                        <div class="input-group icon">
                            <span>
                                <i class="fas fa-user"></i>
                            </span>
                            <select class="form-control" id="cliente_id" name="cliente_id" required>
                                <?php
                                $conn = new mysqli('localhost', 'root', '', 'barbearia_db');
                                $result = $conn->query("SELECT * FROM clientes WHERE status = 'ativo'");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group icon">
                        <label for="colaborador_id">Colaborador</label>
                        <div class="input-group">
                            <span>
                                <i class="fas fa-user-tie"></i>
                            </span>
                            <select class="form-control" id="colaborador_id" name="colaborador_id" required>
                                <?php
                                $conn = new mysqli('localhost', 'root', '', 'barbearia_db');
                                $result = $conn->query("SELECT * FROM colaboradores WHERE status = 'ativo'");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group icon">
                        <label for="servico_id">Serviço</label>
                        <div class="input-group">
                            <span>
                                <i class="fas fa-cut"></i>
                            </span>
                            <select class="form-control" id="servico_id" name="servico_id" required>
                                <?php
                                $conn = new mysqli('localhost', 'root', '', 'barbearia_db');
                                $result = $conn->query("SELECT * FROM servicos WHERE status = 'ativo'");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group icon">
                        <label for="data_hora">Data e Hora</label>
                        <div class="input-group">
                            <span>
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">Cancelar</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                    </div>
                </form>
            </div>




        </div>
    </div>
</div>

<script>
    document.getElementById("pesquisaCliente").addEventListener("input", function () {
        let filter = this.value.toLowerCase();
        let options = document.getElementById("cliente_id").options;

        for (let i = 0; i < options.length; i++) {
            let optionText = options[i].text.toLowerCase();
            options[i].style.display = optionText.includes(filter) ? "" : "none";
        }
    });


    document.getElementById("agendamentoForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("agendamentos/add/addAgendamento.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            Swal.fire({
                position: "center",
                icon: "success",
                title: 'Sucesso!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            });
            document.getElementById("agendamentoForm").reset();
            $('#agendamentoModal').modal('hide');
        } else if (data.status === "warning") {
            Swal.fire({
                title: 'Aviso!',
                text: data.message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    formData.append('override_warning', 'true');
                    fetch("agendamentos/agendamento.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: 'Sucesso!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            document.getElementById("agendamentoForm").reset();
                            $('#agendamentoModal').modal('hide');
                        } else {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: data.message,
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                position: "center",
                icon: "error",
                title: 'Atenção!',
                text: data.message,
                showConfirmButton: false,
                timer: 2500
            });
        }
    })
    .catch(error => {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Erro ao processar a solicitação.",
            showConfirmButton: false,
            timer: 2500
        });
        console.error("Erro:", error);
    });
});



</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>