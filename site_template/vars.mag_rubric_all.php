<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "mag_rubric_all",
		"value" => "Журналы(Новый модуль). Список рубрик",
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
    "short_list" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Краткий список"),
        "size" => "1",
        "field" => "short_list",
    ),
);

?>