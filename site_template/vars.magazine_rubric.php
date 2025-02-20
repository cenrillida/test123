<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "magazine_rubric",
		"value" => "Журнал. Статьи в рубрике",
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
    "number" => array(
			"class" => "base::selectItable",
			"prompt" => Dreamedit::translate("Журнал"),
			"value" => (int)@$_REQUEST["id"],
			"keyname" => "jid",
			"textname"=> "page_name",
			"query"=>"
			SELECT page_id AS jid,CONCAT(j_name,'-',year,'-',page_name) AS page_name FROM adm_article WHERE page_template='jnumber' AND journal IN
			(SELECT cv_text AS journal FROM adm_pages_content WHERE cv_name='itype_jour' AND page_id IN
			(SELECT DISTINCT p1.page_id AS journal FROM adm_pages AS p1
			         INNER JOIN adm_pages AS p3 ON p3.page_id=".$_REQUEST["id"].
					 " INNER JOIN adm_pages AS p2 ON p2.page_id=p3.page_parent
			           WHERE p1.page_id=p2.page_parent
			 )
			 )
			 AND year IN
			         (SELECT p1.page_name AS year FROM adm_pages AS p1
			         INNER JOIN adm_pages AS p3 ON p1.page_id=p3.page_parent
			         WHERE p3.page_id=".$_REQUEST['id'].")"


             ,
			"field" => "number",
			"size" => "10",

		),
	"reclama"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Рекламный блок"),
		"field" => "reclama",
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

);

?>