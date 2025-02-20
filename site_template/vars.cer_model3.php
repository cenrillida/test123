<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "cer_model3",
		"value" => "Шаблон модели 3 ЦЭИ",
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
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент после модели"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент после модели (English)"),
		"field" => "content_en",
	),
);

?>