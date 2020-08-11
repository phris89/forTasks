<?php

$connectToDb = mysqli_connect("localhost", "root", "", "cbRF_Kurs"); // Полключаемся к БД

//  Получаем данные по валюте
$queryData = mysqli_query($connectToDb, "SELECT `curName`, `curValue`, `dateOfKurs` FROM `currency` WHERE `curName` = 'Доллар США'");
                          
$data = array(); // В этот массив будем записывать данные, необходимые для построения графика

// Далее идет построение массива данных для отрисовки графика.
// Следует отметить, что массив должен иметь определенную структуру (формат).
// Более подробно можно почитать в документации к Google Chart.

// Массив колонок (обозначения колонок и тип данных в них)
$data['cols'] = array(
    array('label' => 'Дата', 'type' => 'string'),
    array('label' => 'Доллар США', 'type' => 'number')
);

$rows = array(); // Сюда записывается массив строк для графика

while ($r = mysqli_fetch_array($queryData)){

    $temp = array();
    $temp[] = array('v' => (string) $r['dateOfKurs']); // Проверяем данные, связанные с, в данном случае, датой курса
    $temp[] = array('v' => (float) $r['curValue']); // Находим все данные по текущей дате
    $rows[] = array('c' => $temp);
}

$data['rows'] = $rows; // Объединяем массивы данных в один большой.

$jsonTable = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK); // Преобразуем наш массив в json формат, для работы с ним в javascript.

//echo $jsonTable;

mysqli_close($connectToDb);

?>