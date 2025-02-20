<?
global $DB,$page_content;

$headers = new Headers();

$elements = $headers->getHeaderElements("Главная - Правая колонка");
$template=$DB->select("SELECT page_template FROM adm_pages WHERE page_id=".$_REQUEST[page_id]);
$rowsm=$mz->getMagazineAllYear($_SESSION[jour_id]);

if (substr($template[0][page_template],0,8)!='magazine' )
{
//print_r($elements);

if(!empty($elements))
{
	$num = 1;
	foreach($elements as $k => $v)
	{
		
		$tpl = new Templater();
		$tpl->setValues($v);
  		if($v["ctype"] == "Фильтр")
			$tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));

	echo '<div class="box">';
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
		
	}
	
	echo '<div class="cleaner">&nbsp;</div>';
}
}
else
{
	  $pagem=$DB->select("SELECT pp.*,p.page_name AS jj,p.page_name_en AS jj_en FROM adm_pages_content AS pp
	INNER JOIN adm_pages AS p ON p.page_id=pp.page_id
	WHERE p.page_template='magazine' AND p.page_id IN
	(SELECT page_id FROM adm_pages_content WHERE cv_name='ITYPE_JOUR' AND cv_text='".$_SESSION[jour_id]."')");
   $citas=$DB->select("SELECT cv_text AS citas FROM adm_magazine_content AS c
	               INNER JOIN adm_magazine AS m ON m.page_id=c.page_id AND 
                   m.page_parent=".$_SESSION[jour_id].
				   " WHERE cv_name='citas'");
	$block=$DB->select("SELECT c.cv_text AS block, c2.cv_text AS blocktxt,cen.cv_text AS blocken, c2en.cv_text AS blocktxt_en 
					FROM adm_magazine_content AS c
	               INNER JOIN adm_magazine AS m ON m.page_id=c.page_id AND 
                   m.page_parent=".$_SESSION[jour_id].
				  " INNER JOIN adm_magazine_content AS c2 ON c2.page_id=c.page_id AND c2.cv_name='blocktxt' ".
				   " LEFT OUTER JOIN adm_magazine_content AS cen ON cen.page_id=c.page_id AND cen.cv_name='block_en' ".
				   " LEFT OUTER JOIN adm_magazine_content AS c2en ON c2en.page_id=c.page_id AND c2en.cv_name='blocktxt_en' ".
				   " WHERE c.cv_name='block'");			   
   foreach($pagem as $p)
   {
      if ($p[cv_name]=='ARCHIVE_ID') $archiveid=$p[cv_text];
	  if ($p[cv_name]=='RUBRICS_ID') $rubricid=$p[cv_text];	 
	  if ($p[cv_name]=='AUTHORS_ID') $authorid=$p[cv_text];	
	  if ($p[cv_name]=='YEARS_ID')   $yearsid=$p[cv_text];
	  if ($p[cv_name]=='AUTORS_YEARS_ID')  $ayearsid=$p[cv_text];	  
   
   }
 //print_r($pagem);  

   if($_SESSION[jour_url]=='REB-2')
   {
   	$yearsid='884';
   }
	 $years="";
	    if($_SESSION[jour_url]=="REBQUE")
	{
   $rows_rebque=$mz->getMagazineAllPublic();
   foreach($rows_rebque as $row)
	 {
		$years.=" <a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=1025&jid=".$row[jid].
		 ">".$row[year]."</a> |";
	 }
	}
	else
	if($_SESSION[jour_url]=="REB-2")
	{
   $rows_rebque=$mz->getMagazineAllPublic();
   foreach($rows_rebque as $row)
	 {
		$years.=" <a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=886&jid=".$row[jid].
		 ">".$row[year]."</a> |";
	 }
	}
	else
	{
	 foreach($rowsm as $row)
	 {
	     $years.=" <a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.
		 "&year=".$row[year].
		 ">".$row[year]."</a> |";

	 }
	 }
	 if (count($block)>0)
	{	

	$tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "Серый"));
	$tpl->appendValues(array("CTYPE" => "Текст"));
     if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => $block[0][block]));//$pagem[0][jj]));
	 else
	    $tpl->appendValues(array("TITLE_EN" => $block[0][blocken]));
	 $tpl->appendValues(array("TEXT" => $block[0][blocktxt]));
	  $tpl->appendValues(array("TEXT_EN" => $block[0][blocktxt_en]));
