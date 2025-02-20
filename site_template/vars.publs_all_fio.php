<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "publs_all_fio",
		"value" => "ѕубликации. —писок всех по автору",
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
		"prompt" => Dreamedit::translate("«аголовок"),
		"size" => "51",
		"field" => "header",
		"buttons" => "quot",
	),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate(" онтент"),
		"field" => "content",
	),
	"count"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate(" оличество публикаций на странице"),
		"size" => "10",
		"field" => "count",
	),
	"full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы поиска публикаций"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
       ),
	"publ_page"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы подробных сведений"),
		"size" => "10",
		"field" => "publ_page",
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
    "menu_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID главной страницы меню"),
		"size" => "10",
		"field" => "menu_id",
		"buttons" => "page_id",
       ),

);

?>