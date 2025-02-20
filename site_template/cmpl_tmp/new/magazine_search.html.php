<?
/////////////////////////
//require_once("class.inputfilter_clean.php");



global $DB, $_CONFIG, $site_templater;
if ($_SESSION[lang]=="/en")
{
    $suff="_en";
	$num="No&nbsp;";
	$page="P.&nbsp;";
	$rub="Rubric: ";
	$txt0='Search';
}
else
{
  $suff="";
  $num="№&nbsp;";
  $page="C.&nbsp;";
  $rub="Рубрика: ";
  $txt0='Что искать';
}
if (!empty($_POST[search])) $_REQUEST[search]=$_POST[search];
if (!empty($_REQUEST["search"]))

$_REQUEST["search"]=str_replace("<script>","",str_replace('</script>','',
							str_replace("SCRIPT","",str_replace('<','',
							str_replace("'","",str_replace('"','',
					         str_replace('select','',str_replace('update','',str_replace('insert','',
					strip_tags($_REQUEST["search"]))))))))));

					
// tags array
	$tags = explode(',', 'br');
	for ($i = 0; $i < count($tags); $i++) $tags[$i] = trim($tags[$i]);
	// attr array
	$attr = explode(',', 'good, style');
	for ($i = 0; $i < count($attr); $i++) $attr[$i] = trim($attr[$i]);
	// select fields
	$tag_method = 1;
	$attr_method = 0;
	
	$xss_auto = 1;
					
					
//$myFilter = new InputFilter($tags, $attr, $tag_method, $attr_method, $xss_auto);
//$_REQUEST["search"] = $myFilter->process($_REQUEST["search"]);					
 /*print_r($_REQUEST);*/
 
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
$ilines = new Ilines();
$pg = new Pages();

?>
<div class="content">
	<h3><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h3>

	<form action="" method="POST" id="sear_full">
             <table style='width:90%;'><tr>
	     <td valign='top' width=50%>
		<?=@$txt0?> <br /><textarea  cols='50' rows='3' name="search" value="<?=$_REQUEST["search"]?>" ><?=$_REQUEST["search"]?></textarea>
             </td><td width='20'>&nbsp;</td>
<?
      if ($_SESSION["lang"]!='/en')
	  {
?>	  

             </tr><tr><td><input type="submit" value="искать"  /></td>

             </td>
<?
}
else
{

  echo "</tr><tr><td><input type='submit' value='search'  /></td>";
}
  ?>
			 </tr></table>

	</form>
     

     <br /><br />

	<?

        $all =0;
        if (!(isset($_GET[pages]) || isset($_GET[person]) || isset($_GET[publs]) || isset($_GET[ilines]) || isset($_GET[idiser]) || isset($_GET[iabstract]) || isset($_GET[ibank])))
        $all = 1;


        $s_doc=0; // Всего найденных страниц


