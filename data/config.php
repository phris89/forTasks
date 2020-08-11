<?php

// Реализована запись курсов валют одну большую таблицу

$dateForPage = date("d/m/Y"); // Дата для отображения на странице, за какой период выведены курсы валют
//$dateForPage = "07/10/2018"; // Альтернативная дата. Внимание! Если ставить альтернативную дату, то далее в коде нужно будет еще в одном местае поменять дату

$connectToDb = mysqli_connect("localhost", "root", "");  // коннектимся к MySQL для создания БД

/*if (!$connectToDb){
  die("Ошибка подключения: " . mysqli_connect_error()); // Если не удалось законнектиться
}*/
 
 
$dbCreate = "CREATE DATABASE IF NOT EXISTS cbRF_Kurs"; // SQL запрос

if (mysqli_query($connectToDb, $dbCreate)) { // Создаем БД. Вывод сообщения об успешном или не успешном создании БД
  //echo "База данных создана успешно";
} else {
  //echo "Ошибка создания базы данных: " . mysqli_error($connectToDb);
}

mysqli_select_db($connectToDb, "cbRF_Kurs"); // коннектимся к созданной БД


//Получаем курс валют на текущую дату

$contents = get_content();
$pattern = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i";
preg_match_all($pattern, $contents, $out, PREG_SET_ORDER);

function get_content(){

  $date = date("d/m/Y");
  //$date = "07/10/2018"; // Альтернативная дата.


  $link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=" . $date;
  //echo $link;
  $fd = @fopen($link, "r");
  $text="";
  if (!$fd) echo "Сервер ЦБ не отвечает";
  else
  {
    while (!feof ($fd)) $text .= fgets($fd, 4096);
    fclose ($fd);
  }
return $text;
}

// Если таблица не существует - создаем ее
$createTable = "CREATE TABLE IF NOT EXISTS currency (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  curName VARCHAR(40) NOT NULL,
  curValue VARCHAR(40) NOT NULL,
  dateOfKurs VARCHAR(20) NOT NULL
)";

if (mysqli_query($connectToDb, $createTable)) {         // Активация запроса и проверка на успех создания таблицы
  //echo "Таблица 'currency' создана успешно";
} else {
  //echo "Ошибка создания таблицы: " . mysqli_error($conn);
}

$checkOfData = mysqli_query($connectToDb, "SELECT COUNT(*) FROM `currency` WHERE `dateOfKurs` ='$dateForPage'"); // Получаем количество записей с заданной датой в таблице
$check = mysqli_fetch_array($checkOfData);
//echo $check[0];


// Если записей с заданной датой в таблице нет - заносим данные в таблицу
if ($check[0] == 0){
  foreach($out as $row => $r){
    $r[3] = mb_convert_encoding($r[3], "UTF-8", "windows-1251");
    $r[4] = str_replace(",",".",$r[4]);
    $query = "INSERT INTO currency SET
      curName=  '$r[3]',
      curValue= '$r[4]',
      dateOfKurs= '$dateForPage'";
    mysqli_query($connectToDb, $query);
  }
}

//print_r ($out);

mysqli_close($connectToDb);

?>