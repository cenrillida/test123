<?

$pg=new Pages;

global $DB,$_CONFIG, $site_templater;
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>
<h1><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h1>
<?
echo $_TPL_REPLACMENT["CONTENT"];

    $feed0=$DB->select(
                "SELECT * FROM feedback WHERE id=".(int)$_REQUEST[id] ." ORDER BY date DESC"
                );

     echo "<table border='0' cellspacing='0' cellpadding='5' >";
     foreach($feed0 as $k=>$feed)
     {

//           echo "<tr  class=\"d".(($k+1) & 1)."\">";
             echo "<tr><td><b>Отправитель:</b></td><td>".$feed['fio']."</td></tr>";
             echo "<tr><td><b>Дата:</b></td><td>".
                  substr($feed['date'],8,2)."/".substr($feed['date'],5,2)."/".substr($feed['date'],0,4).
                  "</td></tr>";
//             echo "<tr><td><b>Страна:</b></td><td>".$feed['country']."</td></tr>";
//             echo "<tr><td><b>Регион:</b></td><td>".$feed[region]."</td></tr>";
             echo "<tr><td><b>Вид деятельности:</b></td><td>".$feed[activity]."</td><tr>";
//             echo "<tr><td><b>Область научных интересов:</b></td><td>".$feed[scientific_interests]."</td></tr>";
//             echo "</tr><tr  class=\"d".(($k+1) & 1)."\">";
             echo "<tr><td><b>Контактная информация:</b></td><td>"."<a href='mailto:".$feed[email]."'>".trim($feed[email])."</a> ".trim($feed[telephone])."</td></tr>";
             echo "</table>";
             echo "<br/><br />";
             echo "<table>";
              echo "<td>".$feed[text]."</td>";
              echo "</table>";
      }
      echo "<br /><br /><a title='назад' href='/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."'>к списку сообщений обратной связи</a>";


$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>