if (!empty($_REQUEST["search"]))
{

  $_REQUEST["search"]=ltrim(rtrim(trim($_REQUEST["search"]),"'"),"'");

  $ind_p=true;

$jour_name=$DB->select("SELECT page_name, page_name_en FROM adm_magazine WHERE page_id=".$_SESSION[jour_id]);
// Поиск на страницах
  if ($all==1  || isset($_GET[pages])) {   
	
if ($_SESSION["lang"]!='/en')	
	
	$rows =  @$DB->select(
		" SELECT DISTINCT ".
		    "p2.page_name, p2.page_id,".
		    "MATCH (adm_magazine_content.`cv_name`,adm_magazine_content.`cv_text`) AGAINST ('".$_REQUEST['search']."' ) AS relevantnost,".
			"adm_magazine_content.page_id  ".

		"FROM adm_magazine_content ".
		" INNER JOIN adm_magazine AS p2 ON p2.page_id=adm_magazine_content.page_id AND page_status  = 1 ".
        " LEFT OUTER JOIN adm_magazine_content AS pp ON pp.page_id=adm_magazine_content.page_id AND pp.cv_name='people' ".

			"AND page_link = '' ".
			"AND page_parent <> '".$_TPL_REPLACMENT['FULL_ID_D']."' ".
			"AND page_parent <> 452 ".
		" WHERE   ".
            " ( adm_magazine_content.cv_name='content' AND  ".
            "(MATCH (adm_magazine_content.`cv_text`,adm_pages_content.`cv_name`) AGAINST ('".$_REQUEST['search']."') OR".
            " MATCH (adm_magazine_content.`cv_text`,adm_pages_content.`cv_name`) AGAINST ('".str_replace('ё','е',$_REQUEST['search'])."')
            OR p2.page_name  LIKE '%".$_REQUEST['search']."%'
            OR MATCH (p2.page_name) AGAINST ('".$_REQUEST['search']."')
            OR  adm_magazine_content.`cv_text` LIKE '%".$_REQUEST['search']."%'
            OR  adm_magazine_content.`cv_text` LIKE '%".str_replace('ё','е',$_REQUEST['search'])."%'
            OR  p2.`page_name` LIKE '%".$_REQUEST['search']."% '
            OR  p2.`page_name` LIKE '%".str_replace('ё','е',$_REQUEST['search'])."% '
           ) )
		   OR 
		   pp.cv_text LIKE '%".$_REQUEST[search]."%'"
		   
	);
else	
	$rows =  @$DB->select(
		" SELECT DISTINCT ".
		    "p2.page_name_en AS page_name, p2.page_id,".
		    "MATCH (adm_magazine_content.`cv_name`,adm_magazine_content.`cv_text`) AGAINST ('".$_REQUEST['search']."' ) AS relevantnost,".
			"adm_magazine_content.page_id  ".

		"FROM adm_magazine_content ".
		" INNER JOIN adm_magazine AS p2 ON p2.page_id=adm_magazine_content.page_id AND page_status  = 1 ".
        " LEFT OUTER JOIN adm_magazine_content AS pp ON pp.page_id=adm_magazine_content.page_id AND pp.cv_name='people' ".

			"AND page_link = '' ".
			"AND page_parent <> '".$_TPL_REPLACMENT['FULL_ID_D']."' ".
			"AND page_parent <> 452 ".
		" WHERE   ".
            " ( adm_magazine_content.cv_name='content_en' AND  ".
            "(MATCH (adm_magazine_content.`cv_text`,adm_magazine_content.`cv_name`) AGAINST ('".$_REQUEST['search']."') OR".
            " MATCH (adm_magazine_content.`cv_text`,adm_magazine_content.`cv_name`) AGAINST ('".str_replace('ё','е',$_REQUEST['search'])."')
            OR p2.page_name  LIKE '%".$_REQUEST['search']."%'
            OR MATCH (p2.page_name) AGAINST ('".$_REQUEST['search']."')
            OR  adm_magazine_content.`cv_text` LIKE '%".$_REQUEST['search']."%'
            OR  adm_magazine_content.`cv_text` LIKE '%".str_replace('ё','е',$_REQUEST['search'])."%'
            OR  p2.`page_name` LIKE '%".$_REQUEST['search']."% '
            OR  p2.`page_name` LIKE '%".str_replace('ё','е',$_REQUEST['search'])."% '
           ) )
		   OR 
		   pp.cv_text LIKE '%".$_REQUEST[search]."%'"
		   
	);
