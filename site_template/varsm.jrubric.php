<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "jrubric",
		"value" => "������. �������",
	),

	"name"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("�������� ��� �������"),
		"size" => "51",
		"field" => "page_name",
		"buttons" => "quot",
	),

	"rubric"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("�������� �������"),
		"size" => "101",
		"field" => "rubric",
		"buttons" => "quot",
	),
	"rubric_en"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("�������� ������� (English)"),
		"size" => "101",
		"field" => "rubric_en",
		"buttons" => "quot",
	),
	"icon"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("������"),
		"field" => "icon",
	),
	"content"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("�����������"),
		"field" => "content",
	),

);

?>