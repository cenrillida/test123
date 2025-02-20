<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "grant_full",
		"value" => "НИР. Подробнее",
	),
    "full_id" => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы со списком грантов"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
	 ),
/*	"title"      => array(
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
*/
);

?>