//print_r($rows); echo "111111111111111111";
    $rowsm=$DB->select(
        " SELECT DISTINCT  m2.page_name,IF(m0.cv_name='content',m2.page_id,m2.page_parent) AS page_id,
        IF(m2.page_template='jnumber',m2.page_id,m2.page_parent) AS page_parent,page.page_id AS page ".
        " FROM adm_magazine AS m2 ".
        " LEFT OUTER JOIN adm_pages_content AS ip ON ip.page_id=m2.page_id AND ip.cv_name=  'people' ".
        " LEFT OUTER JOIN adm_magazine_content AS m0 ON m0.page_id=m2.page_id
        INNER JOIN adm_pages_content AS page ON page.cv_name='ITYPE_JOUR' AND (page.cv_text=m2.page_id OR page.cv_text=m2.page_parent)
        INNER JOIN adm_pages AS page0 ON page0.page_id=page.page_id AND page0.page_template='magazine'
        WHERE m2.page_status=1 AND ".
        "(m0.cv_name='content' OR m0.cv_name='reclama') AND  ".
            " (m0.cv_text  LIKE '%".$_REQUEST['search']."%') "
	);

 //  echo "<br />____".count($rows);
        $s_doc=$s_doc + count($rows)+ count($rowsm);
}
//Поиск в персоналиях !!! Разбирать на имя и отчество!!!
	if ($all==1 || isset($_GET[person]) || isset($_GET[publs])) {
// Разобрать на имя и отчество

            $fios=explode(" ",$_REQUEST[search]);

	    $search_fio=" surname LIKE '".$fios[0]."%'";
	    if (isset($fios[1])) {
	       $search_fio = " surname = '".$fios[0]. "' AND name LIKE '".$fios[1]."%'";

            }
	    if (isset($fios[2])) $search_fio .= " AND fname LIKE '".$fios[1]."%'";

	    if ($_SESSION["lang"]!="/en")
			$pages_cont_res_p = $DB->select(
								"SELECT DISTINCT id,surname,name,fname,picsmall FROM persons WHERE ".$search_fio
			);
        else
		    $pages_cont_res_p = $DB->select("SELECT DISTINCT id,Autor_en AS surname,picsmall FROM persons WHERE Autor_en LIKE '".$_REQUEST[search]."%'"
			);
	    $s_doc = $s_doc + count($pages_cont_res_p);
	    
//	    print_r($us0);
	    $s_doc+=count($admin0)+count($us0);
    }


  if ($all==1 || $_GET[publ])
   {
   	 $jour0=$DB->select("SELECT p.page_id,p.page_name,pc.cv_text AS journal FROM adm_magazine AS p
   	                     INNER JOIN adm_magazine_content AS pc ON pc.page_id=p.page_id AND pc.cv_name='CONTENT'
   	                     WHERE  p.page_status=1
						 AND
						 MATCH (`cv_name`,`cv_text`) AGAINST ('".$_REQUEST['search']."' ) > 0"
						 );
//print_r($jour0);						 

   }


/////////////////////////////////////////
// Вывод результатов

//	echo "[в скобках указана степень релевантности]";
if ($_SESSION["lang"]!='/en')
	echo "<b>По Вашему запросу найдено:</b><br /><br />";
else
	echo "<b>Fined:</b><br /><br />";
	
	$pg = new Pages();
	$pages_cont = array();



// Персоны 

        if ($all==1 || isset($_GET[person])) {

            
			if (count($pages_cont_res_p) >0 && $_SESSION["lang"]!='/en') echo "<br /><b>В разделе: ПЕРСОНАЛИИ </b><br /><br />";
			if (count($pages_cont_res_p) >0 && $_SESSION["lang"]=='/en') echo "<br /><b>In Section: PERSONS </b><br /><br />";

            foreach($pages_cont_res_p as $pers){
                if (!empty($pers[picsmall]))
                  echo "<img src='/dreamedit/foto/".$pers[picsmall]."' align='top' >";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID_A]."&id=".$pers[id]."'>".
                "<b>".$pers['surname']."&nbsp;".$pers[name]."&nbsp;".$pers[fname]."</b></a><br />";

            }

//            print_r($us0);

        }




