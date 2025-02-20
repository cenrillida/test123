<body style="font-size:14px;width:600px;">
<?
global $DB,$_CONFIG, $site_templater;
$ps = new Persons();
$rows=$ps->getPersonsById($_REQUEST[id]);
//print_r($rows);
//$site_templater->appendValues(array("DESCRIPTION" => "Сотрудник ИНИОН РАН ".strip_tags($rows[0][fio])));
//$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

$pg = new Pages();

$id = addslashes($_REQUEST['id']);
global $_CONFIG;
$ps = new Persons();

//Проверить наличие фотографии
$row=$ps->getPersonsByIdFull($id);
//print_r($row);
$row2=$DB->select("SELECT * FROM persona_user WHERE id_persona=".(int)$_REQUEST[id]);


echo "<h2> ".$row[0][fio]."</h2>";
echo "".$_TPL_REPLACMENT[CONTENT];
echo "<hr /><span style='color:red;font-size:18px;'>Опубликовано на сайте:</span><br /><br />";
//echo $row[0][ForSite]."<br /><br />";

if (!empty($row[0][regalii0]) || !empty($row[0][regalii0]))
	echo $row[0][regalii0]."<br />".$row[0][regalii];
echo $row[0][dolj]."<br />".$row[0][otdel];
echo "<br />";
  if (!empty($row[0][contact]) && $row[0][contact]!='<a href="mailto:"></a>')
	  echo "<br /><b>Контактная информация</b>";
   echo "<br>".$row[0][contact];
   echo "<br />";



echo $row[0][about];




echo "<br />";
echo "<hr /><span style='color:red;font-size:18px;'>Новые сведения:</span><br /><br />";
echo "<br /><br /><b>ФИО на английском: </b>".$row2[0][fio_en];
echo "<br /><br /><b>Контактная информация: </b>".$row2[0][email]." | ".$row2[tel];
echo "<br /><br /><b>Количество публикаций: </b>".$row2[0][publs];
echo "<br /><br /><b>Диссертации: </b>".$row2[0][disser];
echo "<br /><br /><b>Область научных интересов: </b>".$row2[0][наука];
echo "<br /><br /><b>О себе: </b>".$row2[0][about]."<br />".$row2[0][about_en];
//$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>



