$('#carregarRelatorioAtivoInativo').click(function () {
    var status = $('#statusRelatorio').val();
    var mes = $('#mesRelatorio').val();    
    var ano = $('#anoRelatorio').val();       

    $('#calendarContainer').hide();
    $('#clientesContainer').hide();
    $('#relatorioContainer').hide();
    $('#relatorioContainerAtivoInativo').show(); 

    $('#relatorioContentAtivoInativo').load('relatorios/statusAgendamentos.php?status=' + status + '&mes=' + mes + '&ano=' + ano, function (response, status, xhr) {
        if (status == "error") {
            $('#relatorioContentAtivoInativo').html("Erro ao carregar relatório: " + xhr.status + " " + xhr.statusText);
        }
    });
});



$('#carregarRelatorio').click(function () {
    var tipo = $('#tipo').val();
    var mes = $('#mes').val();
    var ano = $('#ano').val();

    $('#calendarContainer').hide();
    $('#clientesContainer').hide();
    $('#relatorioContainerAtivoInativo').hide();
    $('#relatorioContainer').show();

    $('#relatorioContent').load('relatorios/rankingClientes.php?tipo=' + tipo + '&mes=' + mes + '&ano=' + ano, function (response, status, xhr) {
        if (status == "error") {
            $('#relatorioContent').html("Erro ao carregar relatório: " + xhr.status + " " + xhr.statusText);
        }
    });
});

$('#carregarRelatorioDiaMes').click(function () {
    var mes = $('#mesDiaMes').val();
    var ano = $('#anoDiaMes').val();

    $('#calendarContainer').hide();
    $('#clientesContainer').hide();
    $('#relatorioContainerAtivoInativo').hide();
    $('#relatorioDiaMes').show();

    $('#relatorioContentDiaMes').load('relatorios/diaMesAgendamentos.php?mes=' + mes + '&ano=' + ano, function (response, status, xhr) {
        if (status == "error") {
            $('#relatorioContentDiaMes').html("Erro ao carregar relatório: " + xhr.status + " " + xhr.statusText);
        }
    });
});

$('#carregarRelatorioServico').click(function () {
    var mes = $('#mesServico').val();
    var ano = $('#anoServico').val();

    $('#calendarContainer').hide();
    $('#clientesContainer').hide();
    $('#relatorioDiaMes').hide();
    $('#relatorioContainerAtivoInativo').hide();
    $('#relatorioServicoExecutado').show();

    $('#relatorioContentServico').load('relatorios/servicoMaisExecutado.php?mes=' + mes + '&ano=' + ano, function (response, status, xhr) {
        if (status == "error") {
            $('#relatorioContentServico').html("Erro ao carregar relatório: " + xhr.status + " " + xhr.statusText);
        }
    });
});







// BAIXAR RELATÓRIOS
$('#baixarRelatorio').click(function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const logoURL = 'assets/img/logo.png';

    const img = new Image();
    img.src = logoURL;

    img.onload = function () {
        const pageWidth = doc.internal.pageSize.getWidth();
        const logoWidth = 35;
        const logoHeight = 25;
        const logoX = (pageWidth - logoWidth) / 2;

        doc.addImage(img, 'PNG', logoX, 10, logoWidth, logoHeight);

        doc.setFontSize(16);
        doc.text("INVICTUS BARBER SYSTEM", pageWidth / 2, 40, { align: 'center' });

        const tipo = $('#tipo').val();
        const mes = $('#mes').find('option:selected').text();
        const ano = $('#ano').val();
      
        doc.setFontSize(10);
        doc.text(`Tipo: ${tipo}`, 10, 55);
        doc.text(`Mês: ${mes}`, 60, 55);
        doc.text(`Ano: ${ano}`, 110, 55);

        var content = document.getElementById('relatorioContent');

        html2canvas(content).then(canvas => {
            var imgData = canvas.toDataURL('image/png');
            var imgWidth = 190;
            var imgHeight = canvas.height * imgWidth / canvas.width;
            var position = 60;

            doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);

            doc.save('relatorio_cliente_colaborador.pdf');
        });
    };
});