// Страницы
         if (count($rows) >0) 
		 {
			if ($_SESSION[lang]!='/en')	echo "<br /><b>На СТРАНИЦАХ сайта </b><br />";
			else echo "<br /><b>On Pages</b><br />";
         }
        if (count($rows) > 0) {
           $j=0;
	      foreach($rows as $k => $v)
	      {
	     	$aa=$pg->getParents($v["page_id"]);
     		$i=0;


    		foreach($aa as $razdel_name)
    		{
    		    if($i == 2) {
                      $parent00 =$razdel_name["page_name".$suff];
	        	      break;
           	    }
		    $i++;

    		}
    		$parent[$j]=array("parent00"=>$parent00,array_values($v));
                $j++;

           }

// Надо сортироваться
//print_r($parent);

	        asort($parent);
//print_r($parent);
            $tparent="";
            $ind_grant=true;
	        foreach($parent as $k =>$v)
			{	   // ЦИкл по найденным страницам
            if ($tparent != $v["parent00"])
              {
                 if (!empty($tparent)) echo "</ul>";
				 echo "<b>".$v["parent00"]."</b>";
				 echo "<ul>";
				 $tparent = $v["parent00"];
              }			  
	?>

	         <li><a href=<?=@$_SESSION[lang]?>/index.php?page_id=<?=$v[0][1]?>><?=strip_tags($v[0][0])?> </a></li>
	<?

		   }
		   echo "</ul>";
        }


        
		
		if (count($rowsm) >0 && $_SESSION["lang"] !="/en")echo "<br /><b>На СТРАНИЦАХ журналов: </b><br /><ul>";
		if (count($rowsm) >0 && $_SESSION["lang"] =="/en")echo "<br /><b>In MAGAZINES INFO: </b><br /><ul>";
         
       foreach($rowsm As $rowm)
	        {
	                 echo "<li><a href=/index.php?page_id=".$rowm[page_id].">".$rowm[page_name]."</a></li>";
	        }
      if (count($rowsm) >0) echo "</ul>";


