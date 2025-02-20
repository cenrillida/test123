<?

if($_GET['action'] == 'add') include 'action.php';
 else
if($_GET['action'] == 'save') include 'save.php';
 else
if($_GET['show'] == 'ok') include 'show.php';
 else
if($_GET['act'] == 'search') include 'search.php';
 else
if($_GET['act'] == 'del') include 'delete.php';
 else
if($_GET['act'] == 'edit') {include 'edit.php';}
 else
if($_GET['act'] == 'set') include 'set.php';
 else
if($_GET['act'] == 'delask') include 'delask.php';
 //else
//if($_GET['shw']) include 'delask.php';
//echo "<br />______________GET_________";print_r($_GET);
//$_POST[fname]='bib3.bib';print_r($_POST);
if($_GET['act'] == 'load') echo "Загрузка";

echo "<br />";

//$zt=new Dispatcher();

  include_once substr($_CONFIG["global"]["paths"]['admin_path'],0,-10)."classes/guid/guid.php";
print_r($_FILES);
if ($_FILES[fname][tmp_name]<> "" && $_REQUEST[mode]<>'journal')
{

  $guid=new guid();
  if (empty($filenames)) $filenames=str_replace("-","_",$guid->tostring()).".bib";

  $uploaddir = $_CONFIG['global']['paths'][admin_path]."zotero/";

  move_uploaded_file($_FILES['fname']['tmp_name'], $uploaddir.$filenames) ;


}
if ($_REQUEST[mode]<>'journal')
	echo "<a href=/dreamedit/index.php?mod=zotero&action=edit&mode=journal&file=".$filenames.">Сохранить как номер журнала</a>";

if (empty($filenames)) $filenames=$_REQUEST["file"];
$a=setDB($filenames);

$bib0=$a->bibdb;
$i=0;

if ($_REQUEST[mode]<>'journal')
{
foreach($bib0 as $k=>$bib)
{
	echo "<br />"."<input type=checkbox name='bib[]' id='bib".$i."' >&nbsp;&nbsp;&nbsp;".
	"<a href=/dreamedit/index.php?mod=zotero&act=edit&id=".$k."&file=".$filenames.">".
	str_replace('"','\"',convutf8($bib->fields[title]))."</a></input>";
}

}

