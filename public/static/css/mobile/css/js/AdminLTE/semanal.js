//TABLA DE BANNERS POR SEMANA -VISITAS-HOME-USUARIOS UNICOS
google.load("visualization", "1.1", {packages: ["table"]});
google.setOnLoadCallback(drawTable);
function drawTable() {
    var banners = $.ajax({
        url: '/json/bannersConsolidado2015' + yOSON.semana + '.json',
        type: 'post',
        dataType: 'json',
        async: false
    }).responseText;
    banners = JSON.parse(banners);
    var bannersName = $.ajax({
        url: '/json/bannersName2015' + yOSON.semana + '.json',
        type: 'post',
        dataType: 'json',
        async: false
    }).responseText;
    bannersName = JSON.parse(bannersName);
    var data = new google.visualization.DataTable(
            {
                cols: bannersName,
                rows: banners
            }, 0.9);
    var table = new google.visualization.Table(document.getElementById('table_div2'));
    table.draw(data, {showRowNumber: true, width: '100%'});
}

//GRAFICA DE BARRAS DE VISITAS-Usuarios Unicos Al Home POR SEMANA
google.load("visualization", "1.1", {packages: ["corechart"]});
google.setOnLoadCallback(BarChart);
function BarChart() {
    var datos = $.ajax({
        url: '/json/visitaUsuario2015' + yOSON.semana + '.json',
        type: 'post',
        dataType: 'json',
        async: false
    }).responseText;
    datos = JSON.parse(datos);
    var data = google.visualization.arrayToDataTable(datos);

     var options = {
          curveType: 'function',
          legend: { position: 'top' }
        };
        
        var chart = new google.visualization.AreaChart(document.getElementById('barchart_material'));
//       var chart = new google.visualization.LineChart(document.getElementById('barchart_material'));
//    var chart = new google.charts.Bar(document.getElementById('barchart_material'));
    chart.draw(data, options);
}


    