$('#baixarRelatorioDiaMes').click(function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const logoURL = 'assets/img/logo.png';

    const img = new Image();
    img.src = logoURL;

    img.onload = function () {
        const pageWidth = doc.internal.pageSize.getWidth();
        const logoWidth = 35;
        const logoHeight = 25;
        const logoX = (pageWidth - logoWidth) / 2;

        doc.addImage(img, 'PNG', logoX, 10, logoWidth, logoHeight);

        doc.setFontSize(16);
        doc.text("INVICTUS BARBER SYSTEM", pageWidth / 2, 40, { align: 'center' });

        const mes = $('#mesDiaMes').find('option:selected').text();
        const ano = $('#anoDiaMes').val();

        doc.setFontSize(10);
        doc.text(`Mês: ${mes}`, 13, 55);
        doc.text(`Ano: ${ano}`, 60, 55);

        var content = document.getElementById('relatorioContentDiaMes');

        html2canvas(content).then(canvas => {
            var imgData = canvas.toDataURL('image/png');
            var imgWidth = 190;
            var imgHeight = canvas.height * imgWidth / canvas.width;
            var position = 60;

            doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);

            doc.save('relatorio_dia_mes.pdf');
        });
    };
});


$('#baixarRelatorioServico').click(function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const logoURL = 'assets/img/logo.png';

    const img = new Image();
    img.src = logoURL;

    img.onload = function () {
        const pageWidth = doc.internal.pageSize.getWidth();
        const logoWidth = 35;
        const logoHeight = 25;
        const logoX = (pageWidth - logoWidth) / 2;

        doc.addImage(img, 'PNG', logoX, 10, logoWidth, logoHeight);

        doc.setFontSize(16);
        doc.text("INVICTUS BARBER SYSTEM", pageWidth / 2, 40, { align: 'center' });

        const mes = $('#mesServico').find('option:selected').text();
        const ano = $('#anoServico').val();

        doc.setFontSize(10);
        doc.text(`Mês: ${mes}`, 10, 55);
        doc.text(`Ano: ${ano}`, 50, 55);

        var content = document.getElementById('relatorioContentServico');

        html2canvas(content).then(canvas => {
            var imgData = canvas.toDataURL('image/png');
            var imgWidth = 190;
            var imgHeight = canvas.height * imgWidth / canvas.width;
            var position = 60;

            doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);

            doc.save('relatorio_servico_executado.pdf');
        });
    };
});




$('#baixarRelatorioAtivoInativo').click(function () {
    console.log("Iniciando geração do PDF...");
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const logoURL = 'assets/img/logo.png';

    const img = new Image();
    img.src = logoURL;

    img.onload = function () {
        const pageWidth = doc.internal.pageSize.getWidth();
        const logoWidth = 35;
        const logoHeight = 25;
        const logoX = (pageWidth - logoWidth) / 2;

        doc.addImage(img, 'PNG', logoX, 10, logoWidth, logoHeight);

        doc.setFontSize(16);
        doc.text("INVICTUS BARBER SYSTEM", pageWidth / 2, 40, { align: 'center' });

        const status = $('#statusRelatorio').val();
        const mes = $('#mesRelatorio').find('option:selected').text();
        const ano = $('#anoRelatorio').val();


        doc.setFontSize(10);
        doc.text(`Status: ${status}`, 10, 55);
        doc.text(`Mês: ${mes}`, 10, 55);
        doc.text(`Ano: ${ano}`, 50, 55);

        var content = document.getElementById('relatorioContentAtivoInativo');

        html2canvas(content).then(canvas => {
            var imgData = canvas.toDataURL('image/png');
            var imgWidth = 190;
            var imgHeight = canvas.height * imgWidth / canvas.width;
            var position = 60;

            doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);

            doc.save('relatorio_agend_confirmado_cancelado.pdf');
        });
    };
});


