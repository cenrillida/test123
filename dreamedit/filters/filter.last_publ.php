<?
global $DB,$_CONFIG;

// Последние поступрления в каталог для главной страницы раздла



if (empty($page_content[LAST_NUM])) $page_content[LAST_NUM]=7;

if (!isset($_REQUEST[en]))
$rows = $DB->select(
        "SELECT DISTINCT p.id,p.name,p.date,IFNULL(p.picmain,p.picsmall) AS picsmall,hide_autor,r.icont_text AS rubric,rr.icont_text AS rubric_en,p.rubric2 AS rubric_id,avtor  FROM publ AS p
        INNER JOIN  adm_directories_content AS r  ON r.el_id=p.rubric2 AND r.icont_var='text'
        INNER JOIN  adm_directories_content AS rr  ON rr.el_id=r.el_id AND rr.icont_var='text_en'
        INNER JOIN  adm_directories_element AS r2  ON r.el_id=r2.el_ID and r2.itype_id=2,vid
                 WHERE p.name <> '' AND p.status=1 AND year > ".(date("Y")-5).
        " ORDER BY substring(p.date,7,2) DESC,substring(p.date,4,2) DESC, substring(p.date,1,2) DESC,p.id DESC LIMIT ".$page_content[LAST_NUM]);

else
   $rows = $DB->select(
        "SELECT DISTINCT p.id,IF(p.name2<>'',p.name2,p.name) AS name,p.date,IFNULL(p.picmain,p.picsmall) AS picsmall,hide_autor,
        r.icont_text AS rubric,rr.icont_text AS rubric_en,p.rubric2 AS rubric_id,avtor  FROM publ AS p
        INNER JOIN  adm_directories_content AS r
        ON r.el_id=p.rubric2 AND r.icont_var='text'
        INNER JOIN  adm_directories_content AS rr  ON rr.el_id=r.el_id AND rr.icont_var='text_en'
        INNER JOIN  adm_directories_element AS r2  ON r.el_id=r2.el_ID and r2.itype_id=2,vid
                 WHERE p.name <> '' AND p.status=1  AND year > ".(date("Y")-5).
       "  ORDER BY substring(p.date,7,2) DESC,substring(p.date,4,2) DESC, substring(p.date,1,2) DESC,p.id DESC LIMIT ".$page_content[LAST_NUM]);


//print_r($rows);

//echo "<br />";
// Разобрать авторов

       //Вывести результат
foreach($rows as $row)
{
         $avt0=explode("<br>",trim($row[avtor]));
         $avtstring="";
         $bibstring="";
         foreach($avt0 as $avt)
         {
           if (!empty($avt))
           {
           	  if (is_numeric($avt))
           	  {
           	    if (!isset($_REQUEST[en]))
	           	    $fio0=$DB->select("SELECT id,CONCAT(surname,' ',substring(name,1,1),'.',substring(fname,1,1),'.') AS fio FROM persons WHERE id=".$avt);
                else
	           	    $fio0=$DB->select("SELECT id,Autor_en AS fio FROM persons WHERE id=".$avt);

           	    $avtstring.=$fio0[0][fio].", ";
           	    $bibstring.=$fio0[0][fio]." and ";

           	  }
           	  else
           	  {
           	    $avtstring.=$avt.", ";
           	    $bibstring.=$avt." and ";

           	  }
           }
         }
         $avtstring=substr($avtstring,0,-2);
         $bibstring=substr($bibstring,0,-5);
         if ($row[hide_autor]=='on')
         {
         	$avtstring=''; $bibstring='';
         }
//        include_once "bib.php";
        if (empty($row[picsmall])) $row[picsmall]="e_resurs.jpg";
       	$tpl = new Templater();
//    	$tpl->setValues($v["content"]);
//
//        $fullname = "<strong>".$v[name]."</strong>".$v[name2];
//		$tpl->appendValues($page_content);
        $tpl->setValues(array("ID" => $row[id]));
        $tpl->appendValues(array("AVTOR" => $avtstring));
        $tpl->appendValues(array("NAME" => $row[name]));
	    $tpl->appendValues(array("DATE" => $row['date'] ));
	    $tpl->appendValues(array("PICTURE" => $row['picsmall'] ));
		$tpl->appendValues(array("RUBRIC" => $row['rubric'] ));
		$tpl->appendValues(array("RUBRIC_ID" => $row['rubric_id'] ));
		$tpl->appendValues(array("RUBRIC_EN" => $row['rubric_en'] ));
		$tpl->appendValues(array("PUBL_PAGE" => $page_content[PUBL_PAGE]));
		$tpl->appendValues(array("PUBL_SPISOK" => $page_content[PUBL_SPISOK]));

		$tpl->appendValues(array("GO" => true));



		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.last_publ.html");

		$bib=new BibEntry();
		$aa=$bib->toCoinsMySQL($row,$bibstring);
		print_r($aa);
}
?>