$mz0=new Magazine();

     //  foreach($jour0 as $jour)
	 if(1==1)
     {
           $jour[journal]=49;
		   foreach($pages_cont_res_p as $pers)
           {

	           $art0=$mz0->getAuthorsArticleById($pers[id],$jour[journal]);

	           if (count($art0)>0)
	           {
	            if ($_SESSION[lang]!='/en')
					echo "<br /><br /><b>Статьи автора в журналах:</b>";
				else	echo "<br /><br /><b>In Articles:</b>";
               foreach($art0 as $row)
			{

			   $art0=$mz0->getArticleById($row[page_id]);

			   foreach($art0 as $art)
			   {

			   	  $nn=$mz0->getMagazineByArticleId($art[page_id]);
				 
                       if ($_SESSION[lang]!='/en')
							$people0=$mz0->getAutors($art[people]);
						else	$people0=$mz0->getAutorsEn($art[people]);
	                   echo "<li>";
			      	   foreach($people0 as $people)
			      	   {
			      	      echo $people[fio]." "; //.$people[work].",".$people[mail1]."";
			      	   }
                       if (empty($art[name_en])) $art[name_en]="[in russian] ".$art[name];
					   if ($_SESSION[lang]!='/en') 
			      	   echo "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$jour[article_id]."&id=".$art[page_id]."&at=a&pid=".$people[id].">".$art[name].
			      	        " // ".$jour_name[0][page_name].". ".$num.$nn[0][page_name].". ".$nn[0][year].". ".$page.$art[pages];
					   else
					   		echo "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$jour[article_id]."&id=".$art[page_id]."&at=a&pid=".$people[id].">".$art[name_en].
			      	        " // ".$jour_name[0][page_name_en].". ".$num.$nn[0][page_name].". ".$nn[0][year].". ".$page.$art[pages];
			
			      	   echo "</a></li>";

			   }
			   }
			}
         }
      }
         if ($_SESSION["lang"]!="/en")
		 $jour_art0=$DB->select("SELECT DISTINCT p2.cv_text AS page,a.page_id,
         IF(a.page_template='jrubric',CONCAT('РУБРИКА: ',a.page_name),a.page_name) AS page_name,a.jid,a.name,
         a.people,a.page_template,
		 a.j_name,a.number,a.year,a.pages
                  FROM adm_article AS a

         INNER JOIN adm_pages_content AS p1 ON p1.cv_name='ITYPE_JOUR' AND p1.cv_text=a.journal
         INNER JOIN adm_pages_content AS p2 ON p2.page_id=p1.page_id AND
         ((p2.cv_name='rubric_id' AND a.page_template='jrubric') OR (p2.cv_name='article_id' AND a.page_template='jarticle'))
         WHERE journal=".$_SESSION[jour_id]." AND ". $whereart ."  a.date_public<>'' AND (a.page_name LIKE '%".$_REQUEST['search']."%' OR ".
         " MATCH (`name`,`annots`,`keyword`,`contents`) AGAINST ('".str_replace('ё','е',$_REQUEST['search'])."' )) AND  a.name<>''");
         
		 else
		  $jour_art0=$DB->select("SELECT DISTINCT p2.cv_text AS page,a.page_id,
         IF(a.page_template='jrubric',CONCAT('RUBRIC: ',a.page_name),a.page_name) AS page_name,a.jid,a.name_en AS name,a.people,a.page_template,
         a.j_name,a.number,a.year,a.pages
                  FROM adm_article AS a

         INNER JOIN adm_pages_content AS p1 ON p1.cv_name='ITYPE_JOUR' AND p1.cv_text=a.journal
         INNER JOIN adm_pages_content AS p2 ON p2.page_id=p1.page_id AND
         ((p2.cv_name='rubric_id' AND a.page_template='jrubric') OR (p2.cv_name='article_id' AND a.page_template='jarticle'))
         WHERE journal=".$_SESSION[jour_id]." AND a.date_public<>'' AND (a.page_name LIKE '%".$_REQUEST['search']."%' OR ".
         " MATCH (`name_en`,`annots_en`,`keyword_en`) AGAINST ('".str_replace('ё','е',$_REQUEST['search'])."' )) AND a.name<>'' ");
      
		 if (count($jour_art0)>0)
		 {
			if ($_SESSION["lang"]!='/en')
			echo "<b>Статьи в журналах:</b>";
			else
			echo "<b>Articles in Magazines:</b>";
		 
		 echo "<ul>";
		 
		 foreach($jour_art0 as $ja)
         {//echo "<br />_______";print_r($ja);echo "<br />";     
	 if ($_SESSION[lang]!='/en')  $avt=$mz0->getAutors($ja[people]);
			  else $avt=$mz0->getAutorsEn($ja[people]);
		//	  print_r($avt);
			  echo "<li>";
			  $avtlist="";
			  foreach ($avt as $a)
			  {
			     
				 if (!empty($a[fio]))
				 $avtlist.="<a href=".$_SESSION[lang]."/index.php?page_id=458&id=".$a[id].">".$a[fio]."</a>, ";
			  }
			  
			  if (!empty($avtlist)) $avtlist=substr(str_replace(", , ",", ",$avtlist),0,-2);
			  if (!empty($avtlist))  echo $avtlist."<br />";
			  if ($ja[page_template]=="jrubric") echo $rub;
			  echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$ja[page]."&id=".$ja[page_id]."&jid=".$ja[jid].">".$ja['name'].
         	  " // ".$ja[j_name].". ".$num.$ja[number].". ".$ja[year];
			  if ($ja[page_template]!="jrubric")
			  echo ". ".$page.$ja[pages];
         	  echo "</a>";
         }
        
        }


//echo "<br /><br />Если Вы не смогли найти то, что хотели, попробуйте поискать на нашем сайте с помощью Яндекса.<br /><br />";

} // Не пустой поиск
?>


</div>

<?
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>