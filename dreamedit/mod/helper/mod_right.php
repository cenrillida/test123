<?
include_once dirname(__FILE__)."/../../_include.php";
include_once "mod_fns.php";
include_once "form.php";


$phorm = new mod_phorm($mod_array);

if($_ACTIVE["action"] == "add")
{
	$phorm->display();
}


if($_ACTIVE["action"] == "edit")
{
	// ������ ��������������� ������ �������

	// ����������� ���������������� ������
	echo "<div class=\"subtree\">";
	$pg = new Helpers();
	// ����������� ��� ��������
	$rows = $pg->getLinkedPages($_REQUEST["id"]);

	$elementLink = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&amp;action=edit&amp;id={ID}";

	$tree = new WriteTree("subD", Dreamedit::createTreeArrayFromHelpers($rows, $elementLink));
	$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
	$tree->displayTree(Dreamedit::translate("��������� ������"));
	$tree->openTreeTo((int)@$_REQUEST["id"]);

	echo "<script>subD.openAll()</script>";
	echo "</div>";

	// ��������� ���� �����
	$data = array();
	$row = $pg->getPageById($_REQUEST["id"]);

	foreach($phorm->data() as $k => $v)
	{
		if(!isset($v["field"]))
			continue;

		$tmp = $row[$v["field"]];
		$data[$k] = $tmp;
	}

	// ��������� ���� ����� ����������� � ��������
	if(empty($row["page_link"]) && !empty($row["page_template"]))
	{
		include $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."varsh.".$row["page_template"].".php";
		$phorm->add_comps($tpl_vars);
		$cv = $DB->select("SELECT ?_helpers_content.*, ?_helpers_content.cv_name AS ARRAY_KEY FROM ?_helpers_content WHERE page_id = ?d", $_REQUEST["id"]);

		foreach($tpl_vars as $k => $v)
		{
			if(isset($v["field"]))
				$data[$k] = @$cv[strtoupper($v["field"])]["cv_text"];
		}
	}

	$phorm->mod_phorm_values($data);
//	$_POST[people]=$data[people];
	$phorm->display();
}



if($_ACTIVE["action"] == "save")
{
	// ���� ��������� ����������
	if(isset($_REQUEST["sort"]))
	{
		$pagePosition = explode("|", $_REQUEST["list-sortPage"]);

		foreach($pagePosition as $position => $id)
			$DB->query("UPDATE ?_helpers SET page_position = ?d WHERE page_id = ?d", $position, $id);

		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_REQUEST["sort"]);
	}

/*
	if(!empty($_REQUEST["template"]))
	{
		include $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."vars.".$_REQUEST["template"].".php";
	}

	if(!empty($_REQUEST["template"]) && empty($_REQUEST["link"]) && !empty($_REQUEST["id"]))
	{
		$phorm->add_comps($tpl_vars);
	}
*/

	if(!empty($_REQUEST["template"]) && empty($_REQUEST["link"]) && !empty($_REQUEST["id"]))
	{
		include $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."varsh.".$_REQUEST["template"].".php";
		$phorm->add_comps($tpl_vars);
	}

	$phorm->mod_phorm_values($_REQUEST);
	if(!$phorm->validate())
	{
		$phorm->display();
		return;
	}

	include_once "save_action.php";
}



if($_ACTIVE["action"] == "sort")
{
	include $_CONFIG["global"]["paths"]["admin_path"]."includes/list-sorting/sorting.inc.php";

	if(isset($_POST["order"]))
	{
		$pages_position = explode("|", $_REQUEST["order"]);

		foreach($pages_position as $k => $v)
			$DB->query("UPDATE ?_helpers SET page_position = ?d WHERE page_id = ?d", $k, $v);

		Dreamedit::sendLocationHeader("https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_REQUEST["mod"] . "&action=view&id=" . $_REQUEST["id"]);
	}

	$sortRes = $DB->select("SELECT * FROM ?_helpers WHERE page_parent = ?d ORDER BY page_position ASC, page_name ASC", $_REQUEST["id"]);
	$sortArr = array();
	foreach($sortRes as $v)
		$sortArr[$v["page_id"]] = $v["page_name"];

	echo "<form method=\"POST\" action=\"\" id=\"data_form\">\n";
	echo "<input type=\"hidden\" name=\"sort\" value=\"".$_REQUEST["id"]."\" />";
	listSorting("sortPage", $sortArr);
	echo "</form>";
}


if($_ACTIVE["action"] == "del")
{
	$del_secure = $DB->selectCell("SELECT page_dell FROM ?_helpers WHERE page_id = ?d", $_REQUEST["id"]);
	if($del_secure)
	{
		echo Dreamedit::translate("�������� ������ �������� ���������!<br />�� ������������� ���������� � ��������������.");
		return;
	}

	$link_count = $DB->selectCell("SELECT COUNT(*) FROM ?_helpers WHERE page_link = ?d", $_REQUEST["id"]);
	if($link_count > 0 && !isset($_REQUEST["del_type"]))
	{
		echo "<script>\n";
		echo "var type = confirm('".Dreamedit::translate("�� ���������� ��������� �������� ��������� ".$link_count." �������. �� ������� �������� �� ���?")."');\n";
		echo "window.location.href += '&del_type=' + type;\n";
		echo "</script>\n";
		return;
	}

	if(isset($_REQUEST["del_type"]))
	{
		if($_REQUEST["del_type"] == "true")
		{
			$DB->query("DELETE FROM ?_helpers WHERE page_link = ?d", $_REQUEST["id"]);
			$DB->query("DELETE FROM ?_helpers_content WHERE page_id = ?d", $_REQUEST["id"]);
		}
		else
		{
			$rand_link = $DB->selectCell("SELECT page_id FROM ?_helpers WHERE page_link = ?d LIMIT 1", $_REQUEST["id"]);
			$DB->query("UPDATE ?_helpers SET page_link = '' WHERE page_id = ?d", $rand_link);
			$DB->query("UPDATE ?_helpers_content SET page_id = ?d WHERE page_id = ?d", $rand_link, $_REQUEST["id"]);
			$DB->query("UPDATE ?_helpers SET page_link = ?d WHERE page_link = ?d", $rand_link, $_REQUEST["id"]);
		}
	}

	$pid = $DB->selectCell("SELECT ?_helpers.page_parent FROM ?_helpers WHERE page_id = ?d", $_REQUEST["id"]);
	$DB->query("DELETE FROM ?_helpers WHERE page_id = ?d", $_REQUEST["id"]);
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$pid);
}


if($_ACTIVE["action"] == "preview")
{
	include_once dirname(__FILE__)."/preview.php";

//    include_once dirname("https://".$_CONFIG["global"]["paths"]["site"]."index.php");
}

?>
