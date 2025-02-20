<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "collapsed_element",
		"value" => "Шаблон элемента скрытых под кнопкой",
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
		"prompt" => Dreamedit::translate("Контент"),
		"field" => "content",
	),
    "opened_by_default" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Изначально открыт"),
        "size" => "1",
        "field" => "opened_by_default",
    ),
);

?>