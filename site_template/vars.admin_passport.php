<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "admin_passport",
		"value" => "Шаблон страницы администрирования паспортных данных",
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
);

?>