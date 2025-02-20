<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "specrub_list",
		"value" => "Шаблон страницы списка спецрубрик",
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
	"ex_info"    => array(
	"class" => "base::editor",
	"prompt" => Dreamedit::translate("Контент"),
	"field" => "ex_info",
    ),
);

?>