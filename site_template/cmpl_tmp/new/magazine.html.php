<?
// √лавна€ “екстова€ страница журнала
global $_CONFIG, $DB, $site_templater;

$headers = new Headers();
$mainbanner = $headers->getJourBanner();
//include 'counter.php';
if($_SESSION[jour_url]!='god_planety' && $_SESSION[jour_url]!='oprme' && $_SESSION[jour_url]!='Russia-n-World' && $_SESSION[jour_url]!='SIPRI')
{

if ($_SESSION[lang]=='/en')
{
   $suff='_en';$txt="No. " ;
}
   else  
  { 
   $suff='';$txt="є ";
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
?>
<section class="pt-3 pb-5 bg-color-lightergray">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-8 col-xs-12 pt-3 pb-3 pr-xl-4">
                <div class="container-fluid left-column-container">
                    <div class="row shadow border bg-white printables mb-5">
                        <div class="col-12 pt-3 pb-3">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 py-3">
                                        <h3><?php if($_SESSION[lang]!="/en") echo $mainbanner[0]["page_name"]; else echo $mainbanner[0]["page_name_en"];?></h3>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <?php
                                        preg_match_all( '@src="([^"]+)"@' , $mainbanner[0]['logo_main'], $imgSrc );
                                        preg_match_all( '@alt="([^"]+)"@' , $mainbanner[0]['logo_main'], $imgAlt );
                                        $imgSrc = array_pop($imgSrc);
                                        $imgAlt = array_pop($imgAlt);
                                        $alt_str = "";
                                        if(!empty($imgAlt))
                                            $alt_str = ' alt="'.$imgAlt[0].'"';
                                        ?>
                                        <?php if(!empty($imgSrc)):?>
                                            <img class="border" src="<?=$imgSrc[0]?>" alt="<?=$alt_str?>">
                                        <?php endif;?>
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php if($_SESSION[lang]!="/en") echo $mainbanner[0]["logo_main_info"]; else echo $mainbanner[0]["logo_main_info_en"];?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row shadow border bg-white printables">
                        <div class="col-12 pt-5 pb-3">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">


<?php
//print_r($last_number);
$sinlefull_string = '';
if($_SESSION[jour_url]=='meimo')
    $sinlefull_string = ' singleFull';
echo "<div class='box".$sinlefull_string."'>";
 if (!empty($last_number))
 {
  if(!empty($last_number[0][page_name_en]))
  $page_name_number_en = $last_number[0][page_name_en];
else {
    $page_name_number_en = str_replace("≈жегодник","Yearbook",$last_number[0][page_name]);
}
	if($_SESSION[jour_url]!='god_planety' && $_SESSION[jour_url]!='Russia-n-World' && $_SESSION[jour_url]!='SIPRI')
	{
	$vol_pos = strripos($last_number[0][page_name], "т.");
	if ($vol_pos === false) {
    if ($_SESSION[lang]!='/en') {
      if($_SESSION[jour_url]!="WER")
	echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=".$last_number[0][page_summary]."&jid=".$last_number[0][page_id].">".
         "“екущий номер Ц ".$txt.$last_number[0][page_name].", ".$last_number[0][year]."</a>";
         else
            echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
      "<a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=".$last_number[0][page_summary]."&jid=".$last_number[0][page_id].">".
         "“екущий номер Ц ".$last_number[0][page_name]."</a>";
       }
	else
        echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/en/jour/".$_SESSION[jour_url]."/index.php?page_id=".$last_number[0][page_summary]."&jid=".$last_number[0][page_id].">".
         "Current Issue Ц ".$last_number[0][year].", ".$txt.$page_name_number_en."</a>";
		 }
		 else
		 {
		 	$volume=substr($last_number[0][page_name], $vol_pos);
   if($_SESSION[lang]=='/en')
	$volume=str_replace("т.", "vol.",$volume);
	$number=spliti(",",$last_number[0][page_name]);
		     if ($_SESSION[lang]!='/en')
	echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=".$last_number[0][page_summary]."&jid=".$last_number[0][page_id].">".
         "“екущий номер Ц ".$volume.", ".$txt.$number[0].", ".$last_number[0][year]."</a>";
	else
        echo "<img src=/files/Image/info.png />&nbsp;&nbsp;".
    	"<a href=/en/jour/".$_SESSION[jour_url]."/index.php?page_id=".$last_number[0][page_summary]."&jid=".$last_number[0][page_id].">".
         "Current Issue Ц ".$last_number[0][year].", ".$volume.", ".$txt.$number[0]."</a>";
		 }
	}
	else
	{
        if ($_SESSION[lang]!='/en') {
            if($_SESSION[jour_url]=='god_planety')
                echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                    "<a href=/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                    "“екущий выпуск Ц " . $txt . $last_number[0][page_name] . ", " . $last_number[0][year] . "</a>";
            else
                echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                    "<a href=/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                    "“екущий выпуск Ц " . $txt . $last_number[0][page_name]."</a>";
        }
        else {
            if($_SESSION[jour_url]=='god_planety')
                echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                    "<a href=/en/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                    "Current Issue Ц " . $last_number[0][year] . ", Yearbook</a>";
            else
                echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                    "<a href=/en/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                    "Current Issue Ц " . $last_number[0][page_name_en]."</a>";
        }
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
        $str_down = $pg->getContentByPageIdJ($page[page_id]);

        $title_off = $str_down['TITLE_OFF'];
        $more_off = $str_down['MORE_OFF'];
        if($_SESSION[lang]=="/en") {
            $title_off = $str_down['TITLE_OFF_EN'];
            $more_off = $str_down['MORE_OFF_EN'];
        }

  if ($page[page_template]!='jportal' && $page[page_status]=="1" && $title_off!=1)
	echo "<br /><div class='title headers-type-1'><h3 class='green'>".mb_strtoupper($page['page_name'.$suff],'cp1251')."</h3></div>";

if(empty($str0) && $page[page_status]=="1") {

    if($_SESSION[lang]!="/en")
        echo $str_down['RECLAMA'];
    else
        echo $str_down['RECLAMA_EN'];

    if (!empty($str_down[CONTENT]) && $str_down[CONTENT]<>"<p>&nbsp;</p>" && $more_off!=1)
    {
        if ($_SESSION[lang]!='/en')
            echo "<a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."&id=".$page[page_id].">подробнее..</a><br />";
        else
            echo "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."&id=".$page[page_id].">more..</a><br />";

    }
  }

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

         $title_off = $str['TITLE_OFF'];
         $more_off = $str['MORE_OFF'];
         if($_SESSION[lang]=="/en") {
             $title_off = $str['TITLE_OFF_EN'];
             $more_off = $str['MORE_OFF_EN'];
         }

		if ($_SESSION[lang]!='/en')
		{
		if (!empty($str[RECLAMA]) && $str[RECLAMA]<>"<p>&nbsp;</p>")
		{
		    if($title_off!=1) {
                echo "<br /><h4>" . $str['TITLE'] . "</h4>";
            }
			echo "".$str[RECLAMA];
		}
		}
		else
		{
		if (!empty($str[RECLAMA_EN]) && $str[RECLAMA_EN]<>"<p>&nbsp;</p>")
		{
		    if($title_off!=1) {
                echo "<br /><h4>" . $str['TITLE_EN'] . "</h4>";
            }
			echo "".$str[RECLAMA_EN];
		}
		}
        if (!empty($str[CONTENT]) && $str[CONTENT]<>"<p>&nbsp;</p>" && $more_off!=1)
        {
            if ($_SESSION[lang]!='/en')
				echo "<a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."&id=".$str2[page_id].">подробнее..</a>";
			else	
				echo "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID]."&id=".$str2[page_id].">more..</a>";

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
	echo "<br /><b>јрхив</b><br /><br />";
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

  echo "</div>";
?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-xs-12 d-xl-block pt-3 pb-3 px-xl-0 right-column">
                <div class="pr-3">
                    <div class="container-fluid">
                        <?php include_once("main_magazine_right.php");?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
                                        <?php
//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.main.html");
?>

