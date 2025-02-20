<?
global $DB,$page_content;

function isint( $mixed )
{
    return ( preg_match( '/^\d*$/'  , $mixed) == 1 );
}

$mz=new Magazine();

$headers = new Headers();

//print_r($_SESSION);

if ($_SESSION[lang]=='/en') $suff="_en";else $suff="";

$rightBlockName = "Текст - Правая колонка";

$rightBlockPage = $DB->select("SELECT rightblock FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);

if(!empty($rightBlockPage[0][rightblock]))
	$rightBlockName = $rightBlockPage[0][rightblock];

$elements = $headers->getHeaderElements($rightBlockName);
$rows=$DB->select("SELECT cv_text FROM adm_pages_content WHERE page_id=".(int)$_REQUEST[page_id].
				  " AND (cv_text<>'' AND cv_text<>'<p>&nbsp;</p>') AND cv_name='reclama".$suff."'");
//print_r($page_content);
$template=$DB->select("SELECT page_template FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);
$rowsm=$mz->getMagazineAllYear($_SESSION[jour_id]);

if (substr($template[0][page_template],0,8)=='magazine' || $template[0][page_template]=='login_meimo')
{
  
 // $ppp=$pg->getMagazineAllPublic();
//  print_r($rows);
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
//   print_r($pagem);
   foreach($pagem as $p)
   {
      if ($p[cv_name]=='ARCHIVE_ID') $archiveid=$p[cv_text];
	  if ($p[cv_name]=='RUBRICS_ID') $rubricid=$p[cv_text];	 
	  if ($p[cv_name]=='AUTHORS_ID') $authorid=$p[cv_text];	
	  if ($p[cv_name]=='YEARS_ID')   $yearsid=$p[cv_text];
	  if ($p[cv_name]=='AUTORS_YEARS_ID')  $ayearsid=$p[cv_text];	  
   
   }

   if($_SESSION[jour_url]=='meimo') {
	 $tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "Зеленый"));
	$tpl->appendValues(array("CTYPE" => "Текст"));

	if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "<a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=959>Отправить статью</a>"));//$pagem[0][jj]));
	 else
	    $tpl->appendValues(array("TITLE_EN" => "<a href=/en/jour/".$_SESSION[jour_url]."/index.php?page_id=959>Send article</a>"));
	 $tpl->appendValues(array("TEXT" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=959>Форма для отправки статьи</a>"));
	 $tpl->appendValues(array("TEXT_EN" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/en/jour/".$_SESSION[jour_url]."/index.php?page_id=959>Send article</a>"));
    

    echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
   }
   
   if (count($pagem)>0)
   {
    $tpl = new Templater();
//	$tpl->setValues($rows[0][cv_text]);
	$tpl->appendValues(array("CCLASS" => "Красный"));
	$tpl->appendValues(array("CTYPE" => "Текст"));
	if($_SESSION[jour_url]!='god_planety' && $_SESSION[jour_url]!='WER')
	{
	if($_SESSION[jour_url]!='REBQUE')
	{
	if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "В журнале"));//$pagem[0][jj]));
	else
	    $tpl->appendValues(array("TITLE_EN" => "In Journal"));
		if ($_SESSION[lang]!='/en')
	$tpl->appendValues(array("TEXT" => "<b><a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Архив номеров</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">Индекс рубрик</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">Индекс авторов</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.">Статьи за год</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">Авторы за год</a><br />"
	));
	
	else
	$tpl->appendValues(array("TEXT_EN" => "<b><a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj_en],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Archive</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">Subjects</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">Authors</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.">Articles for the year</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">Authors for the year</a><br />"
	));
	}
	else
	{
		if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "В журнале"));//$pagem[0][jj]));
	else
	    $tpl->appendValues(array("TITLE_EN" => "In Journal"));
		if ($_SESSION[lang]!='/en')
	$tpl->appendValues(array("TEXT" => "<b><a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Архив номеров</a><br />"
	));
	
	else
	$tpl->appendValues(array("TEXT_EN" => "<b><a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj_en],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Archive</a><br />"
	));
	}
	}
	else
	{
		if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "В ежегоднике"));//$pagem[0][jj]));
			else
	    $tpl->appendValues(array("TITLE_EN" => "In Yearbook"));
		if ($_SESSION[lang]!='/en')
	$tpl->appendValues(array("TEXT" => "<b><a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Архив выпусков</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">Индекс рубрик</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">Индекс авторов</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">Авторы за год</a><br />"
	));
	
	else
	$tpl->appendValues(array("TEXT_EN" => "<b><a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj_en],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">Archive</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">Subjects</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">Authors</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">Authors for the year</a><br />"
	));
	}

	echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';

	if($_SESSION[jour_url]=='meimo'){
			 $tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "Красный"));
	$tpl->appendValues(array("CTYPE" => "Текст"));
     if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "По годам"));//$pagem[0][jj]));
	 else
	    $tpl->appendValues(array("TITLE_EN" => "Years"));
	 $tpl->appendValues(array("TEXT" => $years));
	 $tpl->appendValues(array("TEXT_EN" => $years));

	echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
	 /*if($_SESSION[lang]!="/en")
	 	{
	 		$tpl = new Templater();
			$tpl->appendValues(array("CCLASS" => "Красный"));
			$tpl->appendValues(array("CTYPE" => "Текст"));
			$tpl->appendValues(array("TITLE" => 'Внимание'));//$pagem[0][jj]));
			 $tpl->appendValues(array("TEXT" => '<p style="text-align: justify; color: #D20202">Уважаемые авторы и читатели журнала!<br>Сообщаем, что в базу данных Scopus нами загружены все номера 2016 и 2015 годов для их обработки и индексации.</p>'));
		//	 $tpl->appendValues(array("TEXT_EN" => $years));
		    echo '<div class="box">';
					$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
			echo '</div>';
	 	}
	 	else
	 	{
	 		$tpl = new Templater();
			$tpl->appendValues(array("CCLASS" => "Красный"));
			$tpl->appendValues(array("CTYPE" => "Текст"));
			$tpl->appendValues(array("TITLE_EN" => 'ANNOUNCEMENT'));//$pagem[0][jj]));
			 $tpl->appendValues(array("TEXT_EN" => '<p style="text-align: justify; color: #D20202">Dear authors and readers!<br>This is to inform you that we have sent all issues of 2015 and 2016 to Scopus database for their processing and indexing.</p>'));
		//	 $tpl->appendValues(array("TEXT_EN" => $years));
		    echo '<div class="box">';
					$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
			echo '</div>';
	 	}*/
	 }

