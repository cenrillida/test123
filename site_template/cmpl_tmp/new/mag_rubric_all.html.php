<?
global $DB,$_CONFIG, $site_templater;

if (isset($_REQUEST[printmode])) $_REQUEST[printmode]=$DB->cleanuserinput($_REQUEST[printmode]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);
$_REQUEST[year]=(int)$DB->cleanuserinput($_REQUEST[year]);
$_REQUEST[rub]=$DB->cleanuserinput($_REQUEST[rub]);

$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
 
$pageid=$_REQUEST[page_id];


if ($_SESSION[lang]=='/en')
{
   $suff='_en';
   $txt1="Rubrics";
   $txt2="Аnnual maintenance ";
   $txt3="";
   $ntxt="No. ";
}
else
{
   $suff="";   
   $txt1="Список рубрик";
   $txt2="Ежегодное оглавление ";
   $txt3=" г.";
   $ntxt="№ ";
}
   //Индекс рубрик

  $pg=new MagazineNew();


$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>
<script type='text/javascript'>
function rub_sw()
{
   
	location.href='#'+document.getElementById('rubind').value;

}
</script>
<?


 if (!$_TPL_REPLACMENT[SHORT_LIST]==1)
 {
  $rows=$pg->getMagazineAllYearByName($_TPL_REPLACMENT["MAIN_JOUR_ID"]);
  $ymax=1900;
  foreach($rows as $row)
  {
     echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$row[page_id].">".$row[year]."</a> | ";
	 if ($ymax < $row[year]) $ymax=$row[year];
  }
  if (empty($_REQUEST[year])) $_REQUEST[year]=$ymax;
  if ($_REQUEST[year]>$ymax) $_REQUEST[year]=$ymax;
  }
  if ($_TPL_REPLACMENT[SHORT_LIST]!=1) $yearmain=$_REQUEST[year]; else $yearmain="*";
 // echo "<br />______".$_TPL_REPLACMENT[SHORT_LIST]."^^^".$yearmain;
 if ($_TPL_REPLACMENT[SHORT_LIST]!=1)echo "<br /><br /><h2>".$_REQUEST[year]."</h2>";
  
  
  if ($_SESSION["lang"]!='/en')
  {
	$rows=$pg->getRubricAll($_TPL_REPLACMENT["MAIN_JOUR_ID"],1,' ',' ' ,$yearmain);
	
  }
  else	
  {
	
	$rows=$pg->getRubricAllEn($_TPL_REPLACMENT["MAIN_JOUR_ID"],1,' ',' ' ,$yearmain);
  }	


  $rows=$pg->appendContentArticle($rows);

  if ($_TPL_REPLACMENT[SHORT_LIST]==1)  //Проверить можно ли выдать краткий список
  {
     if ($_SESSION[lang]!='/en')
	 {
	 $rows=$DB->select("SELECT IFNULL(r.name,r.page_name) AS name,
	 IFNULL(r.name,r.page_name) AS name,sum(z.count) AS sum, r.page_id AS article_id
	 FROM 
	 (SELECT page_parent,count(page_id)AS count 
		FROM `adm_article` WHERE date_public<>'' AND page_template='jarticle' 
		AND IFNULL(name,page_name) <> 'Авторы этого номера'
		GROUP BY page_parent) AS z 
		INNER JOIN adm_article AS r ON r.page_id=z.page_parent AND r.page_template='jrubric' 
		    AND r.journal_new='".(int)$_TPL_REPLACMENT["MAIN_JOUR_ID"]."' 
		GROUP BY IFNULL(r.name,r.page_name)
		ORDER BY IFNULL(r.name,r.page_name)");
    //  print_r($rows);
	}
	else
	$rows=$DB->select("SELECT IFNULL(r.name,r.page_name) AS name,
	 IFNULL(r.name_en,r.page_name) AS name_en,sum(z.count) AS sum, name_en AS en, r.page_id AS article_id
	 FROM 
	 (SELECT page_parent,count(page_id)AS count 
		FROM `adm_article` WHERE date_public<>'' AND page_template='jarticle' 
		GROUP BY page_parent) AS z 
		INNER JOIN adm_article AS r ON r.page_id=z.page_parent AND r.page_template='jrubric' AND name_en<>'' 
		AND r.journal_new='".(int)$_TPL_REPLACMENT["MAIN_JOUR_ID"]."'
		GROUP BY r.name_en
		ORDER BY IF(IFNULL(r.name_en,' ')=' ',0,1) DESC, r.name_en");
	

     echo "<div style='line-height:22px;'>";
	 echo "<ol>";
	 foreach($rows as $row)
	 {
	  
			if ($_SESSION[lang]=='/en' && empty($row['name_en'])) $row['name_en']=$row['name'];
			if ($_SESSION[lang]!='/en')
			{
			    echo "<li><a class='text-uppercase' href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT["RUBRIC_ID"]."&article_id=".$row['article_id'].">".
			    $row['name'.$suff]."</a> [".$row['sum']." статей] </li>";
			}
			else
			{
                echo "<li><a class='text-uppercase' href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT["RUBRIC_ID"]."&article_id=".$row['article_id'].">".
			    $row['name'.$suff]."</a> [".$row['sum']." articles] </li>";
			}
//			print_r($row);
        		
	 }
	 echo "</ol></div>";
   }  
   else
   {

// Формирование combobox
echo "<br /><br />";
if ($_SESSION["lang"] !='/en')
  echo "<a name='0'></a><select onchange=rub_sw() name='rubind' id='rubind'>
  <option value='' style='color:#aaaaaa;'><span style='color:#aaaaaa;'>Быстрый поиск рубрики</span></option>";
else
echo "<a name='0'></a><select onchange=rub_sw() name='rubind' id='rubind'>
  <option value='' style='color:#aaaaaa;'><span style='color:#aaaaaa;'>Rubric Search</span></option>";
 
 $i=0;$rubric='';
 foreach($rows as $row)
  {
     if (empty($row[content][RUBRIC_EN])) $row[content][RUBRIC_EN]=$row[name_en];
     if (empty($row[content][RUBRIC])) $row[content][RUBRIC]=$row[page_name];
	 if ($_SESSION["lang"]=='/en') $rubname=substr($row[content][RUBRIC_EN],0,50);
	 else $rubname=substr($row[content][RUBRIC],0,50);
	 
	 if ($rubric!=$rubname)
	 {
		if ($_SESSION["lang"]!='/en')
			echo "<option value=".$row[page_id].">".$row[content][RUBRIC]."</option>";
		else	
			echo "<option value=".$row[page_id].">".$row[content][RUBRIC_EN]."</option>";

		$i++;
		$rubric=$rubname;
	 }	
  }
   echo "</select>";
////
 $rubric='';$i=0;

 foreach($rows as $row)
 {
//echo "<br />".$row[page_id];print_r($row);
if (empty($row[content][RUBRIC_EN])) $row[content][RUBRIC_EN]=$row[name_en];
if (empty($row[content][RUBRIC])) $row[content][RUBRIC]=$row[page_name];
 if ($_SESSION["lang"]=='/en')
  {
      if (!empty($row[content][RUBRIC_EN])) $row[content][RUBRIC]=$row[content][RUBRIC_EN];
  }  

  if (!empty($row[content][RUBRIC]))
     {

	        echo "<br><div class='name_r'>";

	        if ($rubric != $row[content][RUBRIC])
	        {
	        	//if (!empty($rubric) && $_SESSION["lang"]!='/en') echo "<a href='#0'>>>наверх</a>";
				//if (!empty($rubric) && $_SESSION["lang"]=='/en') echo "<a href='#0'>>>top</a>";
				$str=strpos($row[content][RUBRIC],"^");

	        	if ($str>0)  //Составная рубрика
	        	{
	        	    if (trim(substr($rubric,0,$str)) ==  trim(substr($row[content][RUBRIC],0,$str)))
	        	    {
	        	       $class='jrubric2';
	        	       $sim=">> ";
	        	    }
	        	    else
	        	    {
	        	       $class='jrubric';
	        	       $sim='';
	        	     }
	        	}
	        	else
	        	{
	        	     $class='jrubric';
	        	     $sim='';
	        	}
	        	echo "<a name=".$row[page_id]."></a>";
				echo "<div class='".$class."'>".$sim."<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[RUBRIC_ID].
    		    	"&article_id=".$row[page_id].">".mb_strtoupper($row[content][RUBRIC],"CP1251")."</a></div>";
    		    
				$rubric=$row[content][RUBRIC];
    		}
			
//	print_r($row);		
    //		echo "<div class='name_r'><b>№".$row[number]."-".$row[year]."</b></div>";
//echo $_SESSION[lang];
	echo "<div class='name_r'><b><a href=".$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID].
			"&article_id=".$row[page_parent].">";

			$vol_pos = strripos($row[number], "т.");
		
		if ($vol_pos === false) {
				if($_SESSION[lang]=='/en' && !empty($row[number_en]))
					$row[number]=$row[number_en];
				echo $ntxt.$row[number].", ".$row[year];
			}
			else {
				$volume=substr($row[number], $vol_pos);
			   if($_SESSION[lang]=='/en')
				$volume=str_replace("т.", "vol.",$volume);
				$number=spliti(",",$row[number]);

				echo $volume.", ".$ntxt.$number[0].", ".$row[year];
			}
			echo "</a></b></div>";
//	echo $_SESSION[lang];		
    		$art0=$pg->getChildsArticleAllAlf($row[page_id]);
//	echo $_SESSION[lang];		
//			echo "<br />___";print_r($art0);
//    		$art0=$pg->appendContentArticle($art0);
//echo $_SESSION[lang];
    		foreach($art0 as $art)
    		{

//echo $art[page_template];
    			if ($art[page_template]!='jrubric')
    			{
//echo $_SESSION[lang];
                   if ($_SESSION["lang"]!='/en') $people0=$pg->getAutors($art[people]);
				   else {
                       $secondField = false;
                       if($_REQUEST['jj']==1669) {
                           $secondField = true;
                       }
                       $people0=$pg->getAutorsEn($row['people'],$secondField);
                   }
//echo $_SESSION[lang];
				   //print_r($people0);
      	 			$avtList='';

		      	   foreach($people0 as $people)
      			   {
      	
		if (!empty($people[id]))
      	      			{
			      	      if(substr($people[fio],0,8)!='редакция' && substr($people[fio],0,8)!='Редакция') //907
      	    			  {
				      	      if ($people[otdel]!='Умершие сотрудники')
      	        				  $avtList.="<a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT[AUTHOR_ID]."&id=".$people[id].
								  "&at=a>".$people[fio]."</a>, ";
		      			      else
                     	           $avtList.="<a style='border:1px solid gray;' href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID].
								   "&id=".$people[id]."&at=a>".$people[fio]."</a>, "; //.$people[work].",".$people[mail1]."";
                          }
                     }
                   }

          		   echo "<div class='autors'>";
			           $avtList=substr($avtList,0,-2);
           			   echo $avtList;
      	   			echo "</div>";

//	    			echo "<div class='jarticle' style='padding-left:60px;'>".$art[name]."</div>";
                    if ($_SESSION["lang"]!='/en' || empty($art[name_en]))
 			     	 echo "<div class='name'><a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$art[page_id].">".$art[name]."</a></div>";
                    else 
      		     	 echo "<div class='name'><a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$art[page_id].">".$art[name_en]."</a></div>";


	    		}
	    		else
	    		{
	    			$art20=$pg->getChildsArticleAllAlf($art[page_id]);
				
	    		    foreach($art20 as $art2)
    				{
			    			if ($_SESSION[lang]!='/en')
								$people0=$pg->getAutors($art2[people]);
							else	
                               $people0=$pg->getAutorsEn($art2[people]);
      	 			$avtList='';

		      	   foreach($people0 as $people)
      			   {
      	      		if (!empty($people[id]))
      	      			{
			      	      if($people!='редакция' )
      	    			  {
				      	      if ($people[otdel]!='Умершие сотрудники')
      	        				  $avtList.="<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[AUTHOR_ID]."&id=".$people[id]."&at=a>".$people[fio]."</a>, ";
		      			      else
                     	           $avtList.="<a style='border:1px solid gray;' href=".$_SESSION[lang]."/index.php?page_id".$_TPL_REPLACMENT[AUTHOR_ID]."&id=".$people[id]."&at=a>".$people[fio]."</a>, "; //.$people[work].",".$people[mail1]."";
                          }
                     }
                   }
          		   echo "<div class='autors'>";
			           $avtList=substr($avtList,0,-2);
           			   echo $avtList;
      	   			echo "</div>";
					if ($_SESSION[lang]=='/en') $art2[name]=$art2[name_en];
//	    			echo "<div class='jarticle' style='padding-left:60px;'>".$art[name]."</div>";
 			     	 echo "<div class='name'><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$art2[page_id].">".$art2[name]."</a></div>";


    				}
	    		}
    		}
    		echo "</div>";
			$i++;
    

     }
 }

}

//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
