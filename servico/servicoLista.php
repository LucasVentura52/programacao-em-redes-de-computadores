<!-- Inclusão dos arquivos PHP -->
<?php include 'servico/add/addServico.php'; ?>
<?php include 'servico/add/servicoModal.php'; ?>
<?php include 'servico/editServicoModal.php'; ?>



<!-- Cabeçalho da lista de serviços -->
<div class="container mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h2 class="h5 mb-2 mb-md-0">Lista de Serviços</h2>
        <div class="input-group mb-2 mb-md-0" style="max-width: 100%; width: 400px;">
            <input type="text" id="searchInputServico" class="form-control" placeholder="Pesquisar serviços">
            <div class="input-group-append">
                <button class="btn btn-outline-info" type="button" id="searchButton">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-end align-items-center">
            <div class="mb-2 mb-md-0 mr-2">
                <button type="button" class="btn btn-outline-primary btn-sm"
                    onclick="filtrarServicos('ativo')">Ativos</button>
                <button type="button" class="btn btn-sm btn-outline-warning btn-sm"
                    onclick="filtrarServicos('inativo')">Inativos</button>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                data-target="#servicoModalAdd">
                + Novo Serviço
            </button>
        </div>
    </div>

    <!-- Modal de Confirmação -->
<div class="modal fade" id="inativarServicoModal" tabindex="-1" aria-labelledby="inativarServicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="inativarServicoModalLabel">Inativar Serviço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body mt-2" style="height: 100%;">
                Tem certeza de que deseja inativar este serviço?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn btn-outline-danger" id="confirmInativar">Inativar</button>
            </div>
        </div>
    </div>
</div>



    <!-- Tabela para exibição dos serviços -->
    <div class="table-responsive">
        <table class="table table-hover align-middle" id="servicosTable">
            <thead class="table-light">
                <tr>
                    <th>Status</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>





</div>

<script>
let servicoIdParaInativar = null;

function confirmDeleteService(servicoId) {
    servicoIdParaInativar = servicoId;
    $('#inativarServicoModal').modal('show');
}

document.getElementById('confirmInativar').addEventListener('click', function () {
    if (servicoIdParaInativar !== null) {
       
        $.ajax({
            url: 'servico/inativarServico.php',
            type: 'POST',
            data: { id: servicoIdParaInativar },
            success: function (response) {
                $('#inativarServicoModal').modal('hide');
                
                if (response === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Serviço inativado com sucesso!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        filtrarServicos('ativo'); 
                    });
                } else if (response === 'already_inativo') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção',
                        text: 'Este serviço já está inativo.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Erro ao inativar o serviço.',
                        showConfirmButton: false,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro ao enviar a solicitação.',
                    showConfirmButton: false,
                });
            }
        });
    }
});


    function filtrarServicos(status) {
        $.ajax({
            url: 'servico/filtroServicos.php',
            type: 'GET',
            data: { status: status },
            success: function (data) {
                $('#servicosTable tbody').html(data);
            },
            error: function () {
                alert('Erro ao carregar serviços.');
            }
        });
    }
    
    $(document).ready(function () {
        filtrarServicos('ativo');
    });
    
    document.getElementById('searchInputServico').addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#servicosTable tbody tr');

        rows.forEach(row => {
            const columns = row.querySelectorAll('td');
            const nome = columns[2].textContent.toLowerCase();

            if (nome.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
