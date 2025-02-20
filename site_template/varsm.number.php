<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "jnumber",
		"value" => "Журнал. Номер журнала!!!",
	),


	"tema"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Название рубрики"),
		"size" => "101",
		"field" => "tema",
		"buttons" => "quot",
	),
	"subject"    => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("Тема номера"),
			"field" => "subject",
	),
	"comment" => array(
			"class" => "base::editor",
			"prompt" => Dreamedit::translate("Комментарий"),
			"field" => "comment",
			"type"=>"Basic",

	),

);

?>