<?
// Главная Текстовая страница журнала
global $_CONFIG, $site_templater;
//include 'counter.php';
if($_SESSION[jour_url]!='god_planety')
{

if ($_SESSION[lang]=='/en')
{
   $suff='_en';$txt="No" ;
}
   else  
  { 
   $suff='';$txt="№ ";
  } 
  }
  else
  {
  if ($_SESSION[lang]=='/en')
{
   $suff='_en';$txt="" ;
}
   else  
  { 
   $suff='';$txt="";
  } 
  }
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.main.html");

$mz=new Magazine();

  	 $last_number=$mz->getLastMagazineNumber($_TPL_REPLACMENT["ITYPE_JOUR"]);
	 
	 if ($_SESSION[lang]!='/en')
	$rowsth=$mz->getMagazineNumber($last_number[0][page_id]);
else
	$rowsth=$mz->getMagazineNumberEn($last_number[0][page_id]);
$rowsth=$mz->appendContentArticle($rowsth);

//print_r($last_number);
echo "<div class='box'>";
 if (!empty($last_number))
 {
 if($_SESSION[jour_url]=='REB-2' || $_SESSION[jour_url]=='sipri')
{
	$temp_text_journals=$rowsth[$last_number[0][page_id]][content][FULL_TEXT];
	
	if($_GET[debug]==1)
	{
		var_dump($temp_text_journals);
	}
	
	$pos_last = strripos($temp_text_journals, "month_");
	$pos_last_a = strripos(substr($temp_text_journals,0,$pos_last),"<a href");
	$link_last_jour = substr($temp_text_journals,$pos_last_a+9);
	$link_last_jour = substr($link_last_jour,0,strpos($link_last_jour,'"'));
	
	if ($_SESSION[lang]!='/en')
	{
	if ($pos_last === false) 
		{
	echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=886&jid=".$last_number[0][page_id].">".
         "Текущий номер (".$txt.$last_number[0][page_name].", ".$last_number[0][year].")</a>";
		 }
		 else
		 {
			$temp_string_journals=substr($temp_text_journals,$pos_last);
			$temp_string_journals=substr(stristr($temp_string_journals,">"),1);
			$temp_string_journals=substr($temp_string_journals,0,strpos($temp_string_journals,"<"));
			echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=".$link_last_jour.">".
         "Текущий номер (".$temp_string_journals.")</a>";
		 }
	}
	else
        echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/en/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=886&jid=".$last_number[0][page_id].">".
         "Current Issue (".$last_number[0][year].", ".$txt.$last_number[0][page_name].")</a>";
}
else
	if($_SESSION[jour_url]!='god_planety')
	{

    if ($_SESSION[lang]!='/en')
	echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$last_number[0][page_summary]."&jid=".$last_number[0][page_id].">".
         "Текущий номер (".$txt.$last_number[0][page_name].", ".$last_number[0][year].")</a>";
	else
        echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/en/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$last_number[0][page_summary]."&jid=".$last_number[0][page_id].">".
         "Current Issue (".$last_number[0][year].", ".$txt.$last_number[0][page_name].")</a>";
	}
	else
	{
	if ($_SESSION[lang]!='/en')
	echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$last_number[0][page_summary]."&jid=".$last_number[0][page_id].">".
         "Текущий выпуск (".$txt.$last_number[0][page_name].", ".$last_number[0][year].")</a>";
	else
        echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/en/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$last_number[0][page_summary]."&jid=".$last_number[0][page_id].">".
         "Current Issue (".$last_number[0][year].", Yearbook)</a>";
	}
	echo "<br />";
 }
 echo $_TPL_REPLACMENT["CONTENT"];
 $pg=new Pages();

 if ($_TPL_REPLACMENT[FOR_NUMBER]!=1)

 {

    $pages=$pg->getChildsJ($_TPL_REPLACMENT["ITYPE_JOUR"]);
//    print_r($pages);

    foreach($pages as $page)
    {

//    	if (!isset($_REQUEST[en]))
			$str0=$pg->getContentByParentIdJ($page[page_id]);
//		else	
//		    $str=$pg->getContentByPageIdJEn($page[page_id]);

//       if (!empty($str[RECLAMA]))
//       {
  if ($page[page_template]!='jportal')
	echo "<br /><div class='title green'><h2>".mb_strtoupper($page['page_name'.$suff],'cp1251')."</h2></div>";
  
 foreach($str0 as $k=>$str2)
	  {
//	print_r($str2);  
	 $str=$str2[content];
//	 echo "<br />____".$str2[page_id].$str2[content][CONTENT][TITLE]; echo "<br />__";echo $str['TITLE'];echo "^^^"; 
//echo $str2[page_name];
    if (empty($str['TITLE'])) $str['TITLE']=$str2[page_name];
	if (empty($str['TITLE_EN'])) $str['TITLE_EN']=$str2[page_name_en];
	if ($_SESSION[lang]=='/en')
		{
		   $str[RECLAMA]=$str[RECLAMA_EN];
		   $str[CONTENT]=$str[CONTENT_EN];
		}
		if ($_SESSION[lang]!='/en')
		{
		if (!empty($str[RECLAMA]) && $str[RECLAMA]<>"<p>&nbsp;</p>" )
		{
	    	echo "<br /><h4>".$str['TITLE']."</h4>";
			echo "".$str[RECLAMA];
		}
		}
		else
		{
		if (!empty($str[RECLAMA_EN]) && $str[RECLAMA_EN]<>"<p>&nbsp;</p>")
		{
	    	echo "<br /><h4>".$str['TITLE_EN']."</h4>";
			echo "".$str[RECLAMA_EN];
		}
		}
        if (!empty($str[CONTENT]) && $str[CONTENT]<>"<p>&nbsp;</p>")
        {
            if ($_SESSION[lang]!='/en')
				echo "<br /><a href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."&id=".$str2[page_id].">подробнее..</a>";
			else	
				echo "<br /><a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."&id=".$str2[page_id].">more..</a>";

		}
		
// eсли архив номеров

   if ($page[page_template]=="magazine_page_archive")
   {
   $rowys=$mz->getMagazineAllYear($page[page_parent]);
   foreach($rowys as $i=>$ry)
   {
     $yearn[$i]=$ry[year];
   }
   $rows=$mz->getMagazineAllPublic($page[page_parent]);
 
  $year="";$iy=0;
  if ($_SESSION[lang]!='/en')
	echo "<br /><b>Архив номеров</b><br /><br />";
  else	
	echo "<br /><b>Archive</b><br /><br />";

  echo "<table border=1 cellspacing='0' cellpadding='0'>";
  $num=Array();
  foreach($rows as $row)
  {
     $num[$row[page_name]][$row[year]]=$row[jid];
//	 echo "<br />";print_r($row);
  }
 // print_r($num);
	foreach($yearn as $yn)
	{
       echo "<tr><td>&nbsp;".$yn."&nbsp;</td>";
	   for ($i=1;$i<=$row[numbers];$i++)
	   {
			
			if (!empty($num[$i][$yn]))
				echo"<td>&nbsp;&nbsp;&nbsp;<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[SUMMARY_ID]."&jid=".$num[$i][$yn].">".
				$txt.$i."&nbsp;&nbsp;&nbsp;</td>";
			else
                echo "<td>&nbsp;&nbsp;&nbsp;".$txt.$i."&nbsp;&nbsp;&nbsp;</td>";			
	   }	
     }     
	 echo "</tr></table>";
//       echo "</div>";


///  }
  echo "<br /><hr /></br />";
  } 
// к архиву номеров		
        if (!empty($str[RECLAMA]) && $str[RECLAMA]<>"<p>&nbsp;</p>")
		echo "<div class='sep'> </div>";
        }
    }

  }
  else
  {
  	   $pages=$pg->getPageByIdJ($_TPL_REPLACMENT["ITYPE_JOUR"]);

 //      echo $pages[page_name];


  }
  if($_SESSION[jour_url]!='god_planety' && $_SESSION[jour_url]!='REB-2')
  {

  if (!isset($_REQUEST[en]))
	echo "<div class='title green'><h2>Содержание журнала</h2></div>";
  else
  {
    if($_SESSION[jour_url]!='meimo' && $_SESSION[jour_url]!='RNE' && $_SESSION[jour_url]!='PMB')
	{
		echo "<h4>Content</h4>";
	}
   }
  echo "<ul class='speclist'>";
  if ($_SESSION[lang]!='/en')
  {
  if (!empty($_TPL_REPLACMENT[ARCHIVE_ID]))
     echo "<li><a href=index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID].">Архив номеров</a></li>";
  if (!empty($_TPL_REPLACMENT[AUTHORS_ID]))
     echo "<li><a href=index.php?page_id=".$_TPL_REPLACMENT[AUTHORS_ID].">Индекс авторов</a></li>";
  if (!empty($_TPL_REPLACMENT[RUBRICS_ID]))
     echo "<li><a href=index.php?page_id=".$_TPL_REPLACMENT[RUBRICS_ID].">Индекс рубрик</a></li>";
  }
  else
  {
	  if($_SESSION[jour_url]!='meimo' && $_SESSION[jour_url]!='RNE' && $_SESSION[jour_url]!='PMB')
	{
	   if (!empty($_TPL_REPLACMENT[ARCHIVE_ID]))
		 echo "<li><a href=/en/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID].">Archive</a></li>";
	  if (!empty($_TPL_REPLACMENT[AUTHORS_ID]))
		 echo "<li><a href=/en/index.php?page_id=".$_TPL_REPLACMENT[AUTHORS_ID].">Authors</a></li>";
	  if (!empty($_TPL_REPLACMENT[RUBRICS_ID]))
		 echo "<li><a href=/en/index.php?page_id=".$_TPL_REPLACMENT[RUBRICS_ID].">Rubrics</a></li>";  
	}
  }
    
  echo "</ul>";
  }
  echo "</div>";

//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.main.html");
?>

