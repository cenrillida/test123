<?
// Логотипы партнеров
global $_CONFIG,$_TPL_REPLACMENT,$page_content;

$ilines = new Ilines();

$rows = $ilines->getLimitedElementsMultiSort($page_content["LOGO_BLOCK_LINE"], 1000, 1,"SORT", "ASC", "status");


if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);
	foreach($rows as $k => $v)
	{
        $tpl = new Templater();
        $tpl->setValues($v["content"]);
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.partners.html");

	}

}
?>
