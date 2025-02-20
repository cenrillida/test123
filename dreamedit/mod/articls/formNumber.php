<?
$value_jour='';
$value_jour_new='';
$value_num='';
$value_number_en='';
$value_year='';
$value_tpl='jnumber';
if (!empty($_REQUEST["id"]) && $_REQUEST["id"]!=0 && $_REQUEST[action]!='add' || $_REQUEST[action]=='addRb')
{
   $param=$DB->select("SELECT * FROM adm_article WHERE page_id=".$_REQUEST["id"]);
   $value_jour=$param[0][journal];
    $value_jour_new=$param[0][journal_new];
   if ($param[0][page_template]=="jrubric") $value_num=$param[0][page_name];
   if ($param[0][page_template]=="jrubric") $value_number_en=$param[0][page_name_en];
   if (empty($value_num)) $value_num=$_POST[page_name];
   if (empty($value_number_en)) $value_number_en=$_POST[page_name_en];
   $value_year=$param[0][year];
   if ($_REQUEST[action]=='addRb') $value_tpl='jrubric';
   $value_num_en=$param[0][name_en];
   if ($param[0][page_template]=='jrubric') $_REQUEST[action]='addRb';
}
else
{
	if (!empty($_REQUEST[id]))
	  $param=$DB->select("SELECT journal,page_name,page_template,journal_new FROM adm_article WHERE page_id=".$_REQUEST[id]);
	 // print_r($param);
	  $value_jour=$param[0][journal];
    $value_jour_new=$param[0][journal_new];
	  if (is_numeric($param[0][page_name]))
	  {
		
		$value_year=$param[0][page_name];
	  }
	  else	
		$value_year='0000';
	  $value_num='0';
	
}
if ($_REQUEST[action]!='addRb')
{
$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id"		=> array (
			"class"				=> "base::hidden",
			"field"				=> "page_id",
		),
		"parent" => array(
			"class" => "base::integer",
			"prompt" => Dreamedit::translate("Внутри"),
			"value" => (int)@$_REQUEST["id"],
			"field" => "page_parent",
			"size" => "10",
			"buttons" => "article_id",
		),
		"journal" => array(
			"class" => "base::selectItable",
			"prompt" => Dreamedit::translate("Журнал"),
			"value" => (int)@$_REQUEST["id"],
			"keyname" => "jid",
			"textname"=> "page_name",
			"query"=>"SELECT DISTINCT page_id AS jid,page_name FROM adm_magazine WHERE page_parent=0 ORDER BY page_name ",
			"field" => "journal",
			"size" => "1",
            "value" => $value_jour,
		),
        "journal_new" => array(
            "class" => "base::selectItable",
            "prompt" => Dreamedit::translate("Журнал"),
            "value" => (int)@$_REQUEST["id"],
            "keyname" => "jid",
            "textname"=> "page_name",
            "query"=>"SELECT DISTINCT page_id AS jid,page_name FROM adm_pages WHERE page_template='mag_index' ORDER BY page_name ",
            "field" => "journal_new",
            "size" => "1",
            "value" => $value_jour_new,
        ),

		"page_name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Номер журнала"),
			"size" => "61",
			"field" => "page_name",
			"required" => TRUE,
			"value" => $value_num,
		),
		"page_name_en" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Номер журнала (En)"),
			"size" => "61",
			"field" => "page_name_en",
			"value" => $value_number_en,
		),
        "special_issue_name" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("Название специального выпуска"),
            "size" => "61",
            "field" => "special_issue_name",
        ),
        "special_issue_name_en" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("Название специального выпуска (En)"),
            "size" => "61",
            "field" => "special_issue_name_en",
        ),
        "number_title" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("Номер для заголовка"),
            "size" => "61",
            "field" => "number_title",
        ),
        "number_title_en" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("Номер для заголовка (En)"),
            "size" => "61",
            "field" => "number_title_en",
        ),
        "editors_title" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("Редакторы"),
            "size" => "61",
            "field" => "editors_title",
        ),
        "editors_title_en" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("Редакторы (En)"),
            "size" => "61",
            "field" => "editors_title_en",
        ),
        "article_url" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("Адрес страницы"),
            "size" => "101",
            "field" => "article_url",
            "buttons" => "generator",
            "generate_fields" => array("page_name_en", "page_name"),
        ),
		"name_en" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("Название рубрики на английском"),
			"size" => "80",
			"field" => "name_en",
			"value" => $value_num_en,
		),
		"year" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Год"),
			"size" => "11",
			"field" => "year",
			"required" => TRUE,
			"value" => $value_year,
		),

		"template" => array(
			"class" => "base::selectbox",
			"prompt" => Dreamedit::translate("Шаблон"),
			"options" => site_templates(),
			"field" => "page_template",
			"value"=> $value_tpl,
		),
		"page_status" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("Статус"),
			"value" => "1",
			"options" => "",
			"field" => "page_status",
		),


       	"j_name" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("Журнал (не заполнять)"),
			"type"=>"edit",
			"field" => "j_name",

		),
        "date" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("Текущая дата"),
			"size" => "41",
			"field" => "date",
			"value" => date('Ymd'),
		),


	),
);
}
else
{

$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id"		=> array (
			"class"				=> "base::hidden",
			"field"				=> "page_id",
		),
		"parent" => array(
			"class" => "base::integer",
			"prompt" => Dreamedit::translate("Внутри"),
			"value" => (int)@$_REQUEST["id"],
			"field" => "page_parent",
			"size" => "10",
			"buttons" => "page_id",
		),
		"journal" => array(
			"class" => "base::selectItable",
			"prompt" => Dreamedit::translate("Журнал"),
			"value" => (int)@$_REQUEST["id"],
			"keyname" => "jid",
			"textname"=> "page_name",
			"query"=>"SELECT DISTINCT page_id AS jid,page_name FROM adm_magazine WHERE page_parent=0 ORDER BY page_name ",
			"field" => "journal",
			"size" => "1",
            "value" => $value_jour,
		),
        "journal_new" => array(
            "class" => "base::selectItable",
            "prompt" => Dreamedit::translate("Журнал"),
            "value" => (int)@$_REQUEST["id"],
            "keyname" => "jid",
            "textname"=> "page_name",
            "query"=>"SELECT DISTINCT page_id AS jid,page_name FROM adm_pages WHERE page_template='mag_index' ORDER BY page_name ",
            "field" => "journal_new",
            "size" => "1",
            "value" => $value_jour_new,
        ),

		"page_name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название рубрики"),
			"size" => "80",
			"field" => "page_name",
			"required" => TRUE,
			"value" => $value_num,
		),
		"name_en" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название рубрики на английском"),
			"size" => "80",
			"field" => "name_en",
			"value" => $value_num_en,
		),
        "article_url" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("Адрес страницы"),
            "size" => "101",
            "field" => "article_url",
            "buttons" => "generator",
            "generate_fields" => array("name_en", "page_name"),
        ),

		"template" => array(
			"class" => "base::selectbox",
			"prompt" => Dreamedit::translate("Шаблон"),
			"options" => site_templates(),
			"field" => "page_template",
			"value"=> $value_tpl,
		),
		"page_status" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("Статус"),
			"value" => "1",
			"options" => "",
			"field" => "page_status",
		),


       	"j_name" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("Журнал (не заполнять)"),
			"type"=>"edit",
			"field" => "j_name",

		),
        "date" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("Текущая дата"),
			"size" => "41",
			"field" => "date",
			"value" => date('Ymd'),
		),


	),
);

}

?>