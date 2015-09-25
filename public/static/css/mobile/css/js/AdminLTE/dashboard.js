/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/



google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var datos = $.ajax({
            url:'http://local.devel.adminwap/json/grafica.json',
            type:'post',
            dataType:'json',
            async:false
        }).responseText;
        datos = JSON.parse(datos);
        var data = google.visualization.arrayToDataTable(datos);
        var options = {
//             backgroundColor:'#69D8D8',
            /*titulo  title: 'Mi consumo del café, cigarro y ron',
            /*   poner en 3d  */       is3D: false,
            /* tamanio del circulo*/pieHole: 0.5,
            /* color de del nombre*/      pieSliceTextStyle: {
                color: 'black',
            },
            /* poner leyenda*/     legend: 'true',
//            /* pongo el nombre en ves del porcentaje*/    pieSliceText: 'label',
            pieStartAngle: 100,
           

        };

        var chart = new google.visualization.PieChart(document.getElementById('piecharta'));
        chart.draw(data, options);
    }











$(function () {
    "use strict";

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
    //jQuery UI sortable for the todo list
    $(".todo-list").sortable({
        placeholder: "sort-highlight",
        handle: ".handle",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    ;

    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();

    $('.daterange').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            },
    function (start, end) {
        alert(start.format('MMMM D, YYYY'));exit;
        alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        
        
        
        
    }
            
            
            
        
            
            
            
            );

    /* jQueryKnob */
    $(".knob").knob();

    //jvectormap data
    var visitorsData = {
        "US": 398, //USA
        "SA": 400, //Saudi Arabia
        "CA": 1000, //Canada
        "DE": 500, //Germany
        "FR": 760, //France
        "CN": 300, //China
        "AU": 700, //Australia
        "BR": 600, //Brazil
        "IN": 800, //India
        "GB": 320, //Great Britain
        "RU": 3000 //Russia
    };
    //World map by jvectormap
    $('#world-map').vectorMap({
        map: 'world_mill_en',
        backgroundColor: "transparent",
        regionStyle: {
            initial: {
                fill: '#e4e4e4',
                "fill-opacity": 1,
                stroke: 'none',
                "stroke-width": 0,
                "stroke-opacity": 1
            }
        },
        series: {
            regions: [{
                    values: visitorsData,
                    scale: ["#92c1dc", "#ebf4f9"],
                    normalizeFunction: 'polynomial'
                }]
        },
        onRegionLabelShow: function (e, el, code) {
            if (typeof visitorsData[code] != "undefined")
                el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
        }
    });

    //Sparkline charts
    var myvalues = [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021];
    $('#sparkline-1').sparkline(myvalues, {
        type: 'line',
        lineColor: '#92c1dc',
        fillColor: "#ebf4f9",
        height: '50',
        width: '80'
    });
    myvalues = [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921];
    $('#sparkline-2').sparkline(myvalues, {
        type: 'line',
        lineColor: '#92c1dc',
        fillColor: "#ebf4f9",
        height: '50',
        width: '80'
    });
    myvalues = [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21];
    $('#sparkline-3').sparkline(myvalues, {
        type: 'line',
        lineColor: '#92c1dc',
        fillColor: "#ebf4f9",
        height: '50',
        width: '80'
    });

    //The Calender
    $("#calendar").datepicker();

    //SLIMSCROLL FOR CHAT WIDGET
    $('#chat-box').slimScroll({
        height: '250px'
    });

    /* Morris.js Charts */
    // Sales chart
    var revenu = $.ajax({
            url:'http://local.devel.adminwap/json/revenue-chart.json',
            type:'post',
            dataType:'json',
            async:false
        }).responseText;
        revenu = JSON.parse(revenu);
    var area = new Morris.Area({
        element: 'revenue-chart',
        resize: true,
        data:revenu,
        xkey: 'y',
        ykeys: ['item1', 'item2'],
        labels: ['Item 1', 'Item 2'],
        lineColors: ['#a0d0e0', '#3c8dbc'],
        hideHover: 'auto'
    });
     var linea = $.ajax({
            url:'http://local.devel.adminwap/json/line-chart.json',
            type:'post',
            dataType:'json',
            async:false
        }).responseText;
        linea = JSON.parse(linea);
    var line = new Morris.Line({
        element: 'line-chart',
        resize: true,
        data: linea,
        xkey: 'y',
        ykeys: ['item1'],
        labels: ['Item 1'],
        lineColors: ['#efefef'],
        lineWidth: 2,
        hideHover: 'auto',
        gridTextColor: "#fff",
        gridStrokeWidth: 0.4,
        pointSize: 4,
        pointStrokeColors: ["#efefef"],
        gridLineColor: "#efefef",
        gridTextFamily: "Open Sans",
        gridTextSize: 10
    });

    //Donut Chart
    var sales = $.ajax({
            url:'http://local.devel.adminwap/json/sales-chart.json',
            type:'post',
            dataType:'json',
            async:false
        }).responseText;
        sales = JSON.parse(sales);
    var donut = new Morris.Donut({
        element: 'sales-chart',
        resize: true,
        colors: ["#3c8dbc", "#f56954", "#00a65a"],
        data: sales,
        hideHover: 'auto'
    });
    /*Bar chart*/
       var datos = $.ajax({
            url:'http://local.devel.adminwap/json/chart.json',
            type:'post',
            dataType:'json',
            async:false
        }).responseText;
        datos = JSON.parse(datos);
     var bar = new Morris.Bar({
     element: 'bar-chart',
     resize: true,
     data: datos,
     barColors: ['#00a65a', '#f56954'],
     xkey: 'y',
     ykeys: ['a', 'b'],
     labels: ['CPU', 'DISK'],
     hideHover: 'auto'
     });
    //Fix for charts under tabs
    $('.box ul.nav a').on('shown.bs.tab', function (e) {
        area.redraw();
        donut.redraw();
    });


    /* BOX REFRESH PLUGIN EXAMPLE (usage with morris charts) */
//    $("#loading-example").boxRefresh({
//        source: "ajax/dashboard-boxrefresh-demo.php",
//        onLoadDone: function (box) {
//            bar = new Morris.Bar({
//                element: 'bar-chart',
//                resize: true,
//                data: [
//                    {y: '2006', a: 100, b: 90},
//                    {y: '2007', a: 75, b: 65},
//                    {y: '2008', a: 50, b: 40},
//                    {y: '2009', a: 75, b: 65},
//                    {y: '2010', a: 50, b: 40},
//                    {y: '2011', a: 75, b: 65},
//                    {y: '2012', a: 100, b: 90}
//                ],
//                barColors: ['#00a65a', '#f56954'],
//                xkey: 'y',
//                ykeys: ['a', 'b'],
//                labels: ['CPU', 'DISK'],
//                hideHover: 'auto'
//            });
//        }
//    });

    /* The todo list plugin */
    $(".todo-list").todolist({
        onCheck: function (ele) {
            //console.log("The element has been checked")
        },
        onUncheck: function (ele) {
            //console.log("The element has been unchecked")
        }
    });

});