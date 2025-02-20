<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "experts",
		"value" => "������ �������� ������ � ���������� ���������",
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
	"experts_module_id"      => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ����� ������"),
		"size" => "51",
		"field" => "experts_module_id",
	),
	"experts_id_top"      => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ����� ������, ������������"),
		"size" => "51",
		"field" => "experts_id_top",
	),
    "margin_name"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("���������� ����� ������ � ��������"),
        "size" => "51",
        "field" => "margin_name",
    ),
    "margin_image"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("���������� ����� ������ � ���������"),
        "size" => "51",
        "field" => "margin_image",
    ),
    "font_size_name"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("������ ������ �����"),
        "size" => "51",
        "field" => "font_size_name",
    ),
    "border_hover"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("����� ��� ���������"),
        "size" => "51",
        "help" => "��� �����, �������� #FFFFFF",
        "field" => "border_hover",
        "buttons" => "colorpick",
    ),
    "font_weight_name"     => array(
        "class" => "base::selectbox",
        "prompt" => Dreamedit::translate("�������� �����"),
        "options" => array("bold" => "������", "normal" => "�������", "bolder" => "����������� ������"),
        "field" => "font_weight_name",
        "value" => "bold",
    ),
);

?>