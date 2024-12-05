<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

</head>

<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
    }

    .modal-body {
        height: 70vh;
        margin-top: -30px;
    }

    .fc {
        height: 100%;
    }

    #clientesContainer {
        display: none;
    }

    #colaboradorContainer {
        display: none;
    }

    #servicoContainer {
        display: none;
    }



    .custom-dropdown {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.3s ease;
    }

    .custom-dropdown .dropdown-item {
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .custom-dropdown .dropdown-item:hover {
        background-color: #f0f0f0;
        color: #007bff;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark" ><!--style="height:90px;"-->
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center mr-5" href="#">
                <img src="assets/img/logo.png" width="110" height="90" class="d-inline-block align-top mr-2">
                INVICTUS BARBER SYSTEM
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="ml-5 collapse navbar-collapse justify-content-start" id="navbarNav">
                <ul class="navbar-nav" ><!--style="margin-left: -250px;"-->
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="mostrarCalendario">Agendamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="mostrarClientes">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="mostrarColaboradores">Colaboradores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="MostrarServicoContainer">Serviços</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="relatoriosDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Relatórios
                        </a>
                        <div class="dropdown-menu animated-dropdown custom-dropdown"
                            aria-labelledby="relatoriosDropdown">
                            <a class="dropdown-item" href="#" id="mostrarRanking">
                                <i class="fas fa-chart-line"></i> Ranking de clientes/colaboradores
                            </a>
                            <a class="dropdown-item" href="#" id="mostrarDiaMaisAgendamentos">
                                <i class="fas fa-calendar-day"></i> Dia/mês com mais agendamentos
                            </a>
                            <a class="dropdown-item" href="#" id="mostrarServico">
                                <i class="fas fa-wrench"></i> Serviço mais executado no mês
                            </a>
                            <a class="dropdown-item" href="#" id="mostrarAgend">
                                <i class="fas fa-check-circle"></i> Agendamentos concluídos/cancelados
                            </a>
                        </div>

                    </li>
                </ul>
            </div>

            <ul class="navbar-nav ml-auto mr-3">
                <li class="nav-item">
                    <a class="nav-link" href="#login"><i class="fas fa-user"></i> Entrar</a>
                </li>
            </ul>
        </div>
    </nav>






    <div class="container mt-4">
        <!-- Contêiner para o Calendário -->
        <div id="calendarContainer" class="modal-body" style="height: 520px;">
            <?php include 'calendario/calendario.php'; ?>
            <?php include 'agendamentos/add/addAgendamentoModal.php'; ?>
            <?php include 'agendamentos/processarAgendamentoModal.php'; ?>

        </div>



        <!-- Modal de Agendamentos do Dia -->
        <div class="modal fade" id="eventosDoDiaModal" tabindex="-1" role="dialog"
            aria-labelledby="eventosDoDiaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-secondary">
                        <h5 class="modal-title" id="eventosDoDiaModalLabel">Agendamentos do dia</h5>

                    </div>
                    <div class="modal-body mt-2" style="height: 100%" id="eventosDoDiaBody">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-block"
                            data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Contêiner para a Lista de Clientes -->
        <div id="clientesContainer" class="mt-2">
            <?php include 'cliente/clienteLista.php'; ?>
            <?php include 'cliente/att/atualizarCliente.php'; ?>
        </div>

        <!-- Contêiner para a Lista de Colaboradores -->
        <div id="colaboradorContainer" class="mt-2">
            <?php include 'colaborador/colaboradorLista.php'; ?>
        </div>

        <!-- Contêiner para a Lista de Serviços -->
        <div id="servicoContainer" class="mt-2">
            <?php include 'servico/servicoLista.php'; ?>
            <?php include 'servico/atualizar_servico.php'; ?>
        </div>



        <!-- Contêiner para Relatórios -->
        <!-- Relatório cliente / colaborador -->
        <div id="relatorioContainer" class="mt-40" style="display:none;">
            <div class="mb-3">
                <label for="tipo">Tipo:</label>
                <select id="tipo" class="form-control d-inline-block w-auto">
                    <option value="cliente">Cliente</option>
                    <option value="colaborador">Colaborador</option>
                </select>

                <label for="mes" class="ml-2">Mês:</label>
                <select id="mes" class="form-control d-inline-block w-auto">
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>

                </select>

                <label for="ano" class="ml-2">Ano:</label>
                <input type="number" id="ano" class="form-control d-inline-block w-auto"
                    value="<?php echo date('Y'); ?>" min="2000" max="<?php echo date('Y'); ?>" />

                <button id="carregarRelatorio" class="btn btn-outline-info ml-2">Carregar Relatório</button>
            </div>

            <div id="relatorioContent"></div>
            <button id="baixarRelatorio" class="btn btn-outline-warning mt-2">Baixar Relatório em PDF</button>
        </div>



        <!-- Relatório dia mês -->
        <div id="relatorioDiaMes" class="mt-4" style="display:none;">
            <div class="mb-3">
                <label for="mes">Mês:</label>
                <select id="mesDiaMes" class="form-control d-inline-block w-auto">
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>

                <label for="anoDiaMes" class="ml-2">Ano:</label>
                <input type="number" id="anoDiaMes" class="form-control d-inline-block w-auto"
                    value="<?php echo date('Y'); ?>" min="2000" max="<?php echo date('Y'); ?>" />

                <button id="carregarRelatorioDiaMes" class="btn btn-outline-info ml-2">Carregar Relatório</button>
            </div>

            <div id="relatorioContentDiaMes"></div>
            <button id="baixarRelatorioDiaMes" class="btn btn-outline-warning mt-2">Baixar Relatório em PDF</button>
        </div>


        <!-- Relatório serviços -->
        <div id="relatorioServicoExecutado" class="mt-4" style="display:none;">
            <div class="mb-3">
                <label for="mesServico">Mês:</label>
                <select id="mesServico" class="form-control d-inline-block w-auto">
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>

                <label for="anoServico" class="ml-2">Ano:</label>
                <input type="number" id="anoServico" class="form-control d-inline-block w-auto"
                    value="<?php echo date('Y'); ?>" min="2000" max="<?php echo date('Y'); ?>" />

                <button id="carregarRelatorioServico" class="btn btn-outline-info ml-2">Carregar Relatório</button>
            </div>

            <div id="relatorioContentServico"></div>
            <button id="baixarRelatorioServico" class="btn btn-outline-warning mt-2">Baixar Relatório em PDF</button>
        </div>





        <div id="relatorioContainerAtivoInativo" class="mt-40" style="display:none;">
            <div class="mb-3">
                <label for="statusRelatorio">Status:</label>
                <select id="statusRelatorio" class="form-control d-inline-block w-auto">
                    <option value="confirmado">Confirmado</option>
                    <option value="cancelado">Cancelado</option>
                </select>

                <label for="mesRelatorio" class="ml-2">Mês:</label>
                <select id="mesRelatorio" class="form-control d-inline-block w-auto">
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>

                <label for="anoRelatorio" class="ml-2">Ano:</label>
                <input type="number" id="anoRelatorio" class="form-control d-inline-block w-auto"
                    value="<?php echo date('Y'); ?>" min="2000" max="<?php echo date('Y'); ?>" />

                <button id="carregarRelatorioAtivoInativo" class="btn btn-outline-info ml-2">Carregar Relatório</button>
            </div>

            <div id="relatorioContentAtivoInativo"></div>
            <button id="baixarRelatorioAtivoInativo" class="btn btn-outline-warning mt-2">Baixar Relatório em
                PDF</button>
        </div>
    </div>





    <script>
        $(document).ready(function () {
            $('#mostrarCalendario').click(function () {
                $('#calendarContainer').show();
                $('#servicoContainer').hide();
                $('#colaboradorContainer').hide();
                $('#clientesContainer').hide();
                $('#relatorioContainer').hide();
                $('#relatorioDiaMes').hide();
                $('#relatorioServicoExecutado').hide();
                $('#relatorioContainerAtivoInativo').hide();
            });

            $('#mostrarClientes').click(function () {
                $('#clientesContainer').show();
                $('#servicoContainer').hide();
                $('#colaboradorContainer').hide();
                $('#calendarContainer').hide();
                $('#relatorioContainer').hide();
                $('#relatorioDiaMes').hide();
                $('#relatorioServicoExecutado').hide();
                $('#relatorioContainerAtivoInativo').hide();
            });

            $('#mostrarColaboradores').click(function () {
                $('#colaboradorContainer').show();
                $('#servicoContainer').hide();
                $('#clientesContainer').hide();
                $('#calendarContainer').hide();
                $('#relatorioContainer').hide();
                $('#relatorioDiaMes').hide();
                $('#relatorioServicoExecutado').hide();
                $('#relatorioContainerAtivoInativo').hide();
            });

            $('#MostrarServicoContainer').click(function () {
                $('#servicoContainer').show();
                $('#colaboradorContainer').hide();
                $('#clientesContainer').hide();
                $('#calendarContainer').hide();
                $('#relatorioContainer').hide();
                $('#relatorioDiaMes').hide();
                $('#relatorioServicoExecutado').hide();
                $('#relatorioContainerAtivoInativo').hide();
            });

            $('#mostrarRanking').click(function () {
                $('#calendarContainer').hide();
                $('#clientesContainer').hide();
                $('#colaboradorContainer').hide();
                $('#servicoContainer').hide();
                $('#relatorioDiaMes').hide();
                $('#relatorioServicoExecutado').hide();
                $('#relatorioContainerAtivoInativo').hide();
                $('#relatorioContainer').show();
            });

            $('#mostrarDiaMaisAgendamentos').click(function () {
                $('#calendarContainer').hide();
                $('#clientesContainer').hide();
                $('#colaboradorContainer').hide();
                $('#servicoContainer').hide();
                $('#relatorioContainer').hide();
                $('#relatorioServicoExecutado').hide();
                $('#relatorioContainerAtivoInativo').hide();
                $('#relatorioDiaMes').show();
            });

            $('#mostrarServico').click(function () {
                $('#calendarContainer').hide();
                $('#clientesContainer').hide();
                $('#colaboradorContainer').hide();
                $('#servicoContainer').hide();
                $('#relatorioDiaMes').hide();
                $('#relatorioContainer').hide();
                $('#relatorioContainerAtivoInativo').hide();
                $('#relatorioServicoExecutado').show();
            });

            $('#mostrarAgend').click(function () {
                $('#relatorioContainerAtivoInativo').show();
                $('#calendarContainer').hide();
                $('#clientesContainer').hide();
                $('#colaboradorContainer').hide();
                $('#servicoContainer').hide();
                $('#relatorioDiaMes').hide();
                $('#relatorioContainer').hide();
                $('#relatorioServicoExecutado').hide();
            });
        });
    </script>

    <!-- Scripts do jQuery e Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="assets/script/relatorios/relatorios.js"></script>
    <script src="assets/script/script.js"></script>


</body>

</html>