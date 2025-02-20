<?

$mod_array = array (
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id" => array(
			"class" => "base::hidden",
			"field" => "dmn_id",
		),
		"name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�������� �����"),
			"required" => TRUE,
			"size" => "51",
			"field" => "dmn_name",
		),
		"list" => array(
			"class" => "base::textarea",
			"prompt" => Dreamedit::translate("������"),
			"help" => Dreamedit::translate("������ ������� (����������� - ������� ������)"),
			"required" => TRUE,
			"cols" => "51",
			"rows" => "10",
			"field" => "dmn_list",
		),
		"indexId" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("������� ��������"),
			"help" => Dreamedit::translate("ID ������� �������� ����� (���� �� ������� - �� ������ �������� ��������)"),
			"size" => "51",
			"field" => "dmn_index",
			"buttons" => "page_id",
		),
		"error" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�������� �� �������"),
			"help" => Dreamedit::translate("ID �������� ������ 404"),
			"size" => "51",
			"field" => "dmn_error",
			"buttons" => "page_id",
		),
		"redirect" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("���������������"),
			"size" => "51",
			"field" => "dmn_redirect",
		),
	),
);

?>