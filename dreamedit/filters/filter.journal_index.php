<?
global $DB,$_CONFIG;
$mz=new Magazine();
// Статьи за год для журнала

echo $_SESSION[jour_id]."@@_";
$rows=$mz->getMagazineAllYear($_SESSION[jour_id]);
print_r($rows);
 
 /*

       	$tpl = new Templater();
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
*/
?>
