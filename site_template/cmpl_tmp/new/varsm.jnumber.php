<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "jnumber",
		"value" => "������. ����� ������� ?",
	),
    "order" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("���������� � ���������� ������"),
			"value" => "0",
			"options" => "",
			"field" => "order",
	),		
    "subject"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("���� ������"),
		"field" => "subject",
	),
	"subject_en"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("���� ������ (English)"),
		"field" => "subject_en",
	),
	"date_public"    => array(
		"class" => "base::date",
		"buttons" => "calendar",
		"prompt" => Dreamedit::translate("������������ (����)"),
		"field" => "date_public",
	),
	"icon"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("������"),
		"field" => "icon",
	),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("���������"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("��������� (English)"),
		"field" => "content_en",
	),
    "full_text"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("����� �������"),
		"field" => "full_text",
	),
);

?>