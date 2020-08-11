<?
include ("data/config.php");
//include ("data/dbTablesCreateAltVersion.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Загрузка данных</title>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.tablesorter.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <span>Загрузка данных с удаленного ресурса</span>
    <p><a href="data/graphicCurrancy.php">График изменения данных</a></p>
    <table id='kursValut'>
        <thead>
            <tr class='nameOfColumns'>
                <th>Название</th>
                <th>Количество</th>
            </tr>
        
            <tr class='filter'>
                <td>
                    <span style="padding-right: 10px;">Фильтр валют</span><input type="text"/>
                </td>
                <td>
                </td>
            </tr>
        </thead>
        <tbody>
        <?php 
            foreach ($out as $x) {
        ?>
            <tr class='data'>
                <td> <?php echo $x[3] = mb_convert_encoding($x[3], "UTF-8", "windows-1251") ?></td>
                <td> <?php echo $x[4] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <script src="js/filtrAndSort.js"></script>
</body>
</html>
