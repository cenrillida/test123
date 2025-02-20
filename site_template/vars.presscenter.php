<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "presscenter",
		"value" => "������ �����-������",
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
    "left_collumn"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("����� �������"),
        "size" => "51",
        "field" => "left_collumn",
        "buttons" => "quot",
    ),
    "right_collumn"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("������ �������"),
        "size" => "51",
        "field" => "right_collumn",
        "buttons" => "quot",
    ),
    "wide_sections" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("����������� �����"),
        "value" => "0",
        "options" => "",
        "field" => "wide_sections",
    ),
    "p�_header" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("����� �����-������"),
        "value" => "1",
        "options" => "",
        "field" => "pc_header",
    ),
    "footer_slider_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("��������� ������� � �������"),
        "value" => "0",
        "options" => "",
        "field" => "footer_slider_off",
    ),
    "person"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("�������� ������� ��� ��������� (ID)"),
        "help" => "���� �����, �� � ������ ������ �� ����� ����������� �� �������(��������� ��� ��������)",
        "size" => "51",
        "field" => "person",
        "buttons" => "quot",
    ),
);

?>