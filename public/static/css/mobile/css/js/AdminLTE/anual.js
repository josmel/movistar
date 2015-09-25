    google.load("visualization", "1.1", {packages: ["calendar"]});
    google.setOnLoadCallback(drawChartHome);
    google.setOnLoadCallback(drawChartVisitas);
    google.setOnLoadCallback(drawChartUsuarios);

    function drawChartHome() {
        var datos = $.ajax({
            url: '/json/visitasDiariasAnual.json',
            type: 'post',
            dataType: 'json',
            async: false
        }).responseText;
        var dataTable = new google.visualization.DataTable(datos);
        var chart = new google.visualization.Calendar(document.getElementById('visitas_home_anuales'));
        var options = {
//          title: 'visitas al Home',
            height: 250,
            calendar: {cellSize: 11.8,
                yearLabel: {
                    fontName: 'Times-Roman',
                    fontSize: 32,
                    color: '#11256A',
                    bold: true,
                    italic: false
                },
                dayOfWeekLabel: {
                    fontName: 'Times-Roman',
                    fontSize: 11,
                    color: '#008C4C',
                    bold: true,
                    italic: false
                },
                dayOfWeekRightSpace: 10,
                daysOfWeek: 'DLMMJVS'}
        };
        chart.draw(dataTable, options);
    }
    function drawChartVisitas() {
        var datos = $.ajax({
            url: '/json/visitasTotalDiariasAnual.json',
            type: 'post',
            dataType: 'json',
            async: false
        }).responseText;
        var dataTable = new google.visualization.DataTable(datos);
        var chart = new google.visualization.Calendar(document.getElementById('visitas_totales_anuales'));
        var options = {
//          title: 'visitas al Home',
            height: 250,
            calendar: {cellSize: 11.8,
                yearLabel: {
                    fontName: 'Times-Roman',
                    fontSize: 32,
                    color: '#11256A',
                    bold: true,
                    italic: false
                },
                dayOfWeekLabel: {
                    fontName: 'Times-Roman',
                    fontSize: 11,
                    color: '#008C4C',
                    bold: true,
                    italic: false
                },
                dayOfWeekRightSpace: 10,
                daysOfWeek: 'DLMMJVS'}


        };
        chart.draw(dataTable, options);
    }
    
    function drawChartUsuarios() {
        var datos = $.ajax({
            url: '/json/visitasDiariasAnualUsuariosUnicos.json',
            type: 'post',
            dataType: 'json',
            async: false
        }).responseText;
        var dataTable = new google.visualization.DataTable(datos);
        var chart = new google.visualization.Calendar(document.getElementById('visitas_usuarios_anuales'));
        var options = {
//          title: 'visitas al Home',
            height: 250,
            calendar: {cellSize: 11.8,
                yearLabel: {
                    fontName: 'Times-Roman',
                    fontSize: 32,
                    color: '#11256A',
                    bold: true,
                    italic: false
                },
                dayOfWeekLabel: {
                    fontName: 'Times-Roman',
                    fontSize: 11,
                    color: '#008C4C',
                    bold: true,
                    italic: false
                },
                dayOfWeekRightSpace: 10,
                daysOfWeek: 'DLMMJVS'}
        };
        chart.draw(dataTable, options);
    }