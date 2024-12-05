<!-- Modal de Edição -->
<div class="modal fade" id="editarServicoModal" tabindex="-1" aria-labelledby="editarServicoModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title" id="editarServicoModalLabel">Editar Serviço</h5>
      </div>
      <div class="modal-body" style="height: 100%">
        <form id="formEditarServico" method="POST" action="servico/atualizar_servico.php">
          <div class="row">
            <input type="hidden" name="id" id="editarServicoId">
            <div class="form-group col-md-12 input-group">
              <span class="input-icon" style="padding-right: 10px;">
                <i class="fas fa-cogs"></i>
              </span>
              <input type="text" class="ml-2 form-control" id="editarServicoNome" name="nome" maxlength="100"
                placeholder="Nome do Serviço" required>
            </div>
            <div class="form-group col-md-12 input-group">
              <span class="input-icon" style="padding-right: 10px;">
                <i class="fas fa-info-circle"></i>
              </span>
              <textarea class="ml-2 form-control" id="editarServicoDescricao" name="descricao" maxlength="255"
                placeholder="Descrição do Serviço" required></textarea>
            </div>
            <div class="form-group col-md-12 input-group">
              <span class="input-icon" style="padding-right: 10px;">
                <i class="fas fa-dollar-sign"></i>
              </span>
              <input type="number" class="ml-2 form-control" id="editarServicoPreco" name="preco" step="0.01"
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
  function carregarDadosServico(id) {
    fetch(`servico/buscar_servico.php?id=${id}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('editarServicoId').value = data.id;
        document.getElementById('editarServicoNome').value = data.nome;
        document.getElementById('editarServicoDescricao').value = data.descricao;
        document.getElementById('editarServicoPreco').value = data.preco;
      })
      .catch(error => console.error('Erro ao carregar dados:', error));
  }
</script>


<script>
  document.getElementById('formEditarServico').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch(this.action, {
      method: 'POST',
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: data.message,
            showConfirmButton: false,
            timer: 1500
          });
          $('#editarServicoModal').modal('hide');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: data.message,
            showConfirmButton: false,
            timer: 1500
          });
        }
      })
      .catch((error) => {
        console.error('Erro ao atualizar serviço:', error);
        Swal.fire({
          icon: 'error',
          title: 'Erro!',
          text: 'Ocorreu um erro ao atualizar o serviço. Por favor, tente novamente.',
          confirmButtonText: 'OK',
        });
      });
  });
</script>