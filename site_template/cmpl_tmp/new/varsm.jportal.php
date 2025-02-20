<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "jportal",
		"value" => "Журнал. Оформление сайта",
	),


	"picture"      => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Главная картинка (590x236)"),
		"type" => "Basic",
		"field" => "picture",
		
	),
	"impact"    => array(
			"class" => "base::textbox",
			"size" => "61",
			"prompt" => Dreamedit::translate("Импакт-фактор"),
			"field" => "impact",
	),
	"text2"    => array(
			"class" => "base::textbox",
			"size" => "61",
			"prompt" => Dreamedit::translate("Текст на картинку"),
			"field" => "text2",
	),
	"text3"    => array(
			"class" => "base::textbox",
			"size" => "61",
			"prompt" => Dreamedit::translate("Текст на картинку"),
			"field" => "text3",
	),
	


);

?>