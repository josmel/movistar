//CLICKS POR TEXT LINK
google.load("visualization", "1", {packages: ["corechart"]});
google.setOnLoadCallback(drawVisualizationTextLink);

function drawVisualizationTextLink() {
    var datosTextLink = $.ajax({
        url: '/json/textLink2015' + yOSON.semana + '.json',
        type: 'post',
        dataType: 'json',
        async: false
    }).responseText;
    datosTextLink = JSON.parse(datosTextLink);
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(datosTextLink);

    var options = {
//        title: 'Monthly Coffee Production by Country',
         vAxis: {title: "Clicks"},
        hAxis: {title: "Día"},
        seriesType: "bars",
        series: {4: {type: "line"}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('text_link_clic'));
    chart.draw(data, options);
}
//CLICKS POR CATEGORIA MISICA
google.setOnLoadCallback(drawVisualizationMusica);
function drawVisualizationMusica() {
    var datosMusica = $.ajax({
        url: '/json/musica2015' + yOSON.semana + '.json',
        type: 'post',
        dataType: 'json',
        async: false
    }).responseText;
    datosMusica = JSON.parse(datosMusica);
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(datosMusica);

    var options = {
//        title: 'Monthly Coffee Production by Country',
        vAxis: {title: "Clicks"},
        hAxis: {title: "Día"},
        seriesType: "bars",
        series: {5: {type: "line"}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('music_clic'));
    chart.draw(data, options);
}
//CLICKS POR CATEGORIA JUEGO
google.setOnLoadCallback(drawVisualizationJuego);

function drawVisualizationJuego() {
        var datosJuego = $.ajax({
        url: '/json/juego2015' + yOSON.semana + '.json',
        type: 'post',
        dataType: 'json',
        async: false
    }).responseText;
    datosJuego = JSON.parse(datosJuego);
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(datosJuego);

    var options = {
//        title: 'Monthly Coffee Production by Country',

         vAxis: {title: "Clicks"},
        hAxis: {title: "Día"},
        seriesType: "bars",
        series: {5: {type: "line"}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('juego_clic'));
    chart.draw(data, options);
}
//CLICKS POR CATEGORIA TOP LINK
google.setOnLoadCallback(drawVisualizationTopLink);

function drawVisualizationTopLink() {
     var datosTopLink = $.ajax({
        url: '/json/topLink2015' + yOSON.semana + '.json',
        type: 'post',
        dataType: 'json',
        async: false
    }).responseText;
    datosTopLink = JSON.parse(datosTopLink);
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(datosTopLink);

    var options = {
//        title: 'Monthly Coffee Production by Country',

        vAxis: {title: "Clicks"},
        hAxis: {title: "Día"},
        seriesType: "bars",
        series: {5: {type: "line"}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('top_link_clic'));
    chart.draw(data, options);
}

//CLICKS POR CATEGORIA SERVICIOS
google.setOnLoadCallback(drawVisualizationServicios);

function drawVisualizationServicios() {
    var datosServicios = $.ajax({
        url: '/json/servicios2015' + yOSON.semana + '.json',
        type: 'post',
        dataType: 'json',
        async: false
    }).responseText;
    datosServicios = JSON.parse(datosServicios);
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(datosServicios);

    var options = {
//        title: 'Monthly Coffee Production by Country',

        vAxis: {title: "Clicks"},
        hAxis: {title: "Día"},
        seriesType: "line",
        series: {8: {type: "line"}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('Servicios'));
    chart.draw(data, options);
}