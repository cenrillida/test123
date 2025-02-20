<?

$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id" => array(
			"class" => "base::hidden",
			"field" => "filter_id",
		),
		"title" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("��������"),
			"required" => TRUE,
			"size" => "51",
			"field" => "filter_title",
		),
		"placeholder" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("��� ������������"),
			"help"	=> Dreamedit::translate("���� ����������� �� ������� ������������ � �������� ��������."),
			"required" => TRUE,
			"size" => "51",
			"field" => "filter_placeholder",
		),
		"filename" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("���������� ����"),
			"help" => Dreamedit::translate("���������� ���� ������ ���������� � ���������� ��� �������� (���������� ����������� � ����������)"),
			"required" => TRUE,
			"size" => "51",
			"field" => "filter_filename",
		),
	),
);

?>