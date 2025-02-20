<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
global $DB;?>
<script>
    $( function() {
        $( "#fio_search" ).autocomplete({
            source: "ajax_persons.php",
            minLength: 2,
            select: function( event, ui ) {
                document.location.href = "index.php?mod=personal&oper=show&id="+ui.item.id;
            }
        });
        $( "#search_btn" ).click(function() {
            fio_choosen = $('#fio_search').val();
            if(fio_choosen!=='')
                document.location.href = "index.php?mod=personal&oper=show&search="+fio_choosen;
            else
                $('#search_error').show();
        });
        $('#fio_search').keypress(function (event) {
            if (event.which == 13) {
                fio_choosen = $('#fio_search').val();
                if(fio_choosen!=='')
                    document.location.href = "index.php?mod=personal&oper=show&search="+fio_choosen;
                else
                    $('#search_error').show();
            }
        });
    } );
</script>

<br>
Поиск по ФИО
<br>

<div class="ui-widget">
    <label for="fio_search">ФИО: </label>
    <input id="fio_search">
</div>
<button id="search_btn" style="width: 100%;">Поиск</button>
<div id="search_error" style="display: none; color: red">В поле поиска ничего не введено</div>
<br>

<br>
Отобразить записи, начинающиеся с буквы
<br>


<?php

$ss=$DB->select("SELECT substring(surname,1,1)as aa ,count(*) as cc FROM persons GROUP BY substring(surname,1,1)");
$summa=0;
foreach($ss as $i=>$bukva)
{
    echo "<br /><a href=/dreamedit/index.php?mod=personal&oper=show&smbl=".$bukva[aa].">".$bukva[aa]." [".$bukva[cc]."]"."</a>";
    $summa=$summa+$bukva[cc];
}
//print_r($ss);
echo "<br /><br />";


//$num = 0;
//  $result3 =  mysql_query("select * from persona");
//  while($count = mysql_fetch_array($result3)) $num++;

?>

<a href=/dreamedit/index.php?mod=personal&oper=show&smbl=all>ВСЕ [<? echo $summa; ?>]</a>
<br /><br /><hr />
<a href=/dreamedit/index.php?mod=personal&oper=adm&t=100>Состав администрации</a>
<br />  
<a href=/dreamedit/index.php?mod=personal&oper=adm&t=200>Состав Ученого совета</a><br />
 
<a href=/dreamedit/index.php?mod=personal&oper=adm&t=300>Состав Экспертов</a><br /><br /> 
<?
$dissovet=$DB->select("SELECT c.el_id,c.icont_text AS name FROM adm_directories_content AS c
                       INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=16
					   WHERE c.icont_var='text' 
					   ORDER BY el_id");
//print_r($dissovet);
foreach ($dissovet as $ds)
{
   echo "<a href=/dreamedit/index.php?mod=personal&oper=adm&t=".$ds[el_id].">".$ds[name]."</a><br />";
}

?>
<br />
<a href="/dreamedit/mod/personal/xls/xlsx.php" target="_blank">Выгрузить таблицу в формате Excel(.xlsx)</a><br />
<a href="/dreamedit/mod/personal/xls/xlsx_only_mails.php" target="_blank">Выгрузить таблицу(ФИО+почты через запятую) в формате Excel(.xlsx)</a><br />