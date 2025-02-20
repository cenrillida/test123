<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "delay",
		"value" => "Публикации. Работа с корзинкой",
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
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент"),
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
	"content_last"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Комментарий к последним поступлениям"),
		"field" => "content_last",
	),
	"count"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("Количество публикаций на странице"),
		"size" => "10",
		"field" => "count",
	),
	"full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы подбора публикаций"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
       ),
	"full_id_p"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы подробных сведений"),
		"size" => "10",
		"field" => "full_id_p",
		"buttons" => "page_id",
       ),
   	"full_id_a"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы автора"),
		"size" => "10",
		"field" => "full_id_a",
		"buttons" => "page_id",
       ),
    "pers_publ"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID публикаций песроны"),
		"size" => "10",
		"field" => "pers_publ",
		"buttons" => "page_id",
       ),


);

?>