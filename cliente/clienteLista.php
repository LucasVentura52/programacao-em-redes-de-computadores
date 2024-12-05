<div class="container mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h2 class="h5 mb-2 mb-md-0">Lista de Clientes</h2>
        <div class="input-group mb-2 mb-md-0" style="max-width: 100%; width: 400px;">
            <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar clientes">
            <div class="input-group-append">
                <button class="btn btn-outline-info" type="button" id="searchButton">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-end align-items-center">
            <div class="mb-2 mb-md-0 mr-2">
                <button type="button" class="btn btn-outline-primary btn-sm"
                    onclick="filtrarClientes('ativo')">Ativos</button>
                <button type="button" class="btn btn-sm btn-outline-warning btn-sm"
                    onclick="filtrarClientes('inativo')">Inativos</button>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                data-target="#clienteModal">
                + Novo Cliente
            </button>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title" id="confirmDeleteLabel">Inativar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mt-2" style="height: 100%;">
                    Tem certeza de que deseja inativar este cliente?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" id="confirmDeleteButton">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'cliente/add/clienteModal.php'; ?>
    <?php include 'cliente/att/editarClienteModal.php'; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="clientesTable">
            <thead class="table-light">
                <tr>
                    <th>Status</th>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script>
    function filtrarClientes(status) {
        $.ajax({
            url: 'cliente/filtroClientes.php',
            type: 'GET',
            data: { status: status },
            success: function (data) {
                $('#clientesTable tbody').html(data);
            },
            error: function () {
                alert('Erro ao carregar clientes.');
            }
        });
    }

    function confirmDelete(id) {
        $('#confirmDeleteButton').data('id', id);
        $('#confirmDeleteModal').modal('show');
    }

    $('#confirmDeleteButton').click(function () {
    const id = $(this).data('id');
    $.ajax({
        url: 'cliente/delete/deletarCliente.php',
        type: 'GET',
        data: { id: id },
        success: function (response) {
            $('#confirmDeleteModal').modal('hide');
            if (response === "O cliente já está inativo.") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção',
                    text: response,
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Sucesso!",
                    text: "Cliente inativado com sucesso!",
                    showConfirmButton: false,
                    timer: 1500
                });
                filtrarClientes('ativo');
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao inativar cliente.'
            });
        }
    });
});


    document.getElementById('searchInput').addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

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

    $(document).ready(function () {
        filtrarClientes('ativo');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>