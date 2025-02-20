<?
global $DB,$_CONFIG, $site_templater;

if (isset($_REQUEST[printmode])) $_REQUEST[printmode]=$DB->cleanuserinput($_REQUEST[printmode]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);
$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);


if ($_SESSION[lang]!='/en')
$rows=$DB->select("SELECT page_name AS name FROM adm_magazine WHERE  page_id=".(int)$_REQUEST[id]);
else
$rows=$DB->select("SELECT page_name_en AS name FROM adm_magazine WHERE  page_id=".(int)$_REQUEST[id]);

$site_templater->appendValues(array("TITLE" => $rows[0][name]));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

 $pg=new Pages();
 $mz=new Magazine();
 if ($_TPL_REPLACMENT[FOR_NUMBER]!=1)
 {

//    $pages=$pg->getChildsJ($_TPL_REPLACMENT["ITYPE_JOUR"]);
//    foreach($pages as $page)
//    {

    	$page=$mz->getPageById($_REQUEST[id]);
//print_r($page);
		$str=$pg->getContentByPageIdJ($_REQUEST[id]);

    	
        if ($_SESSION[lang]=='/en') 
		{
			//echo "<br />".$str[RECLAMA_EN]."";
			echo $str[CONTENT_EN]; 
			$txt ='Back to journal homepage';
		}
		else
        {		
			//echo "<br />".$str[RECLAMA]."";
			echo $str[CONTENT];
			$txt="Назад на главную страницу журнала";
		}	
		
//    }
      if ($page[page_template]=="magazine_page_archive")
	  {
	  
	     $yearmax=0;$yearmin=date("Y");
		 $mag=array();
		 $ar=$mz->getNumbersAll();
		
		 foreach($ar As $a)
		 {
	 		if($_SESSION[jour_url]=="WER") {
	 			$a[page_name]=1;
	 			$_TPL_REPLACMENT[ARCHIVE_ID]=1073;
	 		}
			preg_match("/[^,]+/", $a[page_name],$matches);
	 		$a[page_name] = $matches[0];
		    $mag[$a[year]][$a[page_name]]=$a[page_id];
			if ($yearmax<$a[year]) $yearmax=$a[year];
			if ($yearmin>$a[year]) $yearmin=$a[year];
		 }
		 
		 echo "<table border=1 cellspacing='0' cellpadding='2' width=80%";

	for ($iy=$yearmax;$iy>=$yearmin;$iy=$iy-1)
		 {
		    echo "<tr>";
			echo "<td align=center>".$iy."</td>";
		    for($in=1;$in<=$page[numbers];$in++)
			{
			    if (!empty($mag[$iy][$in]))
					echo "<td align=center><a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&jid=".$mag[$iy][$in].">".$in."</a></td>";
				else
                    echo "<td align=center><span style='color:#aaaaaa;'>".$in."</span></td>";				
			}
			echo "</tr>";
//			if ($iy<2000) break;
		 }
		  echo "</table>";
		 
	  }
     
  }
  else
  {
 // 	   $pages=$pg->getPageByIdJ($_TPL_REPLACMENT["ITYPE_JOUR"]);
 //      echo $pages[page_name];



  }
echo "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID].">".$txt."</a>";

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
