<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "text_map",
		"value" => "Шаблон текстовой страницы c картой мира",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
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
	"reclama_en"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Блок в правую колонку (английский)"),
		"field" => "reclama_en",
	),
	"txt"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Текст над списком"),
		"field" => "txt",
	),
	"txt_en"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Текст над списком (английский)"),
		"field" => "txt_en",
	),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент"),
		"field" => "content",
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