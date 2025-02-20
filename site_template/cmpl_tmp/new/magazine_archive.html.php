<?
global $DB,$_CONFIG, $site_templater;
if ($_SESSION[lang]=='/en')
{
   $suff='&en';
   $txt1="No.&nbsp;";$txt2='Topic';
}
   else  
{ 
 $suff='';
  $txt1="№&nbsp;";$txt2='Тема номера';
}
 //Архиы номеров

  $pg=new Magazine();

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

  $rows=$pg->getMagazineAllPublic();

$year="";
$i=0;

$first = true;

echo '<div class="row">';
  foreach($rows as $row)
  {
      if($_SESSION[lang]=='/en' && !empty($row[page_name_en]))
		$page_name_number_en = $row[page_name_en];
	else
		$page_name_number_en = $row[page_name];


	  if ($year!=$row[year])
	  {
		  if($first) {
			  $first = false;
		  } else {
			  echo "</div>";
		  }

	     echo "<div class='col-12 col-md-3 col-sm-4 mb-3 text-center'><h4>".$row[year]."</h4>";
		 $year=$row[year];
		 $i=0;
	  }

	  //echo "<a hidden=true src=aaa>".$row[page_name]."</a>";
	  /*if(!empty($row[subject])&& $row[subject]<>"<p>&nbsp;</p>")
      {	
		if ($_SESSION[lang]!='/en')
			$rowsth=$pg->getMagazineNumber($row[page_id]);
		else
			$rowsth=$pg->getMagazineNumberEn($row[page_id]);
		$rowsth=$pg->appendContentArticle($rowsth);
		
		if($_SESSION[lang]=='/en')
		{
			if(!empty($rowsth[$row[page_id]][content][SUBJECT_EN])) $row[subject]=$rowsth[$row[page_id]][content][SUBJECT_EN];
		} 
		
		echo "<div class='jrubric'>";
		if($row[page_name]=='Ежегодник' && $_SESSION[lang]=='/en')
       echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $txt1."Yearbook"." ".$row[year]. "";
	   else
	   echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $txt1.$row[page_name]." ".$row[year]. "";
       if(!empty($row[subject])&& $row[subject]<>"<p>&nbsp;</p>")
         echo str_replace("<p>","<p>".$txt2.": ",$row[subject]);
		echo "</a>";
       echo "</div>";
      }*/
	  //else
	  //{

//	  if ($i==6)
//		{
//		   echo "<br />";
//		   $i=0;
//		}
//
	  echo "<div>";
		if ($row[page_name]<1) $sp="&nbsp;&nbsp;";else $sp="";
		
		$vol_pos = strripos($row[page_name], "т.");
		
		if ($vol_pos === false) {
			if($_SESSION[jour_url]=="god_planety") {
				if($row[page_name]=='Ежегодник') {
					if($_SESSION[lang]=="/en")
									echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid]."> ".
		       "Yearbook".",&nbsp;".$row[year]. "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		       else
		       		echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid]."> ".
		       $row[page_name].",&nbsp;выпуск&nbsp;".$row[year]. "&nbsp;года</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		   		}
			   else {
				echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
		       $txt1.$sp.$page_name_number_en."&nbsp;".$row[year]. "</a>&nbsp;&nbsp;&nbsp;&nbsp;"; 
		   		}
			}
			elseif ($_SESSION[jour_url]=="Russia-n-World" || $_SESSION[jour_url]=="SIPRI") {
                echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
                    $page_name_number_en. "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            }
			else
			{
				if($_SESSION[jour_url]=="oprme") {
                    if (!is_numeric($page_name_number_en)) {
                        $txt1 = '';
                        $sp = '';
                    }
					else {
							if($_SESSION[lang]!='/en')
								$txt1 = '№ ';
							else
								$txt1 = 'No ';
						}
                    if ($row[page_name] == 'Ежегодник' && $_SESSION[lang] == '/en')
                        echo "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $_TPL_REPLACMENT[NUMBER_ID] . "&jid=" . $row[jid] . ">" .
                            $txt1 . $sp . "Yearbook" . "&nbsp;" . $row[year] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    else {
						echo "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $_TPL_REPLACMENT[NUMBER_ID] . "&jid=" . $row[jid] . ">" .
							$txt1 . $sp . $page_name_number_en . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
				}
				else {

                    if ($row[page_name] == 'Ежегодник' && $_SESSION[lang] == '/en')
                        echo "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $_TPL_REPLACMENT[NUMBER_ID] . "&jid=" . $row[jid] . ">" .
                            $txt1 . $sp . "Yearbook" . "&nbsp;" . $row[year] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    else {
                        if ($_SESSION[jour_url] != "WER")
                            echo "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $_TPL_REPLACMENT[NUMBER_ID] . "&jid=" . $row[jid] . ">" .
                                $txt1 . $sp . $page_name_number_en . ",&nbsp;" . $row[year] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                        else
                            echo "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $_TPL_REPLACMENT[NUMBER_ID] . "&jid=" . $row[jid] . ">" .
                                $sp . $page_name_number_en . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                }
   			}
	   }
	   else
	   {
		$volume=substr($row[page_name], $vol_pos);
	   if($_SESSION[lang]=='/en')
		$volume=str_replace("т.", "vol.",$volume);
		$number=spliti(",",$row[page_name]);
	   if($row[page_name]=='Ежегодник' && $_SESSION[lang]=='/en')
		echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $txt1.$sp."Yearbook"."&nbsp;".$row[year]. "</a>&nbsp;&nbsp;&nbsp;&nbsp;"; 
	   else
		echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $volume.", ".$txt1.$sp.$number[0].",&nbsp;".$row[year]. "</a>&nbsp;&nbsp;&nbsp;&nbsp;"; 
	   }
	   echo '</div>';
	   $i++;
	  //}

  }
  if(!$first) {
  	echo '</div>';
  }
  echo '</div>';


//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
