<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "magazine_article_all",
		"value" => "Журнал. Указатель статей",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"field" => "description",
		"cols" => "51",
		"rows" => "5",
		"buttons" => "quot",
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
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
	 "article_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы статьи"),
		"size" => "10",
		"field" => "article_id",
		"buttons" => "page_id",
       ),
       "rubric_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы Статьи в рубрике"),
		"size" => "10",
		"field" => "rubric_id",
		"buttons" => "page_id",
       ),
      "persona_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы персоны"),
		"size" => "10",
		"field" => "persona_id",
		"buttons" => "page_id",
		),
		"content_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID страницы оглавление"),
		"size" => "10",
		"field" => "content_id",
		"buttons" => "page_id",
		),
      "short_list" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("По авторам"),
		"size" => "1",
		"field" => "short_list",
	),
);

?>