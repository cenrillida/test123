<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "notifications",
		"value" => "Шаблон страницы оповещений",
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
	"news_line"     => array(
		"class" => "base::selectIline",
		"prompt" => Dreamedit::translate("Лента"),
		"field" => "news_line",
	),
);

?>