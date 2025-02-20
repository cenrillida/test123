<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "search",
		"value" => "—траницы. Ўаблон страницы поиска.",
	),


	"content_header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("«аголовок"),
		"size" => "51",
		"field" => "content_header",
		"buttons" => "quot",
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
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"cols" => "51",
		"rows" => "5",
		"field" => "description",
	),
	"reclama"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("–екламный блок"),
		"field" => "reclama",
	),
	"full_id_d"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ƒополнительных страниц меню"),
		"size" => "10",
		"field" => "full_id_d",
		"buttons" => "page_id",
	),
	"full_id_s"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы поиска публикаций"),
		"size" => "10",
		"field" => "full_id_s",
		"buttons" => "page_id",
	),
	"full_id_a"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы персоналий"),
		"size" => "10",
		"field" => "full_id_a",
		"buttons" => "page_id",
	),
	"full_id_p"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы публикации"),
		"size" => "10",
		"field" => "full_id_p",
		"buttons" => "page_id",
	),
	"news_name"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("»м€ страницы с новостью"),
		"size" => "20",
		"field" => "news_name",
	),
	"news_id"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("ID страницы с новостью"),
		"size" => "10",
		"field" => "news_id",
		"buttons" => "page_id",
	),
	"diser_id"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("ID страницы с защитой"),
		"size" => "10",
		"field" => "diser_id",
		"buttons" => "page_id",
	),

);

?>