<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "podr2",
		"value" => "Шаблон списка подразделений",
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
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Конент"),
		"field" => "content",
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
       "full_id"     => array(
                "class" => "base::integer",
	        "prompt" => Dreamedit::translate("ID главной страницы подразделений"),
	        "size" => "10",
	        "field" => "full_id",
	        "buttons" => "page_id",
	),
       "full_id_p"     => array(
                "class" => "base::integer",
	        "prompt" => Dreamedit::translate("ID страницы персоны"),
	        "size" => "10",
	        "field" => "full_id_p",
	        "buttons" => "page_id",
	),


);

?>