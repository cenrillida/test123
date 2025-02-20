<?
include_once dirname(__FILE__)."/../../_include.php";
echo "<link rel=\"stylesheet\" href=\"/dreamedit/includes/jsTree/themes/default/style.css\" />";


$elementLink = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&amp;action=edit&amp;id={ID}";

$pg = new Article();
/*$tree = new WriteTree("d", Dreamedit::createTreeArrayFromArticle($pg->getPagesAllDelimit(), $elementLink));
$tree->setOtherElements(Dreamedit::createTreeArrayFromArticle($pg->getPagesAllWParents(), $elementLink));
*/
/*
$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
$tree->displayTree(Dreamedit::translate("Статьи в журнале"));
*/
/*
if(isset($_REQUEST["id"]))
{

	$tree->openTreeTo((int)$_REQUEST["id"]);
}
else
{

	$openTo = $pg->getRootPageId();
	$tree->openTreeTo($openTo["page_id"], false);
}
*/




/*
$mg=new Magazine();
$rows=$mg->getMagazineAll();

echo "<br /><br /><b>Проверить готовность журнала</b><br />";
foreach ($rows as $row)
{
   echo "<a href=/dreamedit/index.php?mod=articls&action=comment&id=".$row[page_id].">Номер ".$row[page_name]." ".$row[year]." ".$row[date_public]."</a><br />";
}
*/

?>
<div class="dtree">
	<div class="dTreeNode"><img id="id0" width="18" height="18" src="/dreamedit/skin/classic//images/dTree/base.gif" alt="">Статьи в журнале</div>
	<div id="jstree_demo_div">
	</div>
</div>
<script src="/dreamedit/includes/jsTree/jquery.js"></script>
<script src="/dreamedit/includes/jsTree/jstree.min.js"></script>
<script>$(function () { $('#jstree_demo_div').jstree(); });</script>
<script>
	$('#jstree_demo_div').jstree({
		'core' : {
			'data' : {
				'url' : function (node) {
					return node.id === '#' ?
							'ajax_roots.php?selected=<?php echo $_GET[id];?>' :
							'ajax_children.php?selected=<?php echo $_GET[id];?>';
				},
				'data' : function (node) {
					return { 'id' : node.id };
				}
			}
		}
	});
</script>