//	 $tpl->appendValues(array("TEXT_EN" => $years));
    echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
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
	 
	if($_SESSION[jour_url]!='god_planety')
	{
	echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
	}
   //////////
   $tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "Зеленый"));
	$tpl->appendValues(array("CTYPE" => "Текст"));

	if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "<a href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=959>Отправить статью</a>"));//$pagem[0][jj]));
	 else
	    $tpl->appendValues(array("TITLE_EN" => "<a href=/en/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=959>Send article</a>"));
	 $tpl->appendValues(array("TEXT" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=959>Форма для отправки статьи</a>"));
	 $tpl->appendValues(array("TEXT_EN" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/en/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=959>Send article</a>"));
    echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
   
   
   
  if($_SESSION[jour_url]!='REB-2')
   if (count($pagem)>0)
   {
    $tpl = new Templater();
	$tpl->appendValues(array("CCLASS" => "Голубой 1"));
	$tpl->appendValues(array("CTYPE" => "Текст"));
	if($_SESSION[jour_url]!='god_planety')
	{
	if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "В журнале"));//$pagem[0][jj]));
	else
	    $tpl->appendValues(array("TITLE_EN" => "In Journal"));
	}
	else
	{
	if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "В ежегоднике"));//$pagem[0][jj]));
	else
	    $tpl->appendValues(array("TITLE_EN" => "In Yearbook"));
	}
	if($_SESSION[jour_url]!='god_planety')
	{
	if($_SESSION[jour_url]!='REBQUE')
	{
	if ($_SESSION[lang]!='/en')
	$tpl->appendValues(array("TEXT" => "<b><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Архив номеров</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">Индекс рубрик</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">Индекс авторов</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.">Статьи за год</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">Авторы за год</a><br />"
	));
	
	else
	$tpl->appendValues(array("TEXT_EN" => "<b><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj_en],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Archive</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">Subjects</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">Authors</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.">Articles for the year</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">Authors for the year</a><br />"
	));
	}
	else
	{
	if ($_SESSION[lang]!='/en')
	$tpl->appendValues(array("TEXT" => "<b><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Архив номеров</a><br />"
	));
	
	else
	$tpl->appendValues(array("TEXT_EN" => "<b><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj_en],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Archive</a><br />"
	));
	}
	}
	else
	{
	if ($_SESSION[lang]!='/en')
	$tpl->appendValues(array("TEXT" => "<b><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Архив выпусков</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">Индекс рубрик</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">Индекс авторов</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">Авторы за год</a><br />"
	));
	
	else
	$tpl->appendValues(array("TEXT_EN" => "<b><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj_en],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Archive</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">Rubrisc</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">Authors</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">Authors for the year</a><br />"
	));
	}
	
//	print_r($citas);echo $_SESSION[jour_id];			   
	echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
//print_r($citas);	
	
	
	
if (count($citas)>0)
	{	

	$tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "Красный"));
	$tpl->appendValues(array("CTYPE" => "Текст"));
     if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "Индексируется"));//$pagem[0][jj]));
	 else
	    $tpl->appendValues(array("TITLE_EN" => "Indexed"));
	 $tpl->appendValues(array("TEXT" => $citas[0][citas]));
	  $tpl->appendValues(array("TEXT_EN" => $citas[0][citas]));
//	 $tpl->appendValues(array("TEXT_EN" => $years));
    echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
	}	
}

//print_r($_SESSION);
}

?>