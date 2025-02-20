<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "combobox_element",
		"value" => "Шаблон элемента списка выпадающих ссылок",
	),
    "title"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Текст"),
        "size" => "101",
        "field" => "title",
        "buttons" => "quot",
    ),
    "url"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Ссылка"),
        "size" => "101",
        "field" => "url",
        "buttons" => "quot",
    ),
);

?>