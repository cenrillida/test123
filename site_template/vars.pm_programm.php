<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pm_programm",
		"value" => "������ �������� ������� ���������",
	),

    "files_page"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("�������� ������"),
        "size" => "51",
        "field" => "files_page",
        "buttons" => "page_id",
    ),

    "days_page"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("�������� ����"),
        "size" => "51",
        "field" => "days_page",
        "buttons" => "page_id",
    ),

    "countdown_date"      => array(
        "class" => "base::date",
        "prompt" => Dreamedit::translate("���� ��������"),
        "field" => "countdown_date",
        "buttons" => "calendar",
    ),

    "countdown_title"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("��������� ��������"),
        "size" => "51",
        "field" => "countdown_title",
        "buttons" => "quot",
    ),
    "countdown_title_en"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("��������� �������� (En)"),
        "size" => "51",
        "field" => "countdown_title_en",
        "buttons" => "quot",
    ),

    "countdown_text"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("����� ��������"),
        "size" => "51",
        "field" => "countdown_text",
        "buttons" => "quot",
    ),
    "countdown_text_en"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("����� �������� (En)"),
        "size" => "51",
        "field" => "countdown_text_en",
        "buttons" => "quot",
    ),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title Russian"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
	"title_en"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title English"),
		"size" => "51",
		"field" => "title_en",
		"buttons" => "quot",
	),
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"field" => "description",
		"cols" => "51",
		"rows" => "5",
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),
/*	"header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("���������"),
		"size" => "51",
		"field" => "header",
		"buttons" => "quot",
	),*/
	"reclama"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("���� � ������ �������"),
		"field" => "reclama",
	),
    "reclama_en"    => array(
        "class" => "base::editor",
        "type" => "Basic",
        "prompt" => Dreamedit::translate("���� � ������ ������� (����������)"),
        "field" => "reclama_en",
    ),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("�������"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������ (English)"),
		"field" => "content_en",
	),
/*
	"links"   => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������ �� ����"),
		"field" => "links",
	),
*/
	"people"   => array(
		"class" => "base::people",
		"prompt" => Dreamedit::translate("����"),
		"size" => "81",
		"field" => "people",
	),
	"bank_check"    => array(
		"class" => "base::textarea",
		"cols" => "51",
		"rows" => "5",
		"prompt" => Dreamedit::translate("��������� ���������� �������<br />� ���������� ����������"),
		"field" => "bank_check",
	),
);

?>