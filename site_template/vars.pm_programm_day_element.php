<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pm_programm_day_element",
		"value" => "������ ��������� ��� ������� ���������",
	),

    "time"    => array(
        "class" => "base::textbox",
        "size" => "101",
        "prompt" => Dreamedit::translate("�����"),
        "field" => "time",
    ),
    "place"    => array(
        "class" => "base::textbox",
        "size" => "101",
        "prompt" => Dreamedit::translate("�����"),
        "field" => "place",
    ),
    "place_en"    => array(
        "class" => "base::textbox",
        "size" => "101",
        "prompt" => Dreamedit::translate("����� English"),
        "field" => "place_en",
    ),
    "text_preview"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("������� �����"),
        "field" => "text_preview",
    ),
    "text_preview_en"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("������� ����� English"),
        "field" => "text_preview_en",
    ),
    "full_text"    => array(
        "class" => "base::editor",
        "size" => "101",
        "prompt" => Dreamedit::translate("������ �����"),
        "field" => "full_text",
    ),
    "full_text_en"    => array(
        "class" => "base::editor",
        "size" => "101",
        "prompt" => Dreamedit::translate("������ ����� English"),
        "field" => "full_text_en",
    ),
);

?>