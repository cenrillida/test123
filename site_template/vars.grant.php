<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "grant",
		"value" => "Шаблон списка грантов",
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
	"header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Заголовок"),
		"size" => "51",
		"field" => "header",
		"buttons" => "quot",
	),
	"anons"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Анонс"),
		"field" => "anons",
    	),
    "submenu_filter" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("Поставить субменю в Ссылки по теме"),
		"size" => "1",
		"field" => "submenu_filter",
	),
	"links"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Ссылки по теме"),
		"field" => "links",
	),
	"news_line"     => array(
		"class" => "base::selectnir",
		"prompt" => Dreamedit::translate("Источник финансирования НИР"),
		"field" => "news_line",
	),
	"pers_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы сведений о персоне"),
		"size" => "10",
		"field" => "pers_id",
		"buttons" => "page_id",
	),

    "tpl_name"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Имя шаблона tpl"),
		"size" => "51",
		"field" => "tpl_name",
	),
	"count"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("Количество к показу"),
		"size" => "10",
		"field" => "count",
		"value"=> "1000",
	),

	"sort_field"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Поле сортировки"),
		"size" => "51",
		"field" => "sort_field",
	),
	"sort_type"     => array(
		"class" => "base::selectbox",
		"prompt" => Dreamedit::translate("Тип сортировки"),
		"options" => array("DESC" => "По-возрастанию", "ASC" => "По-убыванию"),
		"field" => "sort_type",
	),


);

?>