<!-- Modal para Editar Colaborador -->
<div class="modal fade" id="editarColaboradorModal" tabindex="-1" aria-labelledby="editarColaboradorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="editarColaboradorModalLabel">Editar Colaborador</h5>
            </div>
            <div class="modal-body" style="height: 100%">
                <form id="formEditarColaborador" action="colaborador/att/atualizarColaborador.php" method="POST">
                    <input type="hidden" name="id" id="editarColaboradorId">
                    <div class="row">
                        <div class="form-group col-md-6 input-group">
                            <span class="input-icon">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" id="editarNomeColaborador" name="nome"
                                maxlength="100" placeholder="Nome" required>
                        </div>
                        <div class="form-group col-md-6 input-group">
                            <span class="input-icon">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" id="editarSobrenomeColaborador" name="sobrenome"
                                maxlength="100" placeholder="Sobrenome" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 input-group">
                            <span class="input-icon">
                                <i class="fas fa-id-card"></i>
                            </span>
                            <input type="text" class="form-control" id="editarCpfColaborador" name="cpf" maxlength="11"
                                placeholder="CPF sem pontuações" required>
                        </div>
                        <div class="form-group col-md-6 input-group">
                            <span class="input-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="date" class="form-control" id="editarDataNascimentoColaborador"
                                name="data_nascimento" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 input-group">
                            <span class="input-icon">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="text" class="form-control" id="editarTelefoneColaborador" name="telefone"
                                maxlength="20" placeholder="Telefone" required>
                        </div>
                        <div class="form-group col-md-6 input-group">
                            <span class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" id="editarEmailColaborador" name="email"
                                maxlength="100" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 input-group">
                            <span class="input-icon">
                                <i class="fas fa-briefcase"></i>
                            </span>
                            <input type="text" class="form-control" id="editarCargoColaborador" name="cargo"
                                maxlength="100" placeholder="Cargo" required>
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
    function carregarDadosColaborador(id) {
        fetch(`colaborador/att/getColaborador.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editarColaboradorId').value = data.id;
                document.getElementById('editarNomeColaborador').value = data.nome;
                document.getElementById('editarSobrenomeColaborador').value = data.sobrenome;
                document.getElementById('editarCpfColaborador').value = data.cpf;
                document.getElementById('editarDataNascimentoColaborador').value = data.data_nascimento;
                document.getElementById('editarTelefoneColaborador').value = data.telefone;
                document.getElementById('editarEmailColaborador').value = data.email;
                document.getElementById('editarCargoColaborador').value = data.cargo;
            })
            .catch(error => console.error('Erro ao carregar dados do colaborador:', error));
    }
</script>

<script>
    function validarCpfColaborador(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }

        let soma = 0;
        let resto;
        for (let i = 1; i <= 9; i++) {
            soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) {
            resto = 0;
        }
        if (resto !== parseInt(cpf.substring(9, 10))) {
            return false;
        }

        soma = 0;
        for (let i = 1; i <= 10; i++) {
            soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) {
            resto = 0;
        }
        return resto === parseInt(cpf.substring(10, 11));
    }
</script>

<script>
    document.getElementById('formEditarColaborador').addEventListener('submit', function (event) {
        event.preventDefault();

        const cpfInput = document.getElementById('editarCpfColaborador');
        const cpf = cpfInput.value;

        if (!validarCpfColaborador(cpf)) {
            Swal.fire({
                icon: 'error',
                title: 'CPF inválido',
                text: 'Por favor, insira um CPF válido.',
                showConfirmButton: false,
                timer: 2500
            });
            return;
        }

        const formData = new FormData(this);

        fetch('colaborador/att/atualizarColaborador.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: 'Sucesso!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#editarColaboradorModal').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao processar a requisição'
                });
            });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>