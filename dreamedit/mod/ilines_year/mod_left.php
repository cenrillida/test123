<?
include_once dirname(__FILE__)."/../../_include.php";
echo "<link rel=\"stylesheet\" href=\"/dreamedit/includes/jsTree/themes/default/style.css\" />";

/*
include_once "../ilines/mod_fns.php";

$ilines = new Ilines();

// вытаскиваем типы инфолент
$type_rows = $ilines->getTypes();

// вытаскиваем все элементы инфолент
$el_rows = array();
foreach($type_rows as $k => $v)
	$el_rows = $el_rows + $ilines->getElementsByTypeLastTwoYears(array($k), @$v["itype_el_sort_field"], @$v["itype_el_sort_type"]);


// присоединяем контент и получаем готовый массив для построения дерева
$rows = Dreamedit::createTreeArrayFromIlines($type_rows, $ilines->appendContent($el_rows));

// русуем дерево
$tree = new WriteTree("d", $rows);
$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
$tree->displayTree(Dreamedit::translate("Информационные ленты"), "t0");

// открываем дерево до $openTo
$openTo = "t".(int)@$_GET["id"];
if(isset($_GET["type"]) && $_GET["type"] == "l")
	$openTo = "l".(int)@$_GET["id"];

$tree->openTreeTo($openTo);*/

$elementLink = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&amp;action=edit&amp;id={ID}";





?>

<div class="dtree">
    <div class="dTreeNode"><img id="id0" width="18" height="18" src="/dreamedit/skin/classic//images/dTree/base.gif" alt="">Информационные ленты</div>
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
                        'mod/ilines_year/ajax/ajax_roots.php?selected=<?php echo $_GET[id];?>&type=<?php if(!empty($_GET[type])) echo $_GET[type]; else echo "none";?>' :
                        'mod/ilines_year/ajax/ajax_children.php?selected=<?php echo $_GET[id];?>&type=<?php if(!empty($_GET[type])) echo $_GET[type]; else echo "none";?>';
                },
                'data' : function (node) {
                    return { 'id' : node.id };
                }
            }
        }
    });
</script>
