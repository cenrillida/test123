<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "comment_reg",
		"value" => "Комментарии. Регистрация",
	),
	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"cols" => "51",
		"rows" => "5",
		"field" => "description",
	),

	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент"),
		"field" => "content",
	),
	"result"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Ответ отправителю"),
		"field" => "result",
	),

	"final"  => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Письмо отправителю"),
		"field" => "final",

	),

);

?>