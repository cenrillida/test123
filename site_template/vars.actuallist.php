<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "actuallist",
		"value" => "Список акт. комментариев (таблица)",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"field" => "description",
		"cols" => "51",
		"rows" => "5",
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),
/*	"header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Заголовок"),
		"size" => "51",
		"field" => "header",
		"buttons" => "quot",
	),*/
	"reclama"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Блок в правую колонку"),
		"field" => "reclama",
	),

	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Конент (English)"),
		"field" => "content_en",
	),
/*
	"links"   => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Ссылки по теме"),
		"field" => "links",
	),
*/
	"people"   => array(
		"class" => "base::people",
		"prompt" => Dreamedit::translate("Люди"),
		"size" => "81",
		"field" => "people",
	),
	"bank_check"    => array(
		"class" => "base::textarea",
		"cols" => "51",
		"rows" => "5",
		"prompt" => Dreamedit::translate("Поставить назначение платежа<br />к банковским реквизитам"),
		"field" => "bank_check",
	),
);

?>