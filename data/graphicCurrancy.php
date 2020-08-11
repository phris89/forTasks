<?php 

include ("getDataForGraphic.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>График изменения данных</title>
</head>
<body>

<p><a href="../index.php">Вернуться на главную</a></p>

<div id="chart"></div>

<script>

// Код построения графика на js. Использую Google Charts.

google.load('visualization', '1', {'packages':['corechart']}); // Подгружаем модуль построения графика
google.setOnLoadCallback(drawChart);

// Функция для отрисовки графика
function drawChart() {
    var data = new google.visualization.DataTable(<?=$jsonTable?>); // Ссылаемся на массив, из которого берем данные

    // Параметры для отрисовки
    var options = {
        title: 'Изменение данных',
        curveType: 'function',
    };

    // Указываем, где будет нарисован график и отрисовываем его
    var chart = new google.visualization.LineChart(document.getElementById('chart'));
    chart.draw(data, options);
}

</script>

</body>
</html>