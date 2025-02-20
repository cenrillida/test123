<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "1publ_admin",
		"value" => "Статистика 1 публикации",
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
	"menu_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID главной страницы меню"),
		"size" => "10",
		"field" => "menu_id",
		"buttons" => "page_id",
       ),
	"full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID со списком публикаций"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
	),
	"full_id_a"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы автора"),
		"size" => "10",
		"field" => "full_id_a",
		"buttons" => "page_id",
        ),
    "article_mode" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("Статистика по модулю \"Статья в журнале\""),
		"size" => "1",
		"field" => "article_mode",
	),
	"links"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Ссылки по теме"),
		"field" => "links",
	),
/*	"header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Заголовок"),
		"size" => "51",
		"field" => "header",
		"buttons" => "quot",
	),*/
);

?>