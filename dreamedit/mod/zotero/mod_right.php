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
if($_GET['act'] == 'load') echo "��������";

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
	echo "<a href=/dreamedit/index.php?mod=zotero&action=edit&mode=journal&file=".$filenames.">��������� ��� ����� �������</a>";

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

//��������� ����� �������
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


  if (count($number)>0) echo "����� ������� ��� ������. �������������� ������� ���������";
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
// ����������� � ��������
                $avt00=convutf8($bib->fields[author]);
				if (empty($avt00)) $sauthors="��������";
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
  echo "<br /> ����� ������� ".$jname." ".$bib->fields[number]." ".$bib->fields[year]." ������� ��������" ;
  echo "<br />���������� ������� � ������ ������ �� ������� � ��������� ������� ������, �������� �������";
}
//////
if ((!$_GET['action'])&&(!$_GET['show'])&&(!$_GET['act'])) {
echo "<br />������� ��������� ������ :<br><br>";
$wow = array ();
global $DB,$_CONFIG;


//for($i=0; $i<count($wow); $i++)
 //for ($k=0; $k<strlen($wow[$i][10]); $k++)
  //echo 1;

}
function convutf8($text)
{
$text = str_replace(chr(208).chr(160),chr(208),$text); # �
$text = str_replace(chr(208).chr(144),chr(192),$text); # �
$text = str_replace(chr(208).chr(145),chr(193),$text); # �
$text = str_replace(chr(208).chr(146),chr(194),$text); # �
$text = str_replace(chr(208).chr(147),chr(195),$text); # �
$text = str_replace(chr(208).chr(148),chr(196),$text); # �
$text = str_replace(chr(208).chr(149),chr(197),$text); # �
$text = str_replace(chr(208).chr(129),chr(168),$text); # �
$text = str_replace(chr(208).chr(150),chr(198),$text); # �
$text = str_replace(chr(208).chr(151),chr(199),$text); # �
$text = str_replace(chr(208).chr(152),chr(200),$text); # �
$text = str_replace(chr(208).chr(153),chr(201),$text); # �
$text = str_replace(chr(208).chr(154),chr(202),$text); # �
$text = str_replace(chr(208).chr(155),chr(203),$text); # �
$text = str_replace(chr(208).chr(156),chr(204),$text); # �
$text = str_replace(chr(208).chr(157),chr(205),$text); # �
$text = str_replace(chr(208).chr(158),chr(206),$text); # �
$text = str_replace(chr(208).chr(159),chr(207),$text); # �
$text = str_replace(chr(208).chr(161),chr(209),$text); # �
$text = str_replace(chr(208).chr(162),chr(210),$text); # �
$text = str_replace(chr(208).chr(163),chr(211),$text); # �
$text = str_replace(chr(208).chr(164),chr(212),$text); # �
$text = str_replace(chr(208).chr(165),chr(213),$text); # �
$text = str_replace(chr(208).chr(166),chr(214),$text); # �
$text = str_replace(chr(208).chr(167),chr(215),$text); # �
$text = str_replace(chr(208).chr(168),chr(216),$text); # �
$text = str_replace(chr(208).chr(169),chr(217),$text); # �
$text = str_replace(chr(208).chr(170),chr(218),$text); # �
$text = str_replace(chr(208).chr(171),chr(219),$text); # �
$text = str_replace(chr(208).chr(172),chr(220),$text); # �
$text = str_replace(chr(208).chr(173),chr(221),$text); # �
$text = str_replace(chr(208).chr(174),chr(222),$text); # �
$text = str_replace(chr(208).chr(175),chr(223),$text); # �
$text = str_replace(chr(208).chr(176),chr(224),$text); # �
$text = str_replace(chr(208).chr(177),chr(225),$text); # �
$text = str_replace(chr(208).chr(178),chr(226),$text); # �
$text = str_replace(chr(208).chr(179),chr(227),$text); # �
$text = str_replace(chr(208).chr(180),chr(228),$text); # �
$text = str_replace(chr(208).chr(181),chr(229),$text); # �
$text = str_replace(chr(209).chr(145),chr(184),$text); # �
$text = str_replace(chr(208).chr(182),chr(230),$text); # �
$text = str_replace(chr(208).chr(183),chr(231),$text); # �
$text = str_replace(chr(208).chr(184),chr(232),$text); # �
$text = str_replace(chr(208).chr(185),chr(233),$text); # �
$text = str_replace(chr(208).chr(186),chr(234),$text); # �
$text = str_replace(chr(208).chr(187),chr(235),$text); # �
$text = str_replace(chr(208).chr(188),chr(236),$text); # �
$text = str_replace(chr(208).chr(189),chr(237),$text); # �
$text = str_replace(chr(208).chr(190),chr(238),$text); # �
$text = str_replace(chr(208).chr(191),chr(239),$text); # �
$text = str_replace(chr(209).chr(128),chr(240),$text); # �
$text = str_replace(chr(209).chr(129),chr(241),$text); # �
$text = str_replace(chr(209).chr(130),chr(242),$text); # �
$text = str_replace(chr(209).chr(131),chr(243),$text); # �
$text = str_replace(chr(209).chr(132),chr(244),$text); # �
$text = str_replace(chr(209).chr(133),chr(245),$text); # �
$text = str_replace(chr(209).chr(134),chr(246),$text); # �
$text = str_replace(chr(209).chr(135),chr(247),$text); # �
$text = str_replace(chr(209).chr(136),chr(248),$text); # �
$text = str_replace(chr(209).chr(137),chr(249),$text); # �
$text = str_replace(chr(209).chr(138),chr(250),$text); # �
$text = str_replace(chr(209).chr(139),chr(251),$text); # �
$text = str_replace(chr(209).chr(140),chr(252),$text); # �
$text = str_replace(chr(209).chr(141),chr(253),$text); # �
$text = str_replace(chr(209).chr(142),chr(254),$text); # �
$text = str_replace(chr(209).chr(143),chr(255),$text); # �
$text = str_replace(chr(194).chr(171),chr(171),$text); # �
$text = str_replace(chr(194).chr(187),chr(187),$text); # �
$text = str_replace(chr(226).chr(128).chr(148),chr(151),$text); # �
return $text;
}

?>
