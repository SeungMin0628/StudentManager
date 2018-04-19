<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-04-12
 * Time: 오전 12:13
 */
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);


        function drawVisualization() {

            var data = google.visualization.arrayToDataTable([
                ['출결',  '횟수', { role: 'style' }],
                ['출석',    {{ $attendance }}, '#00b807'],
                ['지각',    {{ $late }}, '#b8a400'],
                ['결석',    {{ $absence }}, '#b80400'],
                ['조퇴',    {{ $late }}, '#040002']
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);


            var options = {
                title : '출결 그래프',
                legend: { position: "none" },

            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(view, options);
        }
    </script>
</head>

<body>
<div id="chart_div" style="width:400px; height: 150px; margin-left: -30px"></div>
</body>

</html>
