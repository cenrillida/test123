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
    "slider_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("��������� � ��������"),
        "value" => "0",
        "options" => "",
        "field" => "slider_off",
    ),
    "rinc_number"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("���� ������"),
        "size" => "51",
        "field" => "rinc_number",
    ),
    "doi_number"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("DOI ������"),
        "size" => "51",
        "field" => "doi_number",
    ),
    "isbn_number"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("ISBN ������"),
        "size" => "51",
        "field" => "isbn_number",
    ),
    "signed_to_print"    => array(
        "class" => "base::date",
        "buttons" => "calendar",
        "prompt" => Dreamedit::translate("����� �������� � ������ (����)"),
        "field" => "signed_to_print",
    ),
    "date_of_publication"    => array(
        "class" => "base::date",
        "buttons" => "calendar",
        "prompt" => Dreamedit::translate("���� ������ � ����"),
        "field" => "date_of_publication",
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
	"full_text_open" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("����� ������� ��� ������ �������"),
		"value" => "0",
		"options" => "",
		"field" => "full_text_open",
	),
);

?>