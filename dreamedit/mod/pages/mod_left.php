<?
include_once dirname(__FILE__)."/../../_include.php";


$elementLink = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&amp;action=edit&amp;id={ID}";

$pg = new Pages();
$tree = new WriteTree("d", Dreamedit::createTreeArrayFromPages($pg->getPages(), $elementLink));
$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
$tree->displayTree(Dreamedit::translate("Страницы сайта"));

if(isset($_REQUEST["id"]))
{
	$tree->openTreeTo((int)$_REQUEST["id"]);
}
else
{
	$openTo = $pg->getRootPageId();
	$tree->openTreeTo($openTo["page_id"], false);
}


?>
