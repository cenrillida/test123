<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "disser",
		"value" => "Шаблон инф.ленты (защиты)",
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
		"class" => "base::selectIline",
		"prompt" => Dreamedit::translate("Лента"),
		"field" => "news_line",
	),
	"full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID документа с полной новостью"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
	),

	"count"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("Количество к показу"),
		"size" => "10",
		"field" => "count",
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