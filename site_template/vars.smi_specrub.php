<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "smi_specrub",
		"value" => "Шаблон спецрубрик",
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

	"anons"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Анонс"),
		"field" => "anons",
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
	"full_smi_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID документа с полной новостью"),
		"size" => "10",
		"field" => "full_smi_id",
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
	"tpl_name"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Имя шаблона tpl"),
		"size" => "51",
		"field" => "tpl_name",
	),

);

?>