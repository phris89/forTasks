//Модуль фильтрации

$('.filter input').on('input', function () {
    filterTable($(this).parents('table'));
});

function filterTable($table) {
    var $filters = $table.find('.filter td');
    var $rows = $table.find('.data');
    $rows.each(function (rowIndex) {
        var valid = true;
        $(this).find('td').each(function (colIndex) {
            if ($filters.eq(colIndex).find('input').val()) {
                if ($(this).html().toLowerCase().indexOf(
                $filters.eq(colIndex).find('input').val().toLowerCase()) == -1) {
                    valid = valid && false;
                }
            }
        });
        if (valid === true) {
            $(this).css('display', '');
        } else {
            $(this).css('display', 'none');
        }
    });
};

//модуль сортировки

$(document).ready(function(){
    $("#kursValut").tablesorter();
});