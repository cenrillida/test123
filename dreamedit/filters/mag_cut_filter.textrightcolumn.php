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
$elements = $headers->getHeaderElements("����� - ������ �������");
$rows=$DB->select("SELECT cv_text FROM adm_pages_content WHERE page_id=".$_REQUEST[page_id].
				  " AND (cv_text<>'' AND cv_text<>'<p>&nbsp;</p>') AND cv_name='reclama".$suff."'");
//print_r($page_content);
$template=$DB->select("SELECT page_template FROM adm_pages WHERE page_id=".$_REQUEST[page_id]);
$rowsm=$mz->getMagazineAllYear($_SESSION[jour_id]);

if (substr($template[0][page_template],0,8)=='magazine' )
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
   
   if (count($pagem)>0)
   {
    $tpl = new Templater();
//	$tpl->setValues($rows[0][cv_text]);
	$tpl->appendValues(array("CCLASS" => "�������"));
	$tpl->appendValues(array("CTYPE" => "�����"));
	if($_SESSION[jour_url]!='god_planety')
	{
	if($_SESSION[jour_url]!='REBQUE')
	{
	if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "� �������"));//$pagem[0][jj]));
	else
	    $tpl->appendValues(array("TITLE_EN" => "In Journal"));
		if ($_SESSION[lang]!='/en')
	$tpl->appendValues(array("TEXT" => "<b><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">����� �������</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">������ ������</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">������ �������</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.">������ �� ���</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">������ �� ���</a><br />"
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
		$tpl->appendValues(array("TITLE" => "� �������"));//$pagem[0][jj]));
	else
	    $tpl->appendValues(array("TITLE_EN" => "In Journal"));
		if ($_SESSION[lang]!='/en')
	$tpl->appendValues(array("TEXT" => "<b><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">����� �������</a><br />"
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
		$tpl->appendValues(array("TITLE" => "� ����������"));//$pagem[0][jj]));
			else
	    $tpl->appendValues(array("TITLE_EN" => "In Yearbook"));
		if ($_SESSION[lang]!='/en')
	$tpl->appendValues(array("TEXT" => "<b><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url].">".
	mb_strtoupper($pagem[0][jj],'cp1251')."</a></b><br>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$archiveid.">����� ��������</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$rubricid.">������ ������</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$authorid.">������ �������</a><br />".
	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">������ �� ���</a><br />"
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
	<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$ayearsid.">Authors for the year</a><br />"
	));
	}
	
	echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
//	 print_r($rowsm);
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
	 $tpl->appendValues(array("CCLASS" => "�����"));
	$tpl->appendValues(array("CTYPE" => "�����"));
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
	 $tpl->appendValues(array("CCLASS" => "�������"));
	$tpl->appendValues(array("CTYPE" => "�����"));
     if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "�� �����"));//$pagem[0][jj]));
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
   
   }
  
	 $tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "�������"));
	$tpl->appendValues(array("CTYPE" => "�����"));

	if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "<a href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=959>��������� ������</a>"));//$pagem[0][jj]));
	 else
	    $tpl->appendValues(array("TITLE_EN" => "<a href=/en/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=959>Send article</a>"));
	 $tpl->appendValues(array("TEXT" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=959>����� ��� �������� ������</a>"));
	 $tpl->appendValues(array("TEXT_EN" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/en/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=959>Send article</a>"));
    echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
 

	
if (count($citas)>0)
	{	

	$tpl = new Templater();
	 $tpl->appendValues(array("CCLASS" => "�������"));
	$tpl->appendValues(array("CTYPE" => "�����"));
     if ($_SESSION[lang]!='/en')
		$tpl->appendValues(array("TITLE" => "�������������"));//$pagem[0][jj]));
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
//if (count($rows)>0)
//{
    $tpl = new Templater();
//	$tpl->setValues($rows[0][cv_text]);
	$tpl->appendValues(array("CCLASS" => "�����"));
	$tpl->appendValues(array("CTYPE" => "�����"));
	$tpl->appendValues(array("TITLE" => "�������� ��������"));
	$tpl->appendValues(array("TEXT" => $rows[0][cv_text]));
	echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';
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
			$archive_block=$DB->select("SELECT page_parent,page_link FROM adm_pages WHERE page_id=".$_REQUEST[page_id]);
			if(isint($archive_block[0][page_link]) && $archive_block[0][page_link]!="")
				$archive_block=$DB->select("SELECT page_parent FROM adm_pages WHERE page_id=".$archive_block[0][page_link]);
					//echo "<a hidden=true href=block_test>".$archive_block[0][page_link]."</a>";
				  
			if($archive_block[0][page_parent]!=444)
				{
					continue;
				}
				
			
			
		}
  		if($v["ctype"] == "������")
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