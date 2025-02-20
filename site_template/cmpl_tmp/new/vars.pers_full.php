<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pers_full",
		"value" => "Шаблон страницы с одной персоналией",
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

     "publ_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID публикации персоны"),
		"size" => "10",
		"field" => "publ_id",
		"buttons" => "page_id",
        ),
     "perss_page" => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("Страница О персоне на сайте "),
		"size" => "10",
		"field" => "perss_page",
		"buttons" => "page_id",
	 ),
	 "pers_page" => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("Страница списка персон "),
		"size" => "10",
		"field" => "pers_page",
		"buttons" => "page_id",
	 ),
	 "links"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Ссылки по теме"),
		"field" => "links",
	 ),
);

?>