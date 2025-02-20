<?
global $page_content;
// Последний номер журнала
$headers = new Headers();
$mz=new Magazine();

//print_r($_SESSION);
$rowsm = $mz->getLastMagazineNumber($_SESSION[jour_id]);
$rowsy=$mz->getMagazineAllYear($_SESSION[jour_id]);
$rows=$mz->getLastMagazineNumberRub($_SESSION[jour_id],$rowsm[0][page_name],$rowsm[0][year]);

if ($_SESSION[lang]!='/en')
	$rowsth=$mz->getMagazineNumber($rowsm[0][page_id]);
else
	$rowsth=$mz->getMagazineNumberEn($rowsm[0][page_id]);
$rowsth=$mz->appendContentArticle($rowsth);

//print_r($rowsm);
if ($_SESSION[lang]=='/en')
{
  $txtn='No ';
  $txtend='View This Issue'; 
  
}
else
{
  $txtn="№ ";
  $txtend='Открыть этот выпуск';
}
  if($_SESSION[jour_url]=='god_planety' || $_SESSION[jour_url]=='WER')
	{
		$txtn="";
		if ($_SESSION[lang]=='/en')
			$txtn.$rowsm[0][page_name]='Yearbook';
	}
	//print_r($rowsm);
$temp_symbol=',';
if($_SESSION[jour_url]=='REB-2')
{
	$page_archive=$rowsm[0][page_summary];
	$rowsm[0][page_summary]='886';
	$temp_symbol='';
	$rows[0][page_name]=='';
	$txt.="<table><tr><td valign=top>".$rowsm[0][logo]."</td><td>";
	
	$temp_text_journals=$rowsth[$rowsm[0][page_id]][content][FULL_TEXT];
	
	$pos_last = strripos($temp_text_journals, "month_");
	$pos_last_a = strripos(substr($temp_text_journals,0,$pos_last),"<a href");
	$link_last_jour = substr($temp_text_journals,$pos_last_a+9);
	$link_last_jour = substr($link_last_jour,0,strpos($link_last_jour,'"'));
	//var_dump($link_last_jour);
	//var_dump($rowsth[$rowsm[0][page_id]][content][FULL_TEXT]);
	
	if ($_SESSION[lang]!='/en')
	{
		if ($pos_last === false) 
		{
			$txt.="<li>- Текущий выпуск "."<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".
			$rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$txtn.$rowsm[0][page_name].$temp_symbol." ".$rowsm[0][year]."</a>"."</li>";
		} 
		else 
		{
			$temp_string_journals=substr($temp_text_journals,$pos_last);
			$temp_string_journals=substr(stristr($temp_string_journals,">"),1);
			$temp_string_journals=substr($temp_string_journals,0,strpos($temp_string_journals,"<"));
			$txt.="<li>- Текущий номер "."<a href=".$link_last_jour.">(".$temp_string_journals.")</a>"."</li>";
		}
		$txt.="<li>- <a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".
		$page_archive.">Архив номеров</a></li>";
		$txt.="<li>- <a href=/index.php?page_id=1068>Полные тексты всех номеров РЭБ</a></li>";
	}
	else
	{
		$txt.="<li>- Current issue "."<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".
		$rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$rowsm[0][year].$temp_symbol." ".$txtn.$rowsm[0][page_name]."</a>"."</li>";
		$txt.="<li>- <a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".
		$page_archive.">Archive</a></li>";

	}
}
else
{
	if ($_SESSION[lang]!='/en')
	$txt="<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".
	$rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$txtn.$rowsm[0][page_name].$temp_symbol." ".$rowsm[0][year]."</a>".
	"<br /><table><tr><td valign=top>".$rowsm[0][logo]."</td><td>";
	else
	$txt="<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".
	$rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$rowsm[0][year].$temp_symbol." ".$txtn.$rowsm[0][page_name]."</a>".
	"<br /><table><tr><td valign=top>".$rowsm[0][logo]."</td><td>";


if($_SESSION[jour_url]!='meimo') //&& $_SESSION[jour_url]!='REB-2')
{
foreach($rows as $row)
{
   if ($_SESSION[lang]!='/en' || empty($row[name_en]))
		$txt.="<li>- ".$row[page_name]."</li>";
	else	
		$txt.="<li>- ".$row[name_en]."</li>";
	
}
}
else
{
	if ($_SESSION[lang]!='/en')
		$txt.='<div style="font-style: italic;">'.substr(substr($rowsth[$rowsm[0][page_id]][content][SUBJECT],0,-4),3).'</div>';
	else
		$txt.='<div style="font-style: italic;">'.substr(substr($rowsth[$rowsm[0][page_id]][content][SUBJECT_EN],0,-4),3).'</div>';
}
}
$txt.="</td></tr></table>";

$elements=Array();
$elements[0][text]=$txt;
$elements[0][text_en]=$txt;
$elements[0][ctype]='Текст';
$elements[0][cclass]='Красный'; 
if($_SESSION[jour_url]!='god_planety')
{
	if ($_SESSION[lang]!='/en') 
		{
			$elements[0]['titlenew']='Текущий номер';
			if($_SESSION['jour_url']=='REB-2')
				$elements[0]['titlenew']='В журнале';
		}
	else
		{ 
			$elements[0]['titlenew_en']='Current Issue';
			if($_SESSION['jour_url']=='REB-2')
				$elements[0]['titlenew_en']='In journal';
		}
}
else
{
if ($_SESSION[lang]!='/en') $elements[0]['titlenew']='Текущий выпуск'; else $elements[0]['titlenew_en']='Current Issue';
}
$elements[0]['sort']='0001';
$elements[0][showtitle]='1';
$i=0;
//print_r($elements);
//if(!empty($rows))
//{
echo '<div class="box">';
	foreach($elements as $k => $v)
	{

	$tpl = new Templater();
		$tpl->setValues($v);
			 $tpl->appendValues(array("TITLENEW" => $v["titlenew"]));

    	$tpl->appendValues(array("EQUALNUMBER" => $i));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	}

//}

if ($rowsm[0][page_template]!='magazine')
{
	if($_SESSION[jour_url]!='REB-2')
	{
if ($_SESSION[lang]!='/en')
echo "<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".
$rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$txtend." (".$txtn.$rowsm[0][page_name].$temp_symbol." ".$rowsm[0][year].")</a>";
else
echo "<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".
$rowsm[0][page_summary]."&jid=".$rowsm[0][page_id].">".$txtend." (".$rowsm[0][year].$temp_symbol." ".$txtn.$rowsm[0][page_name].")</a>";
}
echo '</div>';echo '</div><div class="cleaner"> </div><div id="sidebar">';
/////////////
 $years="";
	 foreach($rowsy as $row)
	 {
	     $years.=" <a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.
		 "&year=".$row[year].
		 ">".$row[year]."</a> |";
	 }
	 $tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "Красный"));
	$tpl->appendValues(array("CTYPE" => "Текст"));
     if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "По годам"));//$pagem[0][jj]));
	 else
	    $tpl->appendValues(array("TITLE_EN" => "Years"));
	 $tpl->appendValues(array("TEXT" => $years));
	 $tpl->appendValues(array("TEXT_EN" => $years));
//	echo '<div class="box">';
//			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
//	echo '</div>';
}
	
?>