<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socket Client Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/style.css">
</head>

<body>

    <div class="container mt-5 d-flex justify-content-center">
        <div class="container mt-5">
            <h1 class="text-center fw-bold" style="font-size: 2.5rem; color: #007bff;">Sistema de Comandos Socket</h1>
            <form id="commandForm" class="text-center mt-4">
                <div class="mb-3">
                    <label for="commandInput" class="form-label"
                        style="font-size: 1.5rem; color: #333; margin-top: 30px; margin-bottom: 10px;">
                        Comando para o Servidor:
                    </label>
                    <input type="text" class="form-control form-control-lg mx-auto" id="commandInput"
                        placeholder="Digite o comando" required style="max-width: 600px;">
                </div>
                <button type="submit" class="btn btn-success btn-lg">Enviar Comando</button>
            </form>
        </div>


        <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4 class="mb-4">Resposta do Servidor</h4>
                        <div id="modalResponse" class="p-3 border border-primary rounded text-center fs-5">
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-outline-danger btn-lg"
                                data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center fixed-bottom py-3 bg-dark text-white">
        <div class="copyright">
            <a>© 2024 Todos os direitos reservados.</a>
        </div>
        <p class="mb-0">Created by <a href="https://www.instagram.com/lucas_ventura__/">Lucas
            Ventura</a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="src/script/script.js"></script>
</body>

</html>