//Сохранить номер журнала
if ($_REQUEST[mode]=='journal')
{
$i=0;
foreach($bib0 as $k=>$bib)
{
//echo "journal=".convutf8($bib->fields[journal]);
  $jid0=$DB->select("SELECT page_id,journal FROM adm_article WHERE j_name='".convutf8($bib->fields[journal])."' AND page_template='0'");
  echo  "SELECT page_id,journal FROM adm_article WHERE j_name='%".convutf8($bib->fields[journal])."%' AND page_template='0'";
  $jid=$jid0[0][page_id];

//print_r($bib0);
  $number=$DB->select("SELECT page_id,journal FROM adm_article
    WHERE page_parent=".$jid.
          " AND page_template='jnumber' ".
          " AND page_name='".$bib->fields[number]."' ".
          " AND year=".$bib->fields[year]);
  $jname=convutf8($bib->fields[journal]);
break;
}


  if (count($number)>0) echo "Номер журнала уже введен. Воспользуйтесь режимом коррекции";
  else
  {
      $DB->query("INSERT INTO adm_article (page_id,page_template,page_name,journal,year,j_name,date,page_status,page_parent)
           VALUES(0,'jnumber','".$bib->fields[number]."',".
           "'".$jid0[0][journal]."',".
           "'".$bib->fields[year]."', ".
           "'".convutf8($bib->fields[journal])."',".
           "'".date('Ymd')."',".
           "'1',".
           $jid.")");
      $result = $DB->select("SELECT LAST_INSERT_ID() AS tid FROM adm_article LIMIT 1");
//print_r($result);
      $tid=$result[0][tid];
		foreach($bib0 as $k=>$bib)
		{
// Разобраться с авторами
                $avt00=convutf8($bib->fields[author]);
				if (empty($avt00)) $sauthors="редакция";
				else
				{
				$avt0=explode(" and ",$avt00);
				$sauthors="";
                foreach($avt0 as $avt)
				{
					$aa=explode(" ",str_replace(",","",$avt));
				    $pers=$DB->select("SELECT id FROM persons WHERE
				                      surname='".trim($aa[0])."' ".
				                     " AND name ='".trim($aa[1])."' ".
				                     " AND fname ='".trim($aa[2])."' ");
				    if (count($pers)==0)
				    {
				       $otd=$DB->select("SELECT page_id FROM adm_pages WHERE page_name='".$jname."' ".
				                      " AND page_template='podr'"
				             );
				       if (count($otd)==0) $otdel=236; else $otdel=$otd[0][page_id];
				       $DB->query("INSERT INTO persons
				                  (id,surname,name,fname,otdel,jnumber)
				                  VALUES(
				                  0,".
				                  "'".$aa[0]."',"."'".$aa[1]."',"."'".$aa[2]."',".
				                  $otdel.
				                  ",'".$jname."|".$bib->fields[number]."|".$bib->fields[year]."'".
				                  ")");
				       $pid = $DB->select("SELECT LAST_INSERT_ID() AS pid FROM persons LIMIT 1");
				       $sauthors.=$pid[0][pid]."<br>";
				    }
				    else
				       $sauthors.=$pers[0][id]."<br>";
				}
               }
  			 $DB->query("INSERT INTO adm_article
                      (page_id,page_parent,page_name,name,people,page_template,journal,j_name,year,number,
                       annots,annots_en,date,keyword,keyword_en,page_status,
                       pages,jid,atype)
                       VALUES (
                       0,".
                       "'".$tid."',".
                       "'".str_replace("'","^",convutf8($bib->fields['title']))."',".
                       "'".str_replace("'","^",convutf8($bib->fields['title']))."',".
                       "'".$sauthors."',".
                       "'jarticle',".
                       "'".$jid0[0][journal]."',".
                       "'".$jname."',".
                       "'".$bib->fields[year]."',".
                       "'".$bib->fields[number]."',".
                       "'".str_replace("'","^",convutf8($bib->fields['abstract']))."',".
                       "'".str_replace("'","^",convutf8($bib->fields['abstract']))."',".
                       "'".date('Ymd')."',".
                       "'".str_replace("'","^",convutf8($bib->fields['keywords']))."',".
                       "'".str_replace("'","^",convutf8($bib->fields['keywords']))."',".
                       "'1',".
                       "'".convutf8($bib->fields['pages'])."',".
                       "'".$tid."',".
                       "'RAR')");

		}

  }
  echo "<br /> Номер журнала ".$jname." ".$bib->fields[number]." ".$bib->fields[year]." успешно добавлен" ;
  echo "<br />Необходимо перейти в модуль работы со статьям и проверить порядок статей, добавить рубрики";
}
//////
if ((!$_GET['action'])&&(!$_GET['show'])&&(!$_GET['act'])) {
echo "<br />Имеются следующие записи :<br><br>";
$wow = array ();
global $DB,$_CONFIG;


//for($i=0; $i<count($wow); $i++)
 //for ($k=0; $k<strlen($wow[$i][10]); $k++)
  //echo 1;

}
function convutf8($text)
{
$text = str_replace(chr(208).chr(160),chr(208),$text); # Р
$text = str_replace(chr(208).chr(144),chr(192),$text); # А
$text = str_replace(chr(208).chr(145),chr(193),$text); # Б
$text = str_replace(chr(208).chr(146),chr(194),$text); # В
$text = str_replace(chr(208).chr(147),chr(195),$text); # Г
$text = str_replace(chr(208).chr(148),chr(196),$text); # Д
$text = str_replace(chr(208).chr(149),chr(197),$text); # Е
$text = str_replace(chr(208).chr(129),chr(168),$text); # Ё
$text = str_replace(chr(208).chr(150),chr(198),$text); # Ж
$text = str_replace(chr(208).chr(151),chr(199),$text); # З
$text = str_replace(chr(208).chr(152),chr(200),$text); # И
$text = str_replace(chr(208).chr(153),chr(201),$text); # Й
$text = str_replace(chr(208).chr(154),chr(202),$text); # К
$text = str_replace(chr(208).chr(155),chr(203),$text); # Л
$text = str_replace(chr(208).chr(156),chr(204),$text); # М
$text = str_replace(chr(208).chr(157),chr(205),$text); # Н
$text = str_replace(chr(208).chr(158),chr(206),$text); # О
$text = str_replace(chr(208).chr(159),chr(207),$text); # П
$text = str_replace(chr(208).chr(161),chr(209),$text); # С
$text = str_replace(chr(208).chr(162),chr(210),$text); # Т
$text = str_replace(chr(208).chr(163),chr(211),$text); # У
$text = str_replace(chr(208).chr(164),chr(212),$text); # Ф
$text = str_replace(chr(208).chr(165),chr(213),$text); # Х
$text = str_replace(chr(208).chr(166),chr(214),$text); # Ц
$text = str_replace(chr(208).chr(167),chr(215),$text); # Ч
$text = str_replace(chr(208).chr(168),chr(216),$text); # Ш
$text = str_replace(chr(208).chr(169),chr(217),$text); # Щ
$text = str_replace(chr(208).chr(170),chr(218),$text); # Ъ
$text = str_replace(chr(208).chr(171),chr(219),$text); # Ы
$text = str_replace(chr(208).chr(172),chr(220),$text); # Ь
$text = str_replace(chr(208).chr(173),chr(221),$text); # Э
$text = str_replace(chr(208).chr(174),chr(222),$text); # Ю
$text = str_replace(chr(208).chr(175),chr(223),$text); # Я
$text = str_replace(chr(208).chr(176),chr(224),$text); # а
$text = str_replace(chr(208).chr(177),chr(225),$text); # б
$text = str_replace(chr(208).chr(178),chr(226),$text); # в
$text = str_replace(chr(208).chr(179),chr(227),$text); # г
$text = str_replace(chr(208).chr(180),chr(228),$text); # д
$text = str_replace(chr(208).chr(181),chr(229),$text); # е
$text = str_replace(chr(209).chr(145),chr(184),$text); # ё
$text = str_replace(chr(208).chr(182),chr(230),$text); # ж
$text = str_replace(chr(208).chr(183),chr(231),$text); # з
$text = str_replace(chr(208).chr(184),chr(232),$text); # и
$text = str_replace(chr(208).chr(185),chr(233),$text); # й
$text = str_replace(chr(208).chr(186),chr(234),$text); # к
$text = str_replace(chr(208).chr(187),chr(235),$text); # л
$text = str_replace(chr(208).chr(188),chr(236),$text); # м
$text = str_replace(chr(208).chr(189),chr(237),$text); # н
$text = str_replace(chr(208).chr(190),chr(238),$text); # о
$text = str_replace(chr(208).chr(191),chr(239),$text); # п
$text = str_replace(chr(209).chr(128),chr(240),$text); # р
$text = str_replace(chr(209).chr(129),chr(241),$text); # с
$text = str_replace(chr(209).chr(130),chr(242),$text); # т
$text = str_replace(chr(209).chr(131),chr(243),$text); # у
$text = str_replace(chr(209).chr(132),chr(244),$text); # ф
$text = str_replace(chr(209).chr(133),chr(245),$text); # х
$text = str_replace(chr(209).chr(134),chr(246),$text); # ц
$text = str_replace(chr(209).chr(135),chr(247),$text); # ч
$text = str_replace(chr(209).chr(136),chr(248),$text); # ш
$text = str_replace(chr(209).chr(137),chr(249),$text); # щ
$text = str_replace(chr(209).chr(138),chr(250),$text); # ъ
$text = str_replace(chr(209).chr(139),chr(251),$text); # ы
$text = str_replace(chr(209).chr(140),chr(252),$text); # ь
$text = str_replace(chr(209).chr(141),chr(253),$text); # э
$text = str_replace(chr(209).chr(142),chr(254),$text); # ю
$text = str_replace(chr(209).chr(143),chr(255),$text); # я
$text = str_replace(chr(194).chr(171),chr(171),$text); # «
$text = str_replace(chr(194).chr(187),chr(187),$text); # »
$text = str_replace(chr(226).chr(128).chr(148),chr(151),$text); # —
return $text;
}

?>
