google.load("visualization", "1.1", {packages: ["table"]});
//TABLA DE BANNERS POR SEMANA CLICKS
google.setOnLoadCallback(drawTableTablaClic);
function drawTableTablaClic() {
    var banners = $.ajax({
        url: '/json/bannersClic2015' + yOSON.semana + '.json',
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
            }, 0.6);
    var table = new google.visualization.Table(document.getElementById('banner_clic'));
    table.draw(data, {showRowNumber: true, width: '100%'});

}



//TABLA DE BANNERS POR SEMANA IMPRESIONES
    google.setOnLoadCallback(drawTableTabla);
    function drawTableTabla() {
        var banners = $.ajax({
            url: '/json/banners2015' + yOSON.semana + '.json',
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
                }, 0.6);
        var table = new google.visualization.Table(document.getElementById('table_div'));
       table.draw(data, {showRowNumber: true, width: '100%'});
    }