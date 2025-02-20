<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "news_iline_tid",
		"value" => "Шаблон инф. лент по ID с полным текстом без страниц",
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
	"anons_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Анонс (English)"),
		"field" => "anons_en",
    	),		
/*    "submenu_filter" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("Поставить субменю в Ссылки по теме"),
		"size" => "1",
		"field" => "submenu_filter",
	),
*/	
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
	"rubric" => array(
      "class" => "base::selectItable",
      "prompt" => "Рубрика",
      "keyname" => "id",
      "field" => "rubric",
      "textname" => "rubric",
      "query" => "SELECT c.el_id AS id,c.icont_text AS rubric 
					FROM adm_directories_content AS c
					INNER JOIN adm_directories_content AS s ON s.el_id=c.el_id AND s.icont_var='sort'
					INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=3
					WHERE c.icont_var='text'
					ORDER BY s.icont_text,c.icont_text",
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
	 "no_pages" =>array(
	     "class" => "base::checkbox",
		 "prompt"=>"Без страниц",
		 "field"=>"no_pages",
		 "value"=>"0"
	),
    "full_text_on" =>array(
        "class" => "base::checkbox",
        "prompt"=>"Полный текст новости",
        "field"=>"full_text_on",
        "value"=>"0"
    ),
);

?>