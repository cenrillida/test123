<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "publsearch_2011",
		"value" => "Публикации. Старица поиска публикаций 2011.",
	),


	"content_header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Заголовок"),
		"size" => "51",
		"field" => "content_header",
		"buttons" => "quot",
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
       "full_id"     => array(
                "class" => "base::integer",
	        "prompt" => Dreamedit::translate("ID страницы с результатами"),
	        "size" => "10",
	        "field" => "full_id",
	        "buttons" => "page_id",
	),
	 "menu_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID главной страницы меню"),
		"size" => "10",
		"field" => "menu_id",
		"buttons" => "page_id",
       ),
);

?>