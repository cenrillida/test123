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
	"citas"    => array(
			"class" => "base::editor",
			"type"=> "basic",
			"prompt" => Dreamedit::translate("Индексирование журнала"),
			"field" => "citas",
	),
	"block"    => array(
			"class" => "base::textbox",
			"size" => "61",
			"prompt" => Dreamedit::translate("В правую колонку(название блоков)"),
			"help" => "Название модуля из заголовков блоков главной страницы",
			"field" => "block",
	),

);

?>