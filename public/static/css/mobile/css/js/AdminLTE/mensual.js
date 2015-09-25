//TABLA DE BANNERS POR SEMANA -VISITAS-HOME-USUARIOS UNICOS
google.load("visualization", "1.1", {packages: ["table"]});
google.setOnLoadCallback(drawTable);
function drawTable() {
    var banners = $.ajax({
        url: '/json/bannersConsolidado2015Mensual.json',
        type: 'post',
        dataType: 'json',
        async: false
    }).responseText;
    banners = JSON.parse(banners);
    var bannersName = $.ajax({
        url: '/json/bannersName2015Mensual.json',
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

