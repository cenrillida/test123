<?
/////////////////////////

// Все, что связано с персоной. id персоны

// $_GET[idp] - id персоны
global $DB, $_CONFIG, $site_templater;

$pid = $_REQUEST["pid"];
$pid =(int)$DB->cleanuserinput($pid );

$ps = new Persons();
$isClosed = false;
if(!empty($pid)) {
    $persons=$ps->getPersonsById($pid);

    if(!empty($persons)) {
        $isClosed = $ps->isClosed($persons[0]);
    }
}

if($isClosed) {
    Dreamedit::sendHeaderByCode(301);
    Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/404");
    exit;
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
$ilines = new Ilines();
$mz0=new Magazine();
$mzNew = new MagazineNew();
$yearPostfix = "";
if($_SESSION['lang']!="/en") {
    $yearPostfix = " г.";
}
?>
	<div class="content">
	<h1><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h1>
<?


  $pg=new Pages();

        $all =0;
        if (!(isset($_GET["pages"]) || isset($_GET["person"]) || isset($_GET["publ"]) || isset($_GET["ilines"]) || isset($_GET["idiser"]) || isset($_GET["iabstract"]) || isset($_GET["ibank"])))
        $all = 1;


        $s_doc=0; // Всего найденных страниц

 
if(!empty($pid))
{
  $ind_p=true;
  $second_profiles = $DB->select("SELECT id,CONCAT(surname,' ',name,' ',fname) AS fio,LastName_EN AS f_lastname_en FROM persons WHERE second_profile=".$pid);
	
if ($_SESSION["lang"]!='/en')   
	$sfio0=$DB->select("SELECT CONCAT(surname,' ',name,' ',fname) AS fio,
	                   CONCAT(surname,' ',substring(name,1,1),'.',
					   IF(fname<>'',CONCAT(substring(fname,1,1),'.'),'')) AS fioshort,picsmall,
	                   otdel,IF(o.page_status<>0,o.page_name,'') AS otdel_name,full

	                   FROM persons
	                   INNER JOIN adm_pages AS o ON o.page_id=persons.otdel
	                   WHERE id='".$pid."'" );
else
		$sfio0=$DB->select("SELECT Autor_en AS fio,
	                   Autor_en AS fioshort,picsmall,
	                   otdel,IF(o.page_status<>0,o.page_name_en,'') AS otdel_name,full

	                   FROM persons
	                   INNER JOIN adm_pages AS o ON o.page_id=persons.otdel
	                   WHERE id='".$pid."'" );			   
//print_r($sfio0);
					   $sfio=$sfio0[0]["fio"];
	$sfioshort=$sfio0[0]["fioshort"];
	if (!empty($sfio0[0]["otdel_name"])) $s_doc+=1;
// print_r($sfio0);
//	echo "<br />_______".$_TPL_REPLACMENT[SOCIS_SPISOK];
///////////////////////////////////
  if ($all==1 || isset($_GET["publ"])) {
  	     $mz = new Magazines();
         $spisok=$_TPL_REPLACMENT["SOCIS_SPISOK"].",". $_TPL_REPLACMENT["POLIS_SPISOK"].",".$_TPL_REPLACMENT["SOCIOLOGY_SPISOK"].",".
         $_TPL_REPLACMENT["AUTHORITY_SPISOK"].",".$_TPL_REPLACMENT["M4_SPISOK"].",".$_TPL_REPLACMENT["HISTORY_SPISOK"];
	     
		 if (!empty($spisok) && $spisok != ',,,,,')
			$publ0=$mz->getPublicationsByFioId($pid,$spisok,'0',$_TPL_REPLACMENT["FULL_ID_P"],$_TPL_REPLACMENT["FULL_ID_A"]);

	   	     $s_doc=$s_doc+count($publ0);
        }
//PRINT_R($publ0);
// На страницах сайта
//echo "<br />____".$_TPL_REPLACMENT["PERSONA_PAGE"];
 if ($all==1  || isset($_GET["pages"])) {

	$rows =  $DB->select(
		"SELECT DISTINCT ".
		    " 'pg' AS type,".
		    " p2.page_name, p2.page_id,p2.page_name_en,".
		     "p0.page_id AS id,p2.page_parent ".

		"FROM  adm_pages_content AS p0".
		" LEFT OUTER JOIN adm_pages_content AS ip ON ip.page_id=p0.page_id AND ip.cv_name=  'people' ".
		" INNER JOIN adm_pages AS p2 ON p2.page_id=p0.page_id AND page_status  = 1 ".

			"AND page_link = '' ".
			"AND page_parent <> '".$_TPL_REPLACMENT['FULL_ID_D']."'" .
			       " AND page_parent<>'12'".


		"WHERE  ".
            "p0.cv_name='content' AND  ".
            " (p0.cv_text  LIKE '%?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid."\">%' OR
	      p0.cv_text LIKE '%?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid."\">%'  OR
	      p0.cv_text  LIKE '%?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">%' OR
	      p0.cv_text LIKE '%?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid.">%' ".
	      "  OR ip.cv_text LIKE '".$pid."<br>%' OR ip.cv_text LIKE '%<br>".$pid."<br>%')    ");
      $rowsm=$DB->select(
        " SELECT DISTINCT 'mz' AS type, m2.page_name,m2.page_name_en,mmm.page_name AS journal_name,mmm.page_name_en AS journal_name_en,
		IF(m0.cv_name='content',m2.page_id,m2.page_parent) AS page_id,
        IF(m2.page_template='jnumber',m2.page_id,m2.page_parent) AS page_parent,page.page_id AS page ".
        " FROM adm_magazine AS m2 ".
        " LEFT OUTER JOIN adm_pages_content AS ip ON ip.page_id=m2.page_id AND ip.cv_name=  'people' ".
        " LEFT OUTER JOIN adm_magazine_content AS m0 ON m0.page_id=m2.page_id
        INNER JOIN adm_pages_content AS page ON page.cv_name='ITYPE_JOUR' AND (page.cv_text=m2.page_id OR page.cv_text=m2.page_parent)
        INNER JOIN adm_magazine AS mmm ON mmm.page_id=m2.page_parent 
		INNER JOIN adm_pages AS page0 ON page0.page_id=page.page_id AND page0.page_template='magazine'
        WHERE m2.page_status=1 AND ".
        "(m0.cv_name='content' OR m0.cv_name='reclama') AND  ".
            " (m0.cv_text  LIKE '%?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid."\">%' OR
	      m0.cv_text LIKE '%?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid."\">%'  OR
	      m0.cv_text  LIKE '%?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">%' OR
	      m0.cv_text LIKE '%?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid.">%' ".
	      "  OR ip.cv_text LIKE '".$pid."<br>%' OR ip.cv_text LIKE '%<br>".$pid."<br>%')    "
	);


	 $s_doc=$s_doc + count($rows)+ count($rowsm);
	 $adm0=$DB->select("SELECT a.id,a.type,p.page_id,p.page_name,p.page_name_en
				FROM Admin AS a 
				INNER JOIN adm_pages AS p ON p.page_template='spisok'
				INNER JOIN adm_pages_content AS pp ON pp.page_id=p.page_id AND cv_name='TYPES' AND cv_text=a.type 
	            WHERE persona=".$pid." AND p.page_status=1".
				" ORDER BY a.type"
				
				);
	 $s_doc+=count($adm0);

//	 $su0=$DB->select("SELECT count(id) AS count FROM Sovet WHERE persona=".$pid);
//	 $s_doc+=$su0[0]['count'];
}
   // поиск статей в журналах
   if ($all==1 || $_GET["publ"])
   {
   	 $jour0=$DB->select("SELECT p.page_name,p.page_name_en,pc.cv_text AS journal,pa.cv_text AS article_id FROM adm_pages AS p
   	                     INNER JOIN adm_pages_content AS pc ON pc.page_id=p.page_id AND pc.cv_name='ITYPE_JOUR'
   	                     INNER JOIN adm_pages_content AS pa ON pa.page_id=p.page_id AND pa.cv_name='ARTICLE_ID'
   	                     WHERE p.page_template='magazine' AND p.page_status=1");

   }
// Пoлиск в публикациях в СМИ
   if ($all==1 || $_GET["ismi"])
   {
       $additional_smi_sp = "";
       if(!empty($second_profiles)) {
           $additional_smi_sp = " OR (ic2.icont_text LIKE '".$second_profiles[0]["id"]."<br>%' OR ic2.icont_text LIKE '%<br>".$second_profiles[0]["id"]."<br>%') OR 
							 (pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$second_profiles[0]["id"].">%' OR
           pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$second_profiles[0]["id"].">%' OR ".
	      " pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$second_profiles[0]["id"]."\">%' OR
           pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$second_profiles[0]["id"]."\">%')";
       }
  if($_SESSION['lang']!="/en")
	 $smi_cont_res=$DB->select(
                    "SELECT ic.el_id,ic.icont_text AS title,ic3.icont_text AS date FROM adm_ilines_content AS ic
                       INNER JOIN adm_ilines_content AS ic2 ON ic2.el_id=ic.el_id AND ic2.icont_var='people'
                       INNER JOIN adm_ilines_content AS ic3 ON ic3.el_id=ic.el_id AND ic3.icont_var='date'
					   INNER JOIN adm_ilines_content AS pt ON pt.el_id=ic.el_id AND pt.icont_var='prev_text'
                       INNER JOIN adm_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' AND ss.icont_text=1
                       INNER JOIN adm_ilines_element AS ie ON ie.el_id=ic.el_id AND ie.itype_id=5
                       WHERE ic.icont_var='title' AND (
                            (ic2.icont_text LIKE '".$pid."<br>%' OR ic2.icont_text LIKE '%<br>".$pid."<br>%') OR 
							 (pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">%' OR
	      pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid.">%' OR ".
	      " pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid."\">%' OR
	      pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid."\">%')".$additional_smi_sp.") ".
                     "  ORDER BY ic3.icont_text DESC
                            ");
	else
	  $smi_cont_res=$DB->select(
                    "SELECT ic.el_id,ic.icont_text AS title,ic3.icont_text AS date FROM adm_ilines_content AS ic
                       INNER JOIN adm_ilines_content AS ic2 ON ic2.el_id=ic.el_id AND ic2.icont_var='people'
                       INNER JOIN adm_ilines_content AS ic3 ON ic3.el_id=ic.el_id AND ic3.icont_var='date'
					   INNER JOIN adm_ilines_content AS pt ON pt.el_id=ic.el_id AND pt.icont_var='prev_text_en'
                       INNER JOIN adm_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' AND ss.icont_text=1
                       INNER JOIN adm_ilines_element AS ie ON ie.el_id=ic.el_id AND ie.itype_id=5
                       WHERE ic.icont_var='title_en' AND ic.icont_text<>'' AND (
                            (ic2.icont_text LIKE '".$pid."<br>%' OR ic2.icont_text LIKE '%<br>".$pid."<br>%') OR 
							 (pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">%' OR
	      pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid.">%' OR ".
	      " pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid."\">%' OR
	      pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid."\">%')".$additional_smi_sp.") ".
                     "  ORDER BY ic3.icont_text DESC
                            ");
       $s_doc=$s_doc+count($smi_cont_res);
    }

   //podcasts

    if ($all==1 || $_GET["ismi"])
    {
        $additional_podcasts_sp = "";
        if(!empty($second_profiles)) {
            $additional_podcasts_sp = " OR (ic2.icont_text LIKE '".$second_profiles[0]["id"]."<br>%' OR ic2.icont_text LIKE '%<br>".$second_profiles[0]["id"]."<br>%') OR 
							 (pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$second_profiles[0]["id"].">%' OR
           pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$second_profiles[0]["id"].">%' OR ".
                " pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$second_profiles[0]["id"]."\">%' OR
           pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$second_profiles[0]["id"]."\">%')";
        }
        if(!isset($_REQUEST["en"]))
            $podcasts_cont_res=$DB->select(
                "SELECT ic.el_id,ic.icont_text AS title,ic3.icont_text AS date FROM adm_ilines_content AS ic
                       INNER JOIN adm_ilines_content AS ic2 ON ic2.el_id=ic.el_id AND ic2.icont_var='people'
                       INNER JOIN adm_ilines_content AS ic3 ON ic3.el_id=ic.el_id AND ic3.icont_var='date'
					   INNER JOIN adm_ilines_content AS pt ON pt.el_id=ic.el_id AND pt.icont_var='prev_text'
                       INNER JOIN adm_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' AND ss.icont_text=1
                       INNER JOIN adm_ilines_element AS ie ON ie.el_id=ic.el_id AND ie.itype_id=62
                       WHERE ic.icont_var='title' AND (
                            (ic2.icont_text LIKE '".$pid."<br>%' OR ic2.icont_text LIKE '%<br>".$pid."<br>%') OR 
							 (pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">%' OR
	      pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid.">%' OR ".
                " pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid."\">%' OR
	      pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid."\">%')".$additional_podcasts_sp.") ".
                "  ORDER BY ic3.icont_text DESC
                            ");
        else
            $podcasts_cont_res=$DB->select(
                "SELECT ic.el_id,ic.icont_text AS title,ic3.icont_text AS date FROM adm_ilines_content AS ic
                       INNER JOIN adm_ilines_content AS ic2 ON ic2.el_id=ic.el_id AND ic2.icont_var='people'
                       INNER JOIN adm_ilines_content AS ic3 ON ic3.el_id=ic.el_id AND ic3.icont_var='date'
					   INNER JOIN adm_ilines_content AS pt ON pt.el_id=ic.el_id AND pt.icont_var='prev_text_en'
                       INNER JOIN adm_ilines_content AS ss ON ss.el_id=ic.el_id AND ss.icont_var='status' AND ss.icont_text=1
                       INNER JOIN adm_ilines_element AS ie ON ie.el_id=ic.el_id AND ie.itype_id=62
                       WHERE ic.icont_var='title_en' AND (
                            (ic2.icont_text LIKE '".$pid."<br>%' OR ic2.icont_text LIKE '%<br>".$pid."<br>%') OR 
							 (pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">%' OR
	      pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid.">%' OR ".
                " pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid."\">%' OR
	      pt.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid."\">%')".$additional_podcasts_sp.") ".
                "  ORDER BY ic3.icont_text DESC
                            ");
        $s_doc=$s_doc+count($podcasts_cont_res);
    }

// В новостях
     if ($all==1 || $_GET["ilines"]) {
         $additional_news_sp = "";
         if(!empty($second_profiles)) {
             $additional_news_sp = " OR ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$second_profiles[0]["id"].">%' OR
	      ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$second_profiles[0]["id"].">%' OR ".
                 " ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$second_profiles[0]["id"]."\">%' OR
	      ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$second_profiles[0]["id"]."\">%' ".

                 " OR ip.icont_text LIKE '".$second_profiles[0]["id"]."<br>%' OR ip.icont_text LIKE '%<br>".$second_profiles[0]["id"]."<br>%'";
         }
if(!isset($_REQUEST["en"])) 
	$lines_cont_res = $DB->select(
	  "SELECT  DISTINCT ic.el_id,ic2.icont_text AS dd,ic.icont_text,ie.itype_id,it.itype_name, it.itype_name_en

	  FROM adm_ilines_content AS ic
	  INNER JOIN adm_ilines_content AS ic2 on ic.el_id=ic2.el_id AND ic2.icont_var='date'
	  INNER JOIN adm_ilines_content AS ic3 on ic.el_id=ic3.el_id AND (ic3.icont_var='prev_text' OR ic3.icont_var='full_text') ".

	 " INNER JOIN  adm_ilines_content AS ic4 on ic.el_id=ic4.el_id  AND ic4.icont_var='status' AND ic4.icont_text=1
	   INNER JOIN adm_ilines_element AS ie ON ic.el_id = ie.el_id
	   LEFT OUTER JOIN adm_ilines_content AS ip ON ic.el_id = ip.el_id AND ip.icont_var='people'
	   INNER JOIN adm_ilines_type AS it ON ie.itype_id=it.itype_id AND (it.itype_id=1 OR it.itype_id=3 OR it.itype_id=4)
	   WHERE ic.icont_var='title' ".
	   " AND (ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">%' OR
	      ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid.">%' OR ".
	      " ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid."\">%' OR
	      ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid."\">%' ".

	      " OR ip.icont_text LIKE '".$pid."<br>%' OR ip.icont_text LIKE '%<br>".$pid."<br>%'".$additional_news_sp.")".
	  " ORDER BY it.itype_name,ic2.icont_text desc "
	);
else
$lines_cont_res = $DB->select(
	  "SELECT  DISTINCT ic.el_id,ic2.icont_text AS dd,ic.icont_text,ie.itype_id,it.itype_name,it.itype_name_en

	  FROM adm_ilines_content AS ic
	  INNER JOIN adm_ilines_content AS ic2 on ic.el_id=ic2.el_id AND ic2.icont_var='date'
	  INNER JOIN adm_ilines_content AS ic3 on ic.el_id=ic3.el_id AND (ic3.icont_var='prev_text_en' OR ic3.icont_var='full_text_en') ".

	 " INNER JOIN  adm_ilines_content AS ic4 on ic.el_id=ic4.el_id  AND ic4.icont_var='status' 
	   LEFT JOIN  adm_ilines_content AS ic4e on ic.el_id=ic4e.el_id  AND ic4e.icont_var='status_en'
	   INNER JOIN adm_ilines_element AS ie ON ic.el_id = ie.el_id
	   LEFT OUTER JOIN adm_ilines_content AS ip ON ic.el_id = ip.el_id AND ip.icont_var='people'
	   INNER JOIN adm_ilines_type AS it ON ie.itype_id=it.itype_id AND (it.itype_id=1 OR it.itype_id=3 OR it.itype_id=4)
	   WHERE ic.icont_var='title_en' AND ic.icont_text<>'' AND (ic4.icont_text=1 OR ic4e.icont_text=1) ".
	   " AND (ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">%' OR
	      ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid.">%' OR ".
	      " ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid."\">%' OR
	      ic3.icont_text LIKE '%/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&amp;id=".$pid."\">%' ".

	      " OR ip.icont_text LIKE '".$pid."<br>%' OR ip.icont_text LIKE '%<br>".$pid."<br>%'".$additional_news_sp.")".
	  " ORDER BY it.itype_name,ic2.icont_text desc "
	);
          $s_doc=$s_doc+count($lines_cont_res);

}

    $additional_grant_sp = "";
    if(!empty($second_profiles)) {
        $additional_grant_sp= " OR c1.icont_text=".$second_profiles[0]["id"];
    }

 // В грантах
     $grant_cont_res=$DB->select("SELECT c.el_id,c.icont_text AS title,CONCAT(y1.icont_text,'-',y2.icont_text) AS year
            	FROM adm_nirs_content AS c
            	INNER JOIN adm_nirs_content AS c1 ON c1.el_id=c.el_id AND c1.icont_var='chif'
            	INNER JOIN adm_nirs_content AS y1 ON y1.el_id=c.el_id AND y1.icont_var='year_beg'
            	INNER JOIN adm_nirs_content AS y2 ON y2.el_id=c.el_id AND y2.icont_var='year_end'

            	INNER JOIN adm_nirs_content AS s ON s.el_id=c.el_id AND s.icont_var='status' AND s.icont_text=1
          		WHERE c.icont_var='title' AND c1.icont_text = ".$pid.$additional_grant_sp);
//print_r($grant_cont_res);
// В объявлениях о защите
   if ($all==1 || $_GET["idiser"]) {
       $additional_works_sp = "(ic.icont_text like '%".$sfio."%'";
       if(!empty($second_profiles)) {
           $additional_works_sp.= " OR ic.icont_text like '%".$second_profiles[0]["fio"]."%')";
       }
       else
           $additional_works_sp.=")";

    	$diser_cont_res = $DB->select(
	          "SELECT DISTINCT ic.el_id,ic2.icont_text AS dd,ic.icont_text AS fio,ic3.icont_text AS tema

	           FROM adm_ilines_content AS ic
	           INNER JOIN adm_ilines_element AS ie ON ie.el_id=ic.el_id AND ie.itype_id=6
	           INNER JOIN adm_ilines_content AS ic2 ON ic2.el_id=ic.el_id AND ic2.icont_var='date2'
	           INNER JOIN adm_ilines_content AS ic3 ON ic3.el_id=ic.el_id AND ic3.icont_var='prev_text'
	           INNER JOIN adm_ilines_content AS ic0 ON ic0.el_id=ic.el_id AND ic0.icont_var='status' AND ic0.icont_text=1
               WHERE ic.icont_var='fio' AND ".$additional_works_sp." ".
   	           " order by ic2.icont_text desc "
        );
          $s_doc=$s_doc+count($diser_cont_res);

  }


/////////////////////////////////////////
// Вывод результатов
if (!isset($_REQUEST["en"])) $suff='';else $suff="_en";
    if($sfio0[0]["full".$sull]==1) $fioprint=$sfio0[0]["fio".$suff]; else $fioprint=$sfioshort;
    if(!empty($second_profiles) && $_SESSION["lang"]!='/en')
        $fioprint=$second_profiles[0]["fio"];
    if (!empty($sfio0[0]["picsmall"]))
	  echo "<br /><img  alt='".$fioprint."' title='".$fioprint."' src=/dreamedit/foto/".$sfio0[0]["picsmall"]." align='absBottom' hspace='10' /><font size='4'>
	  <b><a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">".$fioprint."</a></b></font>";
    else
	  echo "<br /><font size='4'><b><a href=/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$pid.">".$fioprint."</a></b></font>";

   if ($_SESSION["lang"]=='/en') echo  "<br /><br /><b>Your search yielded:</b>";
   
	else  echo "<br /><br /><b>По Вашему запросу найдено:</b> ";

	$pg = new Pages();
	$pages_cont = array();

             echo "<ul>";

     // На страницах
// Страницы
if (!isset($_REQUEST["en"]))
{
	$admtext="В составе Дирекции";
	$sovtext="В составе Ученого совета";
}
else
{
    $admtext="Direction";
	$sovtext="The Scientific Council";
}
        if (count($adm0) >0)
        {
           $aa=true;
		   foreach($adm0 as $a)
		   {
		   		   if ($_SESSION["lang"]!='/en')
				   {
					   if ($a['type']=='100')
							echo "<li><a href=/index.php?page_id=".$a["page_id"].">".$admtext."</a></li>";
					   if ($a['type']=='200')
							echo "<li><a href=/index.php?page_id=".$a["page_id"].">".$sovtext."</a></li>";
					   if ($a['type']!='100' && $a['type']!='200')
					   {
					   
						echo "<li><a href=/index.php?page_id=".$a["page_id"].">".$a['page_name'.$suff]."</a></li>";
					   }    
				   }
				   else
				   {
					   if ($a['type']=='100')
							echo "<li><a href=/en/index.php?page_id=".$a["page_id"].">".$admtext."</a></li>";
					   if ($a['type']=='200')
							echo "<li><a href=/en/index.php?page_id=".$a["page_id"].">".$sovtext."</a></li>";
					   if ($a['type']!='100' && $a['type']!='200')
					   {
					   
						echo "<li><a href=/en/index.php?page_id=".$a["page_id"].">".$a['page_name'.$suff]."</a></li>";
					   }  
				   }
		   }		   
        }

        if (!empty($sfio0[0]['otdel_name']))
        {
		
			if ($_SESSION["lang"]!='/en')
           echo "<li>На странице подразделения: <a href=/index.php?page_id=".$sfio0[0]["otdel"].">".$sfio0[0]["otdel_name"]."</a></li>";
		   else
		   echo "<li>On subdivision's page: <a href=/en/index.php?page_id=".$sfio0[0]["otdel"].">".$sfio0[0]["otdel_name"]."</a></li>";
        }

    if ($_SESSION["lang"]!='/en')
        echo "<div class='mt-3'><b>В разделах сайта:</b></div>";
    else
        echo "<div class='mt-3'><b>In sections:</b></div>";

        if (count($rows) > 0) {
           $j=0;
	      foreach($rows as $k => $v)
	      {
	     //	print_r($rows);
			$aa=$pg->getParents($v["page_id"]);
     		$i=0;
    		foreach($aa as $k=>$razdel_name)
    		{
    		    if ($_SESSION["lang"]=="/en") 
				{
					$razdel_name["page_name"]=$razdel_name["page_name_en"];
					
				}	
				if($i == 2  || ($i==1 && $razdel_name["page_id"]<>2 && $razdel_name["page_id"]<>440 )) {
                  if ($razdel_name["page_position"]>0)
                     $parent00 =sprintf("[%010s]",$razdel_name["page_position"])."#".$razdel_name["page_name"];
	        	  else
	        	     $parent00 =sprintf("[%010s]",($razdel_name["page_position"]+9999))."#".$razdel_name["page_name"];

	        	    break;
           	    }
		    $i++;

    		}
    		$parent[$j]=array("parent00"=>$parent00,array_values($v));
                $j++;

           }

// Надо сортироваться


	        asort($parent);
//print_r($parent);
            $tparent="";
            $ind_grant=true;
            $parold='';
			 foreach($parent as $k =>$v){

                if ($parold!=$v["parent00"])
                {
                	$aaa= substr($v["parent00"],(strpos($v["parent00"],'#')+1));
					if ($_SESSION["lang"]=="/en" && !empty($aaa)) echo "<br /><br /><b>";
					if ($_SESSION["lang"]!="/en") echo "<br /><br /><b>";
                	echo mb_strtoupper(substr($v["parent00"],(strpos($v["parent00"],'#')+1)),'cp1251')."</b><br />";
                	$parold=$v["parent00"];
                }
				if  ($_SESSION["lang"]=="/en" && !empty($v[0][3])) echo "<li><a href=/en/index.php?page_id=".$v[0][2].">".$v[0][3]."</a></li>";
                if  ($_SESSION["lang"]!="/en") echo "<li><a href=/index.php?page_id=".$v[0][2].">".$v[0][1]."</a></li>";
          }
        }
        if (count($rowsm)>0) {
		if ($_SESSION["lang"]=='/en') echo "<br /><br /><b>In Information about the journals:</b>";
        else echo "<br /><br /><b>На страницах журналов:</b>";
	        foreach($rowsm As $rowm)
	        {
	
				   if ($_SESSION["lang"]=="/en") 
				   {
						$rowm["journal_name"]=$rowm["journal_name_en"];
						$rowm["page_name"]=$rowm["page_name_en"];
				   }				
				   echo "<li><a href=".$_SESSION["lang"]."/index.php?page_id=".$rowm["page"].">".$rowm["journal_name"].". ".$rowm["page_name"]."</a></li>";
	        }

        }

        //Новости

        if ($all==1 || isset($_GET["ilines"])) {


             if (count($lines_cont_res) >0)
			 if ($_SESSION["lang"]=='/en') echo "<br /><br /><b>NEWS </b><br />";
             else echo "<br /><br /><b>НОВОСТИ </b><br />";

            $year=0;
		   $iname="";
           foreach($lines_cont_res as $li){
			if ($_SESSION["lang"]=='/en') $li["itype_name"]=$li["itype_name_en"];

               if ($iname!=$li["itype_name"])
			   {
                   $text_head_search = $li["itype_name"];
                   $text_head_search = str_replace("Новости института","Новости и события",$text_head_search);
                   $text_head_search = str_replace("Объявления о мероприятиях","Мероприятия Института",$text_head_search);
			      if (!empty($li["icont_text"]))
				  echo "<div class='mt-3'><b>".$text_head_search."</b></div>";
				  $iname=$li["itype_name"];
                    $year=0;
			   }
               if ($li["itype_id"]==1) $page_n = 502;
               if ($li["itype_id"]==3) $page_n = 1594;
    	       if ($li["itype_id"]==5) $page_n = 502;
    	       if ($li["itype_id"]==4) $page_n = $_TPL_REPLACMENT["NEWS_ID"];
			   if ($li["itype_id"]==6) $page_n = 502;
    	      
               if ($li["itype_id"]==14) $page_n = 568;
			   //$page_n=$_TPL_REPLACMENT["NEWS_ID"];
			   if (empty($page_n)) $page_n=502;

               if ($year!= substr($li['dd'],0,4))
               {
                   echo "<br /><div style='margin-left:0px;'><b>".substr($li['dd'],0,4)."</div></b>";
                   $year=substr($li['dd'],0,4);
               }
   /*            if ($year!=substr($li[dd],0,4))
               {
               	  echo "<br /><div style='margin-left:0px;'><b>".substr($li[dd],0,4)."</b></div>";
               	  $year=substr($li[dd],0,4);
               }
   */
               if (!empty($li["icont_text"]))
			   {
				   $date_news= substr($li["dd"],8,2).".".substr($li["dd"],5,2).".".substr($li["dd"],0,4).$yearPostfix;
				   echo "<li><a href=".$_SESSION["lang"]."/index.php?page_id=".$page_n."&id=".$li["el_id"].">".$date_news." ".$li["icont_text"]."</a></li>";
			   }
            }

        }

// Гранты



         if (count($grant_cont_res)>0)
             {
				 if ($_SESSION["lang"]!="/en")
					echo "<br /><br /><b>Руководитель проектов:</b>";
				 else
					echo "<br /><br /><b>Project Manager:</b>";
                 $type='';
                 $year=0;
                 foreach($grant_cont_res as $grant)
                 {

//                   if ($type!=$grant['type'])
//                   {
//                   	  echo "<br /><div style='margin-left:0px;'><b>".$grant['type']."</b></div>";
//                   	  $year=0;
//                   	  $type=$grant['type'];
//                   }

//                   echo "<li>".$grant['type']."<br />".

					$grant_type=$DB->select("SELECT itype_id FROM adm_nirs_element WHERE el_id=".$grant["el_id"]." LIMIT 1");
					$grant_year=$DB->select("SELECT icont_text FROM adm_nirs_content WHERE el_id=".$grant["el_id"]." AND icont_var='year_end' LIMIT 1");
					if($grant_year[0]['icont_text'] > date('Y'))
						{
						$grant_year_T=date('Y');
						}
						else
						{
						$grant_year_T=$grant_year[0]['icont_text'];
						}
					$link_page=0;
					if($grant_type[0]['itype_id'] == 2)
						$link_page=735;
					if($grant_type[0]['itype_id'] == 6)
						$link_page=967;
					if($grant_type[0]['itype_id'] == 5)
						$link_page=845;
					if($grant_type[0]['itype_id'] == 3)
						$link_page=1003;
						
               echo "<li>".
     "<a href=".$_SESSION["lang"]."/index.php?page_id=".$link_page."&year=".$grant_year_T.">".$grant['title'].
                         " (".$grant["year"].")"."</a>"."</li>";
                  }

             }
//Публикации
        if ($all==1 || isset($_GET["publ"])) {
         if (count($publ0) >0)
         {
          echo "<br /><br /><div style='width:100%;background-color:#efefef;margin-left:0px;'><br />&nbsp;&nbsp;&nbsp;<b>ПУБЛИКАЦИИ</b><br /><br /></div>";

             $year0=0;
             foreach($publ0 as $publ)
             {
 //            echo "<br />__"; print_r($publ);
             	if ($year!=$publ["year"])
             	{
             		echo "<br /><div style='margin-left:0px;'><b>".$publ["year"]."</b></div>";
             		$year=$publ["year"];
             	}
                echo "<li><a target='_blank' ".$publ['link'].">".$publ["name"].$publ["name2"]."</a></li>";
             }
          }

        }
///Инфоленты


        if ($all==1 || isset($_GET["ismi"])) {


            if($_SESSION["lang"]!="/en") {
                $massMediaHeader = "ПУБЛИКАЦИИ В СМИ";
            } else {
                $massMediaHeader = "PUBLICATIONS IN MASS MEDIA";
            }
             if (count($smi_cont_res) >0)
             echo "<br /><br /><b>$massMediaHeader</b><br />";
  //           print_r($smi_cont_res);

             $year=0;
			 if (empty($page_n)) $page_n=502;
  			 foreach($smi_cont_res as $li){
               if ($year!= substr($li['date'],0,4))
               {
                   echo "<br /><div style='margin-left:0px;'><b>".substr($li['date'],0,4)."</div></b>";
                   $year=substr($li['date'],0,4);
               }
               $date_news= substr($li['date'],8,2).".".substr($li['date'],5,2).".".substr($li['date'],0,4).$yearPostfix;
               echo "<li><a href=".$_SESSION["lang"]."/index.php?page_id=".$page_n."&id=".$li["el_id"].">".$date_news." ".$li["title"]."</a></li>";
            }
       }
        if ($all==1 || isset($_GET["idiser"])) {


             if (count($diser_cont_res) >0)
             echo "<br /><br /><div style='width:100%;background-color:#efefef;margin-left:0px;'><br />&nbsp;&nbsp;&nbsp;<b>В объявлениях о защите диссертаций </b><br /><br /></div>";

             foreach($diser_cont_res as $li){

               $date_news= substr($li["dd"],8,2).".".substr($li["dd"],5,2).".".substr($li["dd"],0,4).$yearPostfix;
	           echo "<li>".$date_news." ".$li["fio"]."<br />".
	           str_replace("</p>","",str_replace("<p>","",$li["tema"]))." [".round($li["relevantnost"],2)."]"."</li>";

            }

        }
        if ($all==1 || isset($_GET["iabstract"]))
        {


             if (count($abstract_cont_res) >0)
             echo "<br /><br /><div style='width:100%;background-color:#efefef;margin-left:0px;'><br />&nbsp;&nbsp;&nbsp;<b>ПУБЛИКАЦИИ: тезисы</b><br /><br /></div>";
           $title='';
           foreach($abstract_cont_res as $li){

              if ($title!=$li['title'])
              {
                  echo "<br /><div style='margin-left:0px;'><b>".$li['title']."</b></div>";
                  $title=$li['title'];
              }
              $li["patch"]=str_replace(".doc",".pdf",$li["patch"]);
              $patch2="/home/www/2008/html".substr($li["patch"],12);
	          echo "<li>".$li["fio"]."<br />"."<a href=".substr($li["patch"],12).">".$li["tema"]." [".round($li["relevantnost"],2)."]"."</a><br />".$li["partion"]."</li>";

            }

        }

    if ($all==1 || isset($_GET["ismi"])) {

        $videoGallary = new Videogallery();

        $videos = $videoGallary->getVideosByPerson($pid,10,0,9999999);

        if($_SESSION["lang"]!="/en") {
            $videoHeader = "ВИДЕОГАЛЕРЕЯ";
        } else {
            $videoHeader = "VIDEOGALLERY";
        }
        if (count($videos) >0)
            echo "<br /><br /><b>".$videoHeader."</b><br />";
        //           print_r($smi_cont_res);

        $year=0;
        foreach($videos as $video){
            $date = $video->getDateNoMod();
            if($_SESSION["lang"]!="/en") {
                $videoTitle = $video->getTitleNoMod();
            } else {
                $videoTitle = $video->getTitleEnNoMod();
            }
            if ($year!= substr($date,0,4))
            {
                echo "<br /><div style='margin-left:0px;'><b>".substr($date,0,4)."</div></b>";
                $year=substr($date,0,4);
            }
            $date_news= substr($date,8,2).".".substr($date,5,2).".".substr($date,0,4).$yearPostfix;
            echo "<li><a href=".$_SESSION["lang"]."/index.php?page_id=1545&id=".$video->getId().">".$date_news." ".$videoTitle."</a></li>";
        }
    }
    if ($all==1 || isset($_GET["ismi"])) {

        if($_SESSION["lang"]!="/en") {
            $podcastHeader = "ПОДКАСТЫ";
        } else {
            $podcastHeader = "PODCASTS";
        }

        if (count($podcasts_cont_res) >0)
            echo "<br /><br /><b>$podcastHeader</b><br />";
        //           print_r($smi_cont_res);

        $year=0;
        foreach($podcasts_cont_res as $li){
            if ($year!= substr($li['date'],0,4))
            {
                echo "<br /><div style='margin-left:0px;'><b>".substr($li['date'],0,4)."</div></b>";
                $year=substr($li['date'],0,4);
            }
            $date_news= substr($li['date'],8,2).".".substr($li['date'],5,2).".".substr($li['date'],0,4).$yearPostfix;
            echo "<li><a href=".$_SESSION["lang"]."/index.php?page_id=2011&id=".$li["el_id"].">".$date_news." ".$li["title"]."</a></li>";
        }
    }

echo "</ul>";
//}
} // Не пустой поиск
	?>


</div>

<?
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>