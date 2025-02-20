<?
include_once dirname(__FILE__)."/../../_include.php";

// ���������� ���� ���������� � �����
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/site.fns.php";


$pg = new Pages();

// �������� ��������� ��������� ��������
foreach($mod_array["components"] as $k => $v)
{
	if(!isset($v["field"]))
		continue;

	$page_attr[$v["field"]] = $_REQUEST[$k];
}


$site_templater = new Templater();


if(empty($page_attr["page_template"]))
	die("�� ����� ������ �����������");

// �������� ID �������� �������� (� ������ ������)
$pageContentId = $page_attr["page_id"];
if(!empty($page_attr["page_link"]))
{
	if(is_numeric($page_attr["page_link"]))
	{
		$pageContentId = (int)$page_attr["page_link"];	// ���� ��������� �������� - ������, �� ��������� �� ��� � ���������� ������ ��������

		// ���� �� ����� ������ � ������, �� ����� ������ ������-��������
		if(empty($page_attr["page_template"]))
		{
			$linked_attr = $pg->getPageById($pageContentId);
			$page_attr["page_template"] = $linked_attr["page_template"];
		}
	}
	else
	{
		Dreamedit::sendLocationHeader($page_attr["page_link"]); // ����� ������ �������� �� ��������� ������
	}
}

// ����������� ���� ��������� ������ � ���������
$content = $pg->appendContent($pg->getParents($pageContentId));

// ��������� ������ ������� �������� ������� �� ������ �������� �������� � ���������������� ��������������� ����������
$page_content = array();
foreach($content as $pid => $v)
{
	// ���� � �������� ��� �������� (�� ������ ������) �� ����������
	if(empty($v["content"]) || empty($v["page_template"]))
		continue;

	// ������� ������ ������ ����������
	foreach($v["content"] as $cvName => $cvText)
		$page_content[$cvName] = $cvText;
}



include $_CONFIG["global"]["paths"]["template_path"]."vars.".$page_attr["page_template"].".php";
foreach($tpl_vars as $k => $v)
	$page_content[$v["field"]] = $_REQUEST[$k];


// ���������� ��� �����������
$postFilters = $DB->select("SELECT * FROM ?_filters");
foreach($postFilters as $postFilterData)
{
	if(file_exists($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["filters"].$postFilterData["filter_filename"]))
	{
		ob_start();
		include $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["filters"].$postFilterData["filter_filename"];
		$page_content[strtoupper($postFilterData["filter_placeholder"])] = ob_get_contents();
		ob_end_clean();
	}
}

// ��������� ������ ���������
$site_templater->setValues($page_content);

//������� ��������

//$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"].$page_attr["page_template"].".html");

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"].$page_attr["page_template"].".html");

exit;
?>