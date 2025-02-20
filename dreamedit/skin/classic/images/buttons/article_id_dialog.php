<?
include_once dirname(__FILE__)."/../../../../_include.php";
$id = (int)$_REQUEST["id"];
$name = $_REQUEST["name"];

$treeName = "d";
?>
<html>
<head>
<title><?=Dreamedit::translate("");?></title>
<link rel="stylesheet" type="text/css" href="/<?=$_CONFIG["global"]["paths"]["admin_dir"]?>includes/dTree/dtree.css" />
<link rel="stylesheet" type="text/css" href="/<?=$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]?>de_style.css" />
<script type="text/javascript" src="/<?=$_CONFIG["global"]["paths"]["admin_dir"]?>includes/dTree/dtree.js"></script>
<script>
function getSelected()
{
	var obj = opener.document.getElementById('<?=$name?>');
	obj.value = <?=$treeName?>.getSelectedId();
	window.close();
}
</script>
</head>

<body class="dialog_window">

<?

$elementLink = "#";


$pg = new Article();
$tree = new WriteTree($treeName, Dreamedit::createTreeArrayFromPages($pg->getPages(), $elementLink));
$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
$tree->displayTree(Dreamedit::translate("Оглавление"));

if($id > 0)
{
	$tree->openTreeTo($id);
}
else
{
	$openTo = $pg->getRootPageId();
	$tree->openTreeTo($openTo["page_id"], false);
}
?>
<br />
<center><button onclick="getSelected()">Выбрать</button></center>


</body>
</html>