//	 print_r($rowsm);
	$subscr=$DB->select("SELECT c.cv_text AS subscr, c2.cv_text AS subscr_en
					FROM adm_magazine_content AS c
	               INNER JOIN adm_magazine AS m ON m.page_id=c.page_id AND 
                   m.page_parent=".$_SESSION[jour_id].
				  " INNER JOIN adm_magazine_content AS c2 ON c2.page_id=c.page_id AND c2.cv_name='subscr_en' ".
				   " WHERE c.cv_name='subscr'");	
				   if(count($subscr)>0)
	 {
	 	if($_SESSION[lang]!="/en")
	 	{
	 	if($_SESSION[jour_url]=='meimo' && $subscr[0][subscr]!="" && $subscr[0][subscr]!="<p>&nbsp;</p>")
		{
			$tpl = new Templater();
			$tpl->appendValues(array("CCLASS" => "Голубой 1"));
			$tpl->appendValues(array("CTYPE" => "Текст"));
		     if ($_SESSION[lang]!='/en')
				$tpl->appendValues(array("TITLE" => 'ПОДПИСКА НА ЖУРНАЛ'));//$pagem[0][jj]));
			 else
			    $tpl->appendValues(array("TITLE_EN" => 'SUBSCRIBE TO THE JOURNAL'));
			 $tpl->appendValues(array("TEXT" => $subscr[0][subscr]));
			  $tpl->appendValues(array("TEXT_EN" => $subscr[0][subscr_en]));
		//	 $tpl->appendValues(array("TEXT_EN" => $years));
		    echo '<div class="box">';
					$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
			echo '</div>';
		}
		}
		else
		{
			if($_SESSION[jour_url]=='meimo' && $subscr[0][subscr_en]!="" && $subscr[0][subscr_en]!="<p>&nbsp;</p>")
		{
			$tpl = new Templater();
			$tpl->appendValues(array("CCLASS" => "Голубой 1"));
			$tpl->appendValues(array("CTYPE" => "Текст"));
		     if ($_SESSION[lang]!='/en')
				$tpl->appendValues(array("TITLE" => 'ПОДПИСКА НА ЖУРНАЛ'));//$pagem[0][jj]));
			 else
			    $tpl->appendValues(array("TITLE_EN" => 'SUBSCRIBE TO THE JOURNAL'));
			 $tpl->appendValues(array("TEXT" => $subscr[0][subscr]));
			  $tpl->appendValues(array("TEXT_EN" => $subscr[0][subscr_en]));
		//	 $tpl->appendValues(array("TEXT_EN" => $years));
		    echo '<div class="box">';
					$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
			echo '</div>';
			
		}
		}
	 }
	
	 $years="";
	  if($_SESSION[jour_url]=="REBQUE")
	{
   $rows_rebque=$mz->getMagazineAllPublic();
   foreach($rows_rebque as $row)
	 {
		$years.=" <a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=1025&jid=".$row[jid].
		 ">".$row[year]."</a> |";
	 }
	}
	else
	{
	 foreach($rowsm as $row)
	 {
	     $years.=" <a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.
		 "&year=".$row[year].
		 ">".$row[year]."</a> |";
	 }
	 }

   $flag_block_right = false;
   if ($_SESSION[lang]!='/en') {
       if(!empty($block[0][blocktxt]) && $block[0][blocktxt]!='<p>&nbsp;</p>')
           $flag_block_right = true;
   } else {
       if(!empty($block[0][blocktxt_en]) && $block[0][blocktxt_en]!='<p>&nbsp;</p>')
           $flag_block_right = true;
   }

	 if (count($block)>0 && $flag_block_right)
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
	 if($_SESSION[jour_url]!='meimo')
	{
	 $tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "Красный"));
	$tpl->appendValues(array("CTYPE" => "Текст"));
     if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "По годам"));//$pagem[0][jj]));
	 else
	    $tpl->appendValues(array("TITLE_EN" => "Years"));
	 $tpl->appendValues(array("TEXT" => $years));
	 $tpl->appendValues(array("TEXT_EN" => $years));
	 
	if($_SESSION[jour_url]!='god_planety' && $_SESSION[jour_url]!='WER' && $_SESSION[jour_url]!='oprme')
	{


	echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
	}
	}
	else
	{
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
   
   }
  if($_SESSION[jour_url]!='meimo') {
	 $tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "Зеленый"));
	$tpl->appendValues(array("CTYPE" => "Текст"));

	if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "<a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=959>Отправить статью</a>"));//$pagem[0][jj]));
	 else
	    $tpl->appendValues(array("TITLE_EN" => "<a href=/en/jour/".$_SESSION[jour_url]."/index.php?page_id=959>Send article</a>"));
	 $tpl->appendValues(array("TEXT" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=959>Форма для отправки статьи</a>"));
	 $tpl->appendValues(array("TEXT_EN" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/en/jour/".$_SESSION[jour_url]."/index.php?page_id=959>Send article</a>"));
    

    echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
}
 

	
		if($_SESSION[jour_url]!='meimo')
	{
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
	else
	{

	}
 }
else
{
//if (count($rows)>0)
//{
    $tpl = new Templater();
//	$tpl->setValues($rows[0][cv_text]);
	$tpl->appendValues(array("CCLASS" => "Пустой"));
	$tpl->appendValues(array("CTYPE" => "Текст"));
	$tpl->appendValues(array("TITLE" => "Обратите внимание"));
	$tpl->appendValues(array("TEXT" => $rows[0][cv_text]));
    $tpl->appendValues(array("TEXT_EN" => $rows[0][cv_text]));

	if($rows[0][cv_text]!="" && $rows[0][cv_text]!="<p>&nbsp;</p>")
	{
		echo '<div class="box">';
				$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
		echo '</div>';
	}
//}
if(!empty($elements))
{
	$num = 1;
	foreach($elements as $k => $v)
	{
		
		$tpl = new Templater();
		$tpl->setValues($v);
		if($v[el_id]==109)
		{
			$archive_block=$DB->select("SELECT page_parent,page_link FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);
			if(isint($archive_block[0][page_link]) && $archive_block[0][page_link]!="")
				$archive_block=$DB->select("SELECT page_parent FROM adm_pages WHERE page_id=".$archive_block[0][page_link]);
					//echo "<a hidden=true href=block_test>".$archive_block[0][page_link]."</a>";
				  
			if($archive_block[0][page_parent]!=444)
				{
					continue;
				}
				
			
			
		}
  		if($v["ctype"] == "Фильтр")
			$tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));

		//echo "<a hidden=true href=aaa>".$v[el_id]."</a>";
		echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
		echo '</div>';
		
		$num++;
	}
	
	
}

}
?>