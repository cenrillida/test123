<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pm_programm_day_element",
		"value" => "Шаблон элементов дня деловой программы",
	),

    "time"    => array(
        "class" => "base::textbox",
        "size" => "101",
        "prompt" => Dreamedit::translate("Время"),
        "field" => "time",
    ),
    "place"    => array(
        "class" => "base::textbox",
        "size" => "101",
        "prompt" => Dreamedit::translate("Место"),
        "field" => "place",
    ),
    "place_en"    => array(
        "class" => "base::textbox",
        "size" => "101",
        "prompt" => Dreamedit::translate("Место English"),
        "field" => "place_en",
    ),
    "text_preview"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Краткий текст"),
        "field" => "text_preview",
    ),
    "text_preview_en"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Краткий текст English"),
        "field" => "text_preview_en",
    ),
    "full_text"    => array(
        "class" => "base::editor",
        "size" => "101",
        "prompt" => Dreamedit::translate("Полный текст"),
        "field" => "full_text",
    ),
    "full_text_en"    => array(
        "class" => "base::editor",
        "size" => "101",
        "prompt" => Dreamedit::translate("Полный текст English"),
        "field" => "full_text_en",
    ),
);

?>