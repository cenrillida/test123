<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $( function() {
        $( ".publ_search" ).autocomplete({
            source: function (request, response) {
                // request.term = request.term.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
                //     return '&#'+i.charCodeAt(0)+';';
                // });
                <? // https://jrgraphix.net/research/unicode_blocks.php?>
                request.term = request.term.replace(/[\u00A0-\u024F<>\&]/gim, function(i) {
                    return '&#'+i.charCodeAt(0)+';';
                });
                $.ajax({
                    type: "GET",
                    url:"ajax_publs.php",
                    data: request,
                    success: response,
                    dataType: 'json'
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                event.preventDefault();
                window.open("index.php?mod=public&act=edit&id="+ui.item.id,'_blank');
            },
            focus: function (event, ui) {
                event.preventDefault();
            }
        });
    } );
</script>

Быстрый поиск по названию
<br>

<div class="ui-widget">
    <input id="publ_search_all" class="publ_search">
</div>
<div id="search_error" style="display: none; color: red">В поле поиска ничего не введено</div>
<hr>

<form method=post action=index.php?mod=public&act=search>
 <font size=2>Название публикации</font><br>
 <input type=text name=s-name>
 <br>
 <font size=2>Автор</font><br>
 <input type=text name=s-avtor>
 <br>
 <font size=2>Год выпуска</font><br>

 <input type=text name=syear>
 <br>
 <font size=2>Выводить на главную</font><br>
 <input type="checkbox" name="smain" value="1" >
 <br><br>
 <input type=submit value='Искать'>
</form>


<br><br>
<a href=index.php?mod=public&shw=50>Последние 50</a>
<br><br>
<?
$num = 0;
global $DB,$_CONFIG;
/*
if (isset($_POST[s-name])) {


  mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
  mysql_select_db($_CONFIG['global']['db_connect']['db_name']);


  $result = mysql_query("select * from publ");

  mysql_close();


//  while($row = mysql_fetch_array($result)) $num++;
}
*/
// Поиск по автору

if ($_POST["s-avtor"]!="") {

    $fio=explode(" ",$_POST["s-avtor"]);
    $fio[0]=strtolower($fio[0]);
    $search_fio= " avtor like '%".$fio[0]."%' ";

    $avt = $DB->select(
         "SELECT id,surname FROM persons WHERE surname like '%".$fio[0]."%' ORDER BY name"
            );
    echo "Для авторов:";
    foreach($avt as $k => $v)
    {
    echo "<br />&nbsp;&nbsp;&nbsp;".$v[surname];
     $search_fio.= " or avtor like '%<br>".$v[id]."<br>%' or avtor like '".$v[id]."<br>%' ";
    }
//  $result = mysql_query("select * from publ");

  $_POST[search_fio]=$search_fio;


//    $result = $DB->select(
//        "SELECT * FROM publ WHERE ".$search_fio." ORDER BY name"
//	);

}
// По авторам
// Вывести всего
$vsego=$DB->select (
            "SELECT count(*) FROM publ WHERE name <> ''"
	    );

?>
<br /><br />
<a href=index.php?mod=public&shw=all>Все [<? echo $vsego[0]["count(*)"]?>]</a>
<br /><br />
<a href=index.php?mod=public&act=set>Список публикаций</a>

