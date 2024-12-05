<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Agendamentos</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
</head>

<body>
    <div id="calendar">
        <button type="button" class="btn btn-outline-success mb-2 mt-2" data-toggle="modal"
            data-target="#agendamentoModal">
            + Novo Agendamento
        </button>
        <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#processarAgendamentoModal">
            Processar Agendamento
        </button>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                events: 'calendario/load_events.php',
                eventClick: function (info) {
                    var selectedDate = info.event.startStr;

                    loadEventosDoDia(selectedDate);

                    $('#eventosDoDiaModal').modal('show');
                }
            });

            calendar.render();
        });

        function loadEventosDoDia(date) {
            var formattedDate = new Date(date).toISOString().split('T')[0];

            $.ajax({
                url: 'calendario/load_events_modal.php',
                method: 'GET',
                data: { date: formattedDate },
                success: function (data) {
                    var eventos = JSON.parse(data);
                    var html = '';

                    if (eventos.length > 0) {
                        html += '<div class="card">';
                        html += '<ul class="list-group list-group-flush">';
                        eventos.forEach(function (evento) {
                            var eventDate = new Date(evento.start);
                            var eventFormattedDate = eventDate.toLocaleString('pt-BR', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric'
                            });

                            html += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                            html += '<div>';
                            html += '<strong>' + evento.title + '</strong><br>';
                            html += '<small>' + eventFormattedDate + '</small>';
                            html += '</div>';
                            html += `<button class="btn btn-sm btn-outline-primary" 
            data-toggle="modal" 
            data-target="#editarAgendamentoModal"
            onclick="carregarDadosEdicao(${evento.id})">
            <i class="fas fa-edit"></i>Editar
        </button>`;


                            html += '</li>';
                        });
                        html += '</ul>';
                        html += '</div>';
                    } else {
                        html = '<p class="text-center">Nenhum evento encontrado para esta data.</p>';
                    }

                    $('#eventosDoDiaBody').html(html);
                }
            });
        }
    </script>

</body>

</html>