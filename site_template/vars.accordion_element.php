<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "accordion_element",
		"value" => "������ �������� ���� ���������",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "101",
		"field" => "title",
		"buttons" => "quot",
	),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("�������"),
		"field" => "content",
	),
    "opened_by_default" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("���������� ������"),
        "size" => "1",
        "field" => "opened_by_default",
    ),
    "swiper_slider"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("�������� ��� ��������"),
        "field" => "swiper_slider",
        "help" => "[SWIPER_SLIDER] - ����������� ��� ������� �������� � �����",
    ),
    "swiper_slider_height"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("������ ��������"),
        "size" => "51",
        "field" => "swiper_slider_height",
        "buttons" => "quot",
    ),
);

?>