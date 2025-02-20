
<form method=post action=index.php?mod=zotero&act=search>
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
<form enctype="multipart/form-data" method=post action=index.php?mod=XML_publ&act=load>
 <font size=2>Имя файла</font><br>
 <input type="file" name="fname"></input>
 <br>

<input type=submit value="Загрузить"></input>
</form>
<!--
<br><br>
<a href=index.php?mod=zotero&shw=50>Последние 50</a>
<br><br>
/-->
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
//$vsego=$DB->select (
//            "SELECT count(*) FROM publ WHERE name <> ''"
//	    );

?>
<!--
<br /><br />
<a href=index.php?mod=zotero&shw=all>Все [<? echo $vsego[0]["count(*)"]?>]</a>
-->
