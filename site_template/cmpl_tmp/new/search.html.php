<?
/////////////////////////
//require_once("class.inputfilter_clean.php");



global $DB, $_CONFIG, $site_templater;
if ($_SESSION[lang]=='/en')
{
   $txt='What to look for';
   $txtpage='Pages';
   $suff="_en";

}
else
{
   $txt='Что искать';
   $txtpage='На СТРАНИЦАХ сайта ';
   $suff="";
}


if (!empty($_REQUEST["search"])) {

    $_REQUEST['search'] = $DB->cleanuserinput($_REQUEST['search']);
    $_REQUEST["search"] = str_replace("<script>", "", str_replace('</script>', '',
        str_replace("SCRIPT", "", str_replace('<', '',
            str_replace("SCRIPT", "", str_replace('"', '',
                str_replace('select', '', str_replace('update', '', str_replace('insert', '',
                    strip_tags($_REQUEST["search"]))))))))));
}
					
					
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
<div class="content search-content-page">
	<h3><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h3>

        <form action="" method="GET" id="sear_full" class="text-center">
            <div class="row">
                <div class="col-12 col-md-7">
                    <div class="form-group">
                        <label for="searchArea"><?=@$txt?></label>
                        <textarea class="form-control" name="search" id="search" rows="3" value="<?=$_REQUEST["search"]?>"><?=$_REQUEST["search"]?></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <?php if ($_SESSION[lang]!='/en'):?>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="pages" value="1" name="pages" <?=@isset($_REQUEST["pages"])? "checked": ""?>>
                            <label class="form-check-label" for="sitePagesCheck">На страницах сайта</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="person" value="1" name="person" <?=@isset($_REQUEST["person"])? "checked": ""?>>
                            <label class="form-check-label" for="sitePersCheck">В персоналиях</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="publs" value="1" name="publs" aria-describedby="submitHelp" <?=@isset($_REQUEST["publs"])? "checked": ""?>>
                            <label class="form-check-label" for="sitePublCheck">В публикациях</label>
                            <small id="submitHelp" class="form-text text-muted">Если ничего не отмечено, то поиск ведется везде</small>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-primary imemo-button text-uppercase"><?php if($_SESSION[lang]!="/en") echo "Искать"; else echo "Search";?></button>
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
  $_REQUEST["search"]=addslashes($_REQUEST["search"]);
  
  //echo "<a hidden=true href=aaa>".$_REQUEST["search"]."</a>";

  $ind_p=true;


