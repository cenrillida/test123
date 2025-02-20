<?
global $DB, $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;
// Случайная публикация

if (!isset($_REQUEST[en]))
{
$rows = $DB->select(
        "SELECT * FROM (SELECT id,date,name,IF(name2='',name,name2) AS name2,`link`,picsmall,
				 link_en, vid FROM publ
                WHERE status=1 AND formain=1 ORDER BY substring(date,7,2),substring(date,4,2),substring(date,1,2) LIMIT 3) AS z
                 ORDER BY RAND() LIMIT 1"
	);
$txt="подробнее";
}
else
{
//$rows = $DB->select(
//        "SELECT id,avtor,hide_autor,IF(name2<>'',name2,name) AS name,IF(picmain='',picsmall,picmain) AS picsmall,hide_autor  FROM publ where picsmall <> ''
//        AND
//        NOT (rubric2 LIKE 'r%' OR rubric2d LIKE 'r%' OR rubric2_3 LIKE 'r%' OR rubric2_4 LIKE 'r%' OR rubric2_5 LIKE 'r%')
//
//        ORDER BY RAND() LIMIT 1");
$rows = $DB->select ("SELECT * FROM (SELECT id,date,name,IF(name2='',name,name2) AS name2,`link`,
				 link_en, vid FROM publ
                WHERE status=1 AND formain=1 ORDER BY substring(date,7,2),substring(date,4,2),substring(date,1,2) LIMIT 3) AS z
                 ORDER BY RAND() LIMIT 1");
	
$txt='more';
}
//print_r($rows);
//Разобрать авторов

 // По публикациям

 foreach($rows as $k => $v)
 {
     $spisok_avt="";

     if ($v[hide_autor] != 'on' && $v[avtor]!='коллектив авторов')
     {
       $avt = explode("<br>", trim($v[avtor]));

       foreach($avt as $i)
       {

          if (!empty($i))
          {
          if (is_numeric($i))
          {
	       if (!isset($_REQUEST[en]))
		       $avt_name= $DB->select("SELECT id,CONCAT(surname,' ',substring(name,1,1),'.',substring(fname,1,1),'.') AS fio FROM persons WHERE id = ".$i);
           else
		       $avt_name= $DB->select("SELECT id,Autor_en AS fio FROM persons WHERE id = ". $i);

             $spisok_avt .=$avt_name[0][fio].", ";
	  }
          else
	  {
             $spisok_avt .= $i.", ";
          }
          }
       }

       $spisok_avt=substr($spisok_avt,0,-2);
    }

       //Вывести результат

       	$tpl = new Templater();
//	$tpl->setValues($v["content"]);

    $fullname = "".$v[name]."";
	$tpl->appendValues($page_content);
    $tpl->appendValues(array("ID_BOOKS" => $v[id]));
	$tpl->appendValues(array("PUBL_PAGE" => $page_content[PUBL_PAGE]));

	$tpl->appendValues(array("GO" => true));

	$tpl->appendValues(array("NAME" => $fullname ));
	$tpl->appendValues(array("AVTOR" => $spisok_avt));
	$tpl->appendValues(array("PICTURE" => $v['picsmall']));
	$tpl->appendValues(array("TXT" => $txt ));

	$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.newbooks.html");


}


?>