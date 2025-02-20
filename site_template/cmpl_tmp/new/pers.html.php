<?
global $DB,$_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>

<br />
<div class="pers-navigation mb-2">
<?php

  if(!$_GET['type'] && $_SESSION[lang]!='/en') {
        for ($i = ord("А"); $i <= ord("Я"); $i++)
	    if ((chr($i) != 'Ъ') && (chr($i) != 'Ь') && (chr($i) != 'Ы'))
         echo "<a style='text-decoration: none; font-size: 22px;' href=#".$i."><b>".chr($i)." </b></a>&nbsp";
         echo "<a style='text-decoration: none; font-size: 22px;' href=/index.php?page_id=".$_REQUEST[page_id]."><b>ВСЕ</b></a>";
  }
  if(!$_GET['type'] && $_SESSION[lang]=='/en') {
        for ($i = ord("A"); $i <= ord("Z"); $i++)
	    if ((chr($i) != 'Ъ') && (chr($i) != 'Ь') && (chr($i) != 'Ы'))
         echo "<a style='text-decoration: none; font-size: 22px;' href=#".$i."><b>".chr($i)." </b></a>&nbsp";
         echo "<a style='text-decoration: none; font-size: 2px;' href=/en/index.php?page_id=".$_REQUEST[page_id]."><b>All</b></a>";
  }
  ?>
</div>
    <?php
///////////////////////////////////////////////////////////////////////////////////////////////////////



    if(!$_REQUEST['smbl'])
    {
    if ($_SESSION[lang]!='/en')
	{
	$row0 = $DB->select(
	 "SELECT persons.id AS id, CONCAT(persons.surname, ' ',  persons.name,  ' ', persons.fname) AS fullname,
		 CONCAT(persons.surname, ' ',  substring(persons.name,1,1),  '. ', substring(persons.fname,1,1),'. ') AS shortname,
	       IF(podr.page_status<>0,CONCAT('<br />','<a href=/index.php?page_id=',persons.otdel,'>',podr.page_name,'</a>'),'') AS otdel,
	       persons.otdel AS otdel_id,
	       CONCAT(tel1,' ', mail1) AS contact,
	       CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',' , ',''),IF(s.icont_text<>'',s.icont_text,''),IF(s.icont_text<>'' AND z.icont_text<>'',' , ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii0,
	        d.icont_text AS dolj, ran AS chlen, s.icont_text AS us, z.icont_text AS uz, podr.page_status AS invis,persons.full FROM persons
	        LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=persons.dolj AND d.icont_var='text'
	        LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=persons.us AND s.icont_var='value'
	        LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=persons.uz AND z.icont_var='value'
	        LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=persons.ran AND r.icont_var='value'
		LEFT OUTER JOIN adm_pages AS podr ON podr.page_id=persons.otdel
		WHERE full<>1 AND (persons.otdel <> 'Партнеры' AND persons.otdel <> 'Умершие сотрудники' AND persons.otdel <> 'Администрация' AND persons.otdel <> 'Умер' AND persons.otdel <> 'Уволен' AND persons.otdel<>'Прочие подразделения' 
		AND (podr.page_status<>'0' OR (podr.page_status='0' AND persons.picsmall<>''))) AND persons.dolj<>100 OR persons.otdel=0
		OR d.icont_text='Директор' OR d.icont_text='Ученый секретарь'  OR d.icont_text LIKE 'Заместитель дир%'
		ORDER BY persons.surname,persons.name,persons.fname");
    }	
	else
	{
		$row0 = $DB->select(
	 "SELECT persons.id AS id, Autor_en AS fullname,
		 Autor_en AS shortname, Name_EN AS a_name_en, LastName_EN AS a_lastname_en,
	       IF(podr.page_status<>0,CONCAT('','<a href=/en/index.php?page_id=',persons.otdel,'>',podr.page_name_en,'</a>'),'') AS otdel,
	       persons.otdel AS otdel_id,
	       CONCAT(tel1,' ', mail1) AS contact,
	       CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',' , ',''),IF(s.icont_text<>'',s.icont_text,''),IF(s.icont_text<>'' AND z.icont_text<>'',' , ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii0,
	        d.icont_text AS dolj, ran AS chlen, s.icont_text AS us, z.icont_text AS uz, podr.page_status AS invis,persons.full FROM persons
	        LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=persons.dolj AND d.icont_var='text_en'
	        LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=persons.us AND s.icont_var='value_en'
	        LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=persons.uz AND z.icont_var='value_en'
	        LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=persons.ran AND r.icont_var='value_en'
		LEFT OUTER JOIN adm_pages AS podr ON podr.page_id=persons.otdel
		WHERE Autor_en <> '' AND (persons.otdel <> 'Партнеры' AND persons.otdel <> 'Умершие сотрудники' AND persons.otdel <> 'Администрация' AND persons.otdel <> 'Умер' AND persons.otdel <> 'Уволен' AND persons.otdel<>'Прочие подразделения'
		AND (podr.page_status<>'0' OR (podr.page_status='0' AND persons.picsmall<>''))) AND persons.dolj<>100 OR persons.otdel=0 OR d.icont_text='Директор' OR d.icont_text='Ученый секретарь'  OR d.icont_text LIKE 'Заместитель дир%'
		ORDER BY Autor_en");
    }
	}
  $oldfirst='';

 //print_r($row0);


//  while($row = mysql_fetch_array($result)) {
    foreach($row0 as $k=>$row)
    {

      $c = -1;
//      $result2 = mysql_query("select invis from podr where name='".$row[9]."'");
//      while($row2 = mysql_fetch_array($result2)) {
//         if ($row2[0] == 'on') $c = 1;
//       }
	if($row[full]==0)
	{
       //$c = false;

        if(!$_GET['type']){
	    if($row[shortname][0] != $oldfirst)
	{
	$oldfirst=$row[shortname][0];
	echo "<h2><a name=".ord($oldfirst)."><b>".$oldfirst."</a></b></h2><br>";
    }}
  	else
    	if($row[9] != $oldfirst)
	    {
    	    $oldfirst=$row[9];
        	echo "<b>$oldfirst</b><br><br>";
	    }
//   $result2 = mysql_query("select invis from podr where name='".$menu1[$i]."'");

	if ($_SESSION[lang]=='/en')
	{
		if($row[a_lastname_en]!='' && $row[a_name_en]!='')
		{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h4><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&id=".$row[id].">".
			"".$row[a_name_en]." ".$row[a_lastname_en]."".
			'</a></h4>';
		}
		else
		{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h4><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&id=".$row[id].">".
			"".$row[shortname]."".
			'</a></h4>';
		}
	}
	else
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h4><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&id=".$row[id].">".
		"".$row[shortname]."".
		'</a></h4>';
	}
  echo '<blockquote>';
  if (!empty($row[regalii0]))  echo $row[regalii0]."<br />";
  if (!empty($row[ForSite])) echo ''.$row[ForSite]."<br />";
  if (!empty($row[dolj])) echo  $row[dolj];
  if ($_SESSION[lang]=='/en') echo "<br />";
  if (!empty($row[otdel])) echo $row[otdel];
 // trim(rtrim(ltrim(trim(str_replace('| | ', '|', $row[chlen].' | '.$row[us].' | '.$row[uz].' | '.$row[dolj])),"|"),"|")," |");

 // if ($row[invis]!='0') echo " | ".$row[otdel];
    echo "</blockquote>";
//    echo '<br><br>';
	}
 }

?>



<?=@$_TPL_REPLACMENT["CONTENT"]?>
<?
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