// Поиск на страницах
  if ($all==1  || isset($_GET[pages])) {   
	
if ($_SESSION[lang]!='/en')	
	
	$rows =  @$DB->select(
		" SELECT DISTINCT ".
		    "p2.page_name, p2.page_id,".
		    "MATCH (adm_pages_content.`cv_name`,adm_pages_content.`cv_text`) AGAINST ('".$_REQUEST['search']."' ) AS relevantnost,".
			"adm_pages_content.page_id  ".

		"FROM adm_pages_content ".
		" INNER JOIN adm_pages AS p2 ON p2.page_id=adm_pages_content.page_id AND page_status  = 1 ".
        " LEFT OUTER JOIN adm_pages_content AS pp ON pp.page_id=adm_pages_content.page_id AND pp.cv_name='people' ".

			"AND page_link = '' ".
			"AND page_parent <> '".$_TPL_REPLACMENT['FULL_ID_D']."' ".
			"AND page_parent <> 452 ".
		" WHERE   ".
            " ( adm_pages_content.cv_name='content' AND  ".
            "(MATCH (adm_pages_content.`cv_text`,adm_pages_content.`cv_name`) AGAINST ('".$_REQUEST['search']."') OR".
            " MATCH (adm_pages_content.`cv_text`,adm_pages_content.`cv_name`) AGAINST ('".str_replace('ё','е',$_REQUEST['search'])."')
            OR p2.page_name  LIKE '%".$_REQUEST['search']."%'
            OR MATCH (p2.page_name) AGAINST ('".$_REQUEST['search']."')
            OR  adm_pages_content.`cv_text` LIKE '%".$_REQUEST['search']."%'
            OR  adm_pages_content.`cv_text` LIKE '%".str_replace('ё','е',$_REQUEST['search'])."%'
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
		    "MATCH (adm_pages_content.`cv_name`,adm_pages_content.`cv_text`) AGAINST ('".$_REQUEST['search']."' ) AS relevantnost,".
			"adm_pages_content.page_id  ".

		"FROM adm_pages_content ".
		" INNER JOIN adm_pages AS p2 ON p2.page_id=adm_pages_content.page_id AND page_status  = 1 ".
        " LEFT OUTER JOIN adm_pages_content AS pp ON pp.page_id=adm_pages_content.page_id AND pp.cv_name='people' ".

			"AND page_link = '' ".
			"AND page_parent <> '".$_TPL_REPLACMENT['FULL_ID_D']."' ".
			"AND page_parent <> 452 ".
		" WHERE   ".
            " ( adm_pages_content.cv_name='content_en' AND  ".
            "(MATCH (adm_pages_content.`cv_text`,adm_pages_content.`cv_name`) AGAINST ('".$_REQUEST['search']."') OR".
            " MATCH (adm_pages_content.`cv_text`,adm_pages_content.`cv_name`) AGAINST ('".str_replace('ё','е',$_REQUEST['search'])."')
            OR p2.page_name  LIKE '%".$_REQUEST['search']."%'
            OR MATCH (p2.page_name) AGAINST ('".$_REQUEST['search']."')
            OR  adm_pages_content.`cv_text` LIKE '%".$_REQUEST['search']."%'
            OR  adm_pages_content.`cv_text` LIKE '%".str_replace('ё','е',$_REQUEST['search'])."%'
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

// Среди участников мероприятий
       if ($all==1 || $_GET[members]) {
          $fios=explode(" ",$_REQUEST[search]);

	     $search_fio=" p.surname LIKE '".$fios[0]."%'";
	     if (isset($fios[1])) {
	       $search_fio = " p.surname = '".$fios[0]. "' AND p.name LIKE '".$fios[1]."%'";

            }
	    if (isset($fios[2])) $search_fio .= " AND p.fname LIKE '".$fios[1]."%'";



          $imem_cont_res=$DB->select("SELECT DISTINCT ".
                                     " p1.page_id,p.second_profile FROM persons AS p ".
                                     " INNER JOIN adm_pages_content AS p1 ON p1.cv_text LIKE CONCAT(p.id,'<br>%') OR p1.cv_text LIKE
                                         CONCAT('%<br>',p.id,'<br>%') OR p1.cv_text LIKE CONCAT('%<br>',p.id) ".
                                     " WHERE cv_name='people' " .
                                     " AND ".$search_fio
                                     );
           foreach ($imem_cont_res AS $key=>$find_seconds) {
               if ($find_seconds['second_profile'] != -1) {
                   $merging_array = array_merge($imem_cont_res, $DB->select("SELECT DISTINCT ".
                       " p1.page_id FROM persons AS p ".
                       " INNER JOIN adm_pages_content AS p1 ON p1.cv_text LIKE CONCAT(p.id,'<br>%') OR p1.cv_text LIKE
                                         CONCAT('%<br>',p.id,'<br>%') OR p1.cv_text LIKE CONCAT('%<br>',p.id) ".
                       " WHERE cv_name='people' " .
                       " AND p.id=". $find_seconds['second_profile']));
                   $imem_cont_res = $merging_array;
               }
           }
         $s_doc=$s_doc+count($imem_cont_res);


//		 print_r($razdelmaincontent);
   }
// В инфолентах
     if ($all==1 || $_GET[ilines]) {
	 
	 if($_GET['debug']==1)
	 {
		var_dump($_REQUEST['search']);
	 }

	$lines_cont_res = $DB->select(
	  "select distinct ic.el_id,ic2.icont_text as dd,ic.icont_text,ie.itype_id,it.itype_name

	   FROM adm_ilines_content as ic
	  inner join adm_ilines_content as ic2 on ic.el_id=ic2.el_id AND ic2.icont_var='date'
	  inner join adm_ilines_content as ic3 on ic.el_id=ic3.el_id AND (ic3.icont_var='prev_text' OR ic3.icont_var='full_text') AND
	     ( MATCH (ic3.icont_var,ic3.icont_text) AGAINST ('".$_REQUEST['search']."' ) OR ic3.icont_text LIKE '%".$_REQUEST['search']."%')
	  inner join adm_ilines_content as ic4 on ic.el_id=ic4.el_id  AND ic4.icont_var='status' AND ic4.icont_text=1
	  inner join adm_ilines_element as ie on ic.el_id = ie.el_id
	  inner join adm_ilines_type as it on ie.itype_id=it.itype_id AND (it.itype_id=1 OR it.itype_id=3 OR it.itype_id=5 OR it.itype_id=4)

	  WHERE ic.icont_var='title'".

	  " ORDER BY ic2.icont_text desc "
	);
	 if($_GET['debug']==1)
	 {
		var_dump($DB);
	 }
          $s_doc=$s_doc+count($lines_cont_res);
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

	    if ($_SESSION[lang]!="/en") {
            $pages_cont_res_p = $DB->select(
                "SELECT DISTINCT id,surname,name,fname,picsmall,rewards,otdel,otdel2,otdel3,dolj,dolj2,dolj3,second_profile FROM persons WHERE " . $search_fio);
            foreach ($pages_cont_res_p AS $key=>$find_seconds) {
                if ($find_seconds['second_profile'] != -1) {
                    $merging_array = array_merge($pages_cont_res_p, $DB->select("SELECT DISTINCT id,'".$find_seconds['surname']."' AS surname,name,fname,picsmall,rewards,otdel,otdel2,otdel3,dolj,dolj2,dolj3,second_profile FROM persons WHERE id=" . $find_seconds['second_profile']));
                    $pages_cont_res_p = $merging_array;
                }
            }
			}
        else {
            $pages_cont_res_p = $DB->select("SELECT DISTINCT id,Autor_en AS surname,picsmall,rewards,otdel,otdel2,otdel3,dolj,dolj2,dolj3,second_profile FROM persons WHERE Autor_en LIKE '" . $_REQUEST[search] . "%'"
            );
            foreach ($pages_cont_res_p AS $key=>$find_seconds) {
                if ($find_seconds['second_profile'] != -1) {
                    $merging_array = array_merge($pages_cont_res_p, $DB->select("SELECT DISTINCT id,'".$find_seconds['surname']."' AS surname,picsmall,rewards,otdel,otdel2,otdel3,dolj,dolj2,dolj3,second_profile FROM persons WHERE id=" . $find_seconds['second_profile']));
                    $pages_cont_res_p = $merging_array;
                }
            }
        }
	    $s_doc = $s_doc + count($pages_cont_res_p);
	    foreach($pages_cont_res_p as $p)
	    {
//echo "<br />";print_r($p);
	      // $admin0=$DB->select("SELECT id FROM Admin WHERE persona=".$p[id]);
	      // $us0=$DB->select("SELECT id FROM Sovet  WHERE persona=".$p[id]);
		  if ($_SESSION[lang]!='/en')
		   $rowsad=$DB->select("SELECT Admin.*,IF(type=100,'Дирекции',IF(type=200,'Ученого совета',IF(d.icont_text<>'',CONCAT('Диссератционного совета ',d.icont_text),''))) AS spisok, 
            pc.page_id    			
			FROM Admin 
                    LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=Admin.type AND d.icont_var='text' 
					LEFT OUTER JOIN adm_pages_content AS pc ON pc.cv_name='sovet' AND pc.cv_text=d.el_id 
		WHERE persona=".$p[id]." ORDER BY type");
		else
		 $rowsad=$DB->select("SELECT Admin.*,IF(type=100,'Direction',IF(type=200,'The Scientific Council',IF(d.icont_text<>'',CONCAT('Dissertation council ',d.icont_text),''))) AS spisok, 
            pc.page_id    			
			FROM Admin 
                    LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=Admin.type AND d.icont_var='text' 
					LEFT OUTER JOIN adm_pages_content AS pc ON pc.cv_name='sovet' AND pc.cv_text=d.el_id 
		WHERE persona=".$p[id]." ORDER BY type");
		
		if ($_SESSION[lang]!='/en')
		$rowssem=$DB->select("SELECT c.icont_text AS sem, pc.page_id , t.icont_text AS title
                      FROM adm_directories_content AS c
					  INNER JOIN adm_directories_content AS t ON t.el_id=c.el_id AND t.icont_var='text'
					  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=15
					  LEFT OUTER JOIN adm_pages_content AS pc ON pc.cv_name='sem' AND pc.cv_text=c.el_id
					  WHERE c.icont_var='chif' AND c.icont_text=".$p[id]);
		else
				$rowssem=$DB->select("SELECT c.icont_text AS sem, pc.page_id , t.icont_text AS title
                      FROM adm_directories_content AS c
					  INNER JOIN adm_directories_content AS t ON t.el_id=c.el_id AND t.icont_var='text_en'
					  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=15
					  LEFT OUTER JOIN adm_pages_content AS pc ON pc.cv_name='sem' AND pc.cv_text=c.el_id
					  WHERE c.icont_var='chif' AND c.icont_text=".$p[id]);
	
//		print_r($rowsad);
//	       echo "SELECT id FROM Sovet  WHERE persona=".$p[id];
	    }
//	    print_r($us0);
	    $s_doc+=count($admin0)+count($us0);
    }
//Поиск в публикациях
//Сформировать поиск по автору

        if ($all==1 || isset($_GET[publs])) {
           $s_fio = " avtor like '%".$_REQUEST[search]."%' ";
           $s_fio .= " or people_linked like '%".$_REQUEST[search]."%' ";
           foreach($pages_cont_res_p as $avtor) {
               $s_fio.=" or avtor like '%<br>".$avtor[id]."<br>%'";
               $s_fio.=" or avtor like '".$avtor[id]."<br>%'";
               $s_fio.=" or avtor like '%<br>".$avtor[id]."'";

               $s_fio.=" or people_linked like '%<br>".$avtor[id]."<br>%'";
               $s_fio.=" or people_linked like '".$avtor[id]."<br>%'";
               $s_fio.=" or people_linked like '%<br>".$avtor[id]."'";
           }
//авторы

          $pages_cont_res_a = $DB->select(
		"SELECT DISTINCT id,name FROM publ WHERE ".$s_fio ." AND !(avtor like '%коллектив авторов%')"
	   );

//Название

        $pages_cont_res_n = $DB->select(
        " SELECT DISTINCT ".
		    "*, ".
		    "MATCH (`name`,`annots`,`keyword`) AGAINST ('".$_REQUEST['search']."' ) AS relevantnost ".
   		"FROM publ ".
		"WHERE  status=1 AND ".
            "(MATCH (`name`,`annots`,`keyword`) AGAINST ('".$_REQUEST['search']."' ) > 0
            OR MATCH (`name`,`annots`,`keyword`) AGAINST ('".str_replace('ё','е',$_REQUEST['search'])."' ) > 0
            OR name LIKE '%".$_REQUEST['search']."%' OR annots LIKE '%".$_REQUEST['search']."%' OR keyword LIKE '%".$_REQUEST['search']."%'
            )"

        );


	   $s_doc=$s_doc+count($pages_cont_res_a)+ count($pages_cont_res_n);
        }

  if ($all==1 || $_GET[publ])
   {
   	 $jour0=$DB->select("SELECT p.page_id,p.page_name,pc.cv_text AS journal,p.page_id AS jid FROM adm_magazine AS p
   	                     INNER JOIN adm_magazine_content AS pc ON pc.page_id=p.page_id AND pc.cv_name='CONTENT'
   	                     WHERE  p.page_status=1
						 AND
						 MATCH (`cv_name`,`cv_text`) AGAINST ('".$_REQUEST['search']."' ) > 0"
						 );

   }


/////////////////////////////////////////
// Вывод результатов

//	echo "[в скобках указана степень релевантности]";
if ($_SESSION[lang]!='/en')
	echo "<b>По Вашему запросу найдено:</b><br /><br />";
else
	echo "<b>Found:</b><br /><br />";
	
	$pg = new Pages();
	$pages_cont = array();

    $persons = new Persons();

    $personsArray = array();
    foreach ($pages_cont_res_p as $pers) {
        if(!$persons->isClosed($pers)) {
            $personsArray[] = $pers;
        }
    }

// Персоны 

        if ($all==1 || isset($_GET[person])) {

            
			if (count($personsArray) >0 && $_SESSION[lang]!='/en') echo "<br /><b>В разделе: ПЕРСОНАЛИИ </b><br /><br />";
			if (count($personsArray) >0 && $_SESSION[lang]=='/en') echo "<br /><b>In Section: PERSONS </b><br /><br />";

            foreach($personsArray as $pers){
                if($pers['second_profile']!=-1)
                    continue;
                if (!empty($pers[picsmall]))
                  echo "<img src='/dreamedit/foto/".$pers[picsmall]."' align='top' >";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID_A]."&id=".$pers[id]."'>".
                "<b>".$pers['surname']."&nbsp;".$pers[name]."&nbsp;".$pers[fname]."</b></a>";
                if($pers['otdel']==1239)
                    echo ' <b style="color: grey">('.$pers[rewards].')</b>';
                echo "<br />";

            }

//            print_r($us0);

        }
	// В объявлениях о защите
   if ($all==1 || $_GET[idiser]) {

    	$diser_cont_res = $DB->select(
	          "SELECT DISTINCT ic.el_id,ic2.icont_text AS dd,ic.icont_text AS fio,ic3.icont_text AS tema,
	           MATCH (ic2.icont_var,ic2.icont_text) AGAINST ('".$_REQUEST['search']."' ) AS relevantnost
	           FROM adm_ilines_content AS ic
	           INNER JOIN adm_ilines_element AS ie ON ie.el_id=ic.el_id AND ie.itype_id=6
	           INNER JOIN adm_ilines_content AS ic2 ON ic2.el_id=ic.el_id AND ic2.icont_var='date2'
	           INNER JOIN adm_ilines_content AS ic3 ON ic3.el_id=ic.el_id AND ic3.icont_var='prev_text'
	           INNER JOIN adm_ilines_content AS ic0 ON ic0.el_id=ic.el_id AND ic0.icont_var='status' AND ic0.icont_text=1
               WHERE (ic.icont_var='title' AND ic.icont_text like '%".$_REQUEST['search']."%' )".
			   " OR ".
			   " MATCH (ic2.icont_var,ic2.icont_text) AGAINST ('".$_REQUEST['search']."' ) > 1.5 ".
   	           " order by ic2.icont_text desc "
        );
          $s_doc=$s_doc+count($diser_cont_res);
   }	


	 echo "<ul>";
// участники
   if (count($rowsad)>0)
   {
      if ($_SESSION[lang]=='/en') echo "<br /><b>Your search yielded:</b>";
   }
   if ($_SESSION[lang]!='/en')
     foreach($rowsad as $ra)
	 {
        if ($ra[type]==100)  echo "<li><a href=/index.php?page_id=510><b>В составе АДМИНИСТРАЦИИ </b></a></li>";
        if ($ra[type]==200) echo "<li><a href=/index.php?page_id=511><b>В составе УЧЕНОГО СОВЕТА </b></a></li>";
        if ($ra[type]==300) echo "<li><a href=/index.php?page_id=1090><b>В составе ЭКСПЕРТОВ </b></a></li>";
		if ($ra[type]!=100 && $ra[type]!=200 && $ra[type]!=300) echo "<li><a href=/index.php?page_id=".$ra[page_id]."><b>В составе ".$ra[spisok]." </b></a></li>";
	}
   else
     foreach($rowsad as $ra)
	 {
        if ($ra[type]==100)  echo "<li><a href=/index.php?page_id=510><b>Direction </b></a></li>";
        if ($ra[type]==200) echo "<li><a href=/index.php?page_id=511><b>The Scientific Council </b></a></li>";
        if ($ra[type]==300) echo "<li><a href=/index.php?page_id=1090><b>Experts </b></a></li>";
		if ($ra[type]!=100 && $ra[type]!=200 && $ra[type]!=300) echo "<li><a href=/index.php?page_id=".$ra[page_id]."><b> ".$ra[spisok]." </b></a></li>";
	}   
	echo "</ul>";
	if (count($rowssem)>0)
	{
	   if ($_SESSION[lang]!='/en')
			echo "<br /><br /><b>Среди РУКОВОДИТЕЛЕЙ семинаров: </b>";
	   else	
			echo "<br /><br /><b>Seminar Leader: </b>";

	   echo "<ul>";
	   foreach ($rowssem as $rs)
   {
      if (!empty($rs[page_id]))
		echo "<li><a href=/index.php?page_id=".$rs[page_id].">".$rs[title]."</a></li>";  
		
   }
   echo "</ul>";
	}
/*        if ($all==1 || isset($_GET[members])) {            if (count($imem_cont_res) >0) echo "<br /><br /><b>Среди УЧАСТНИКОВ мероприятий </b><br /><br />";
           

            foreach($imem_cont_res as $pmem)
            {
        		 $maincontent = $pg->getContentByPageId($pmem[page_id]);
		         echo "<li><a href=/index.php?page_id=".$pmem[page_id].">".$maincontent['DATE']." ". $maincontent[TITLE]."</a></li>";
            }

        }
*/
		// Гранты
// Защиты
       if (count($diser_cont_res) >0) 
	   {
	      echo "<br /><b>В объявлениях о ЗАЩИТЕ ДИССЕРТАЦИЙ </b><br /><br />";
		  foreach($diser_cont_res AS $d)
		  {
		  
		  echo "<a href=/index.php?page_id=".$_TPL_REPLACMENT[DISER_ID]."&id=".$d[el_id].">".
		  substr($d[dd],8,2).".".substr($d[dd],5,2).".".substr($d[dd],0,4)." ".$d[fio]."</a>";
		    
		  }
	   
	   
	   
	   }

// Страницы
         if (count($rows) >0) echo "<br /><b>".$txtpage." </b><br />";

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

// Граныты
  if ($all==1 || $_GET[grant])
   {
   	  $where='';
        foreach($pages_cont_res_p as $pers)
        {
            $where.=" p.icont_text=".$pers[id]." OR ";
        }
        if (!empty($where)) $where=" OR (".substr($where,0,-4).")";
        else $where='';
   	  $grant0=$DB->select("SELECT c.el_id,c.icont_text AS title,su.icont_text AS source,
   	                       CONCAT(y1.icont_text,'-',y2.icont_text) AS year
   	                       FROM adm_nirs_content AS c
   	                       INNER JOIN adm_nirs_content AS p ON p.el_id=c.el_id AND p.icont_var='chif'
   	                       INNER JOIN adm_nirs_content AS ss ON ss.el_id=c.el_id AND ss.icont_var='source'
   	                       INNER JOIN adm_directories_content AS su ON su.el_id=ss.icont_text AND su.icont_var='text'
   	                       INNER JOIN adm_nirs_content AS y1 ON y1.el_id=c.el_id AND y1.icont_var='year_beg'
   	                       INNER JOIN adm_nirs_content AS y2 ON y2.el_id=c.el_id AND y2.icont_var='year_end'

   	                       WHERE c.icont_var='title' AND
   	                       ((c.icont_text LIKE '%".$_REQUEST[search]."%' OR MATCH (c.icont_var,c.icont_text) AGAINST ('".$_REQUEST['search']."'))".
   	                       $where.")");

if (count($grant0)>0)
{ 
 echo "<br /><br /><b>В темах НИР</b><br /><br />";

      foreach($grant0 as $grant)
      {
      	 echo "<li>".$grant['title'].
      	 "<br />".$grant['source']." ".$grant[year]." гг.".
      	 "</li>";

      }
    }
}
        
		
		if (count($rowsm) >0 && $_SESSION[lang] !="/en")echo "<br /><b>На СТРАНИЦАХ журналов: </b><br /><ul>";
		if (count($rowsm) >0 && $_SESSION[lang] =="/en")echo "<br /><b>In MAGAZINES INFO: </b><br /><ul>";
         
       foreach($rowsm As $rowm)
	        {
	                 echo "<li><a href=/index.php?page_id=".$rowm[page_id].">".$rowm[page_name]."</a></li>";
	        }
      if (count($rowsm) >0) echo "</ul>";


$mz0=new Magazine();

       foreach($jour0 as $jour)
     {
           foreach($pages_cont_res_p as $pers)
           {

//	           print_r($jour);
			   $art0=$mz0->getAuthorsArticleById($pers[id],$jour[jid]);

	           if (count($art0)>0)
	           {
	           echo "<br /><br /><b>Статьи автора в журналах:</b>";
               foreach($art0 as $row)
			{

			   $art0=$mz0->getArticleById($row[page_id]);

			   foreach($art0 as $art)
			   {

			   	  $nn=$mz0->getMagazineByArticleId($art[page_id]);

			      	   $people0=$mz0->getAutors($art[people]);
	                   echo "<li>";
			      	   foreach($people0 as $people)
			      	   {
			      	      echo $people[fio]." "; //.$people[work].",".$people[mail1]."";
			      	   }

			      	   echo "<a href=/index.php?page_id=".$jour[article_id]."&id=".$art[page_id]."&at=a&pid=".$people[id].">".$art[name].
			      	        " // ".$jour[page_name].". № ".$nn[0][page_name]." ".$nn[0][year].". C".$art[pages];
			      	   echo "</a></li>";

			   }
			   }
			}
         }
      }
         if ($_SESSION[lang]!="/en")
		 $jour_art0=$DB->select("SELECT DISTINCT p2.cv_text AS page,a.page_id,
         IF(a.page_template='jrubric',CONCAT('РУБРИКА: ',a.page_name),a.page_name) AS page_name,a.jid,a.name,
         a.j_name,a.number,a.year,a.pages,a.journal
                  FROM adm_article AS a

         INNER JOIN adm_pages_content AS p1 ON p1.cv_name='ITYPE_JOUR' AND p1.cv_text=a.journal
         INNER JOIN adm_pages_content AS p2 ON p2.page_id=p1.page_id AND
         ((p2.cv_name='rubric_id' AND a.page_template='jrubric') OR (p2.cv_name='article_id' AND a.page_template='jarticle'))
         WHERE a.date_public<>'' AND (a.page_name LIKE '%".$_REQUEST['search']."%' OR ".
         " MATCH (`name`,`annots`,`keyword`,`contents`) AGAINST ('".str_replace('ё','е',$_REQUEST['search'])."' )) AND  a.name<>''");
         
		 else
		  $jour_art0=$DB->select("SELECT DISTINCT p2.cv_text AS page,a.page_id,
         IF(a.page_template='jrubric',CONCAT('RUBRIC: ',a.page_name),a.page_name) AS page_name,a.jid,a.name,
         a.j_name,a.number,a.year,a.pages,a.journal
                  FROM adm_article AS a

         INNER JOIN adm_pages_content AS p1 ON p1.cv_name='ITYPE_JOUR' AND p1.cv_text=a.journal
         INNER JOIN adm_pages_content AS p2 ON p2.page_id=p1.page_id AND
         ((p2.cv_name='rubric_id' AND a.page_template='jrubric') OR (p2.cv_name='article_id' AND a.page_template='jarticle'))
         WHERE a.date_public<>'' AND (a.page_name LIKE '%".$_REQUEST['search']."%' OR ".
         " MATCH (`name_en`,`annots_en`,`keyword_en`) AGAINST ('".str_replace('ё','е',$_REQUEST['search'])."' )) AND a.name<>'' ");
      
		 if (count($jour_art0)>0)
		 {
			if ($_SESSION[lang]!='/en')
			echo "<b>Статьи в журналах:</b>";
			else
			echo "<b>Articles in Magazines:</b>";
		 
		 echo "<ul>";
		 
		 foreach($jour_art0 as $ja)
         {
			  $temp_journ_name=$DB->select("SELECT bb.page_journame
				FROM adm_magazine AS bb
				WHERE bb.page_id=".$ja[journal]."
				LIMIT 1");
				if (count($temp_journ_name)>0)
				{
					foreach($temp_journ_name as $tjn)
					{
						echo "<li><a href=/jour/".$tjn[page_journame]."/index.php?page_id=".$ja[page]."&id=".$ja[page_id]."&jid=".$ja[jid].">".$ja['name'].
         	  " // ".$ja[j_name].". № ".$ja[number]." ".$ja[year].". C".$ja[pages]."</a></li>";
					}
				}
				else
			  echo "<li><a href=/index.php?page_id=".$ja[page]."&id=".$ja[page_id]."&jid=".$ja[jid].">".$ja['name'].
         	  " // ".$ja[j_name].". № ".$ja[number]." ".$ja[year].". C".$ja[pages]."</a></li>";
         }
         echo "</ul>";
        }


if ($all==1 || isset($_GET[publs])) {
                      $ind_p=false;

if ($pages_cont_res_n)
{      
	  if ($_SESSION[lang]!='/en')
		echo "<br /><br /><b>В разделе: ПУБЛИКАЦИИ</b><br />";
	  else	
	  echo "<br /><br /><b>In Section: PUBLICATIONS</b><br />";
      echo "<ul>";
  /*
                       foreach($pages_cont_res_a as $pers){

                           echo  "<li><a href='/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID_P]."&id=".$pers[id]."'>".
                           strip_tags($pers[name]).strip_tags($pers[name2])."</a></li>";

                       }
  */
$matches[] ="";
                      foreach($pages_cont_res_n as $pers){

                           echo  "<li><a href='/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID_P]."&id=".$pers[id]."'>".
                           strip_tags($pers[name]).strip_tags($pers[name2])."</a></li>";
							$matches[]=$pers[id];
                       }
                        foreach($pages_cont_res_a as $pers){
							if(!in_array($pers[id],$matches))
                           echo  "<li><a href='/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID_P]."&id=".$pers[id]."'>".
                           strip_tags($pers[name]).strip_tags($pers[name2])."</a></li>";

                       }
					   
echo "</ul>";
					   }

		            }

///Инфоленты


        if ($all==1 || isset($_GET[ilines])) {


             if (count($lines_cont_res) >0)
             echo "<br /><b>В разделе: НОВОСТИ </b><br /><br />";

           foreach($lines_cont_res as $li){

               if ($li[itype_id]==2) $page_n = $_TPL_REPLACMENT[NEWS_NAME];
    	       if ($li[itype_id]==3) $page_n = $_TPL_REPLACMENT[SMI_NAME];
    	       if ($li[itype_id]==2) $page_n = $_TPL_REPLACMENT[NEWS_ID];
    	       if ($li[itype_id]==3) $page_n = $_TPL_REPLACMENT[SMI_ID];
               if ($li[itype_id]==14) $page_n = 568;
			   $page_n=$_TPL_REPLACMENT[NEWS_ID];
               $date_news= substr($li[dd],8,2).".".substr($li[dd],5,2).".".substr($li[dd],0,4)." г.";
	           echo "<li><a href=/index.php?page_id=".$page_n."&id=".$li[el_id].">".$date_news." ".$li[icont_text]."</a></li>";

            }

        }


echo "</ol>";
//echo "<br /><br />Если Вы не смогли найти то, что хотели, попробуйте поискать на нашем сайте с помощью Яндекса.<br /><br />";

} // Не пустой поиск
?>


</div>

<?
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>