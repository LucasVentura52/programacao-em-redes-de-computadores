

<div class="modal fade" id="servicoModalAdd" tabindex="-1" aria-labelledby="servicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="servicoModalLabel">Cadastrar Serviço</h5>
            </div>
            <div class="modal-body" style="height: 100%">
                <form id="formCadastroServico" action="servico/add/addServico.php" method="POST">
                    <div class="row">

                        <div class="form-group col-md-12 input-group">
                            <span class="input-icon" style="padding-right: 10px;">
                                <i class="fas fa-cogs"></i>
                            </span>
                            <input type="text" class="form-control ml-2" id="nome" name="nome" maxlength="100"
                                placeholder="Nome do Serviço" required>
                        </div>

                        <div class="form-group col-md-12 input-group">
                            <span class="input-icon" style="padding-right: 10px;">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <textarea class="ml-2 form-control" id="descricao" name="descricao" maxlength="255"
                                placeholder="Descrição do Serviço" required></textarea>
                        </div>
                        <div class="form-group col-md-12 input-group">
                            <span class="input-icon" style="padding-right: 10px;">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                            <input type="number" class="ml-2 form-control" id="preco" name="preco" step="0.01"
                                placeholder="Preço" required>
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
    $('#formCadastroServico').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: 'servico/add/addServico.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#servicoModalAdd').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    filtrarServicos('ativo');
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao adicionar o serviço. Tente novamente.'
                });
            }
        });
    });
</script>