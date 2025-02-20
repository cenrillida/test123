<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "combobox",
		"value" => "Шаблон для списка выпадающих ссылок с поиском",
	),
    "placeholder"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Placeholder (текст до ввода)"),
        "size" => "101",
        "field" => "placeholder",
        "buttons" => "quot",
    ),
    "placeholder_italic" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Курсив Placeholder"),
        "size" => "1",
        "field" => "placeholder_italic",
    ),
);

?>