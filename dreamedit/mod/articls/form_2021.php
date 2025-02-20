<?
function findNumberIDbyArticleID($id) {
	global $DB;
	//$page_parent = $DB->select("SELECT page_parent FROM adm_article WHERE page_id=".(int)$id);
	if($id!=0) {
		$number = $DB->select("SELECT page_parent, page_template FROM adm_article WHERE page_id=".$id);
		if(!empty($number)) {
			if($number[0][page_template]=='jnumber')
				return $id;
			else 
				return findNumberIDbyArticleID((int)$number[0][page_parent]);
		}
	}
	return 0;
}

$affiliationsArray = array();
$organizationNameArray = array();
$organizationNameEnArray = array();

if (!empty($_REQUEST["id"]))
{

    $jj=$DB->select("SELECT n.page_template,n.year,n.page_name AS number,n.page_name_en AS number_en,n.j_name,n.journal AS jid,n.journal_new AS jid_new, n.people_affiliation_en AS people_affiliation_en, n.organization_name AS organization_name, n.organization_name_en AS organization_name_en FROM adm_article AS n

                 WHERE n.page_id=".$_REQUEST["id"]);

    if(!empty($jj[0]['people_affiliation_en'])) {
        $affiliationsArray = unserialize($jj[0]['people_affiliation_en']);
    }

    if(!empty($jj[0]['organization_name'])) {
        $organizationNameArray = unserialize($jj[0]['organization_name']);
    }
    if(!empty($jj[0]['organization_name_en'])) {
        $organizationNameEnArray = unserialize($jj[0]['organization_name_en']);
    }

 $rr=$DB->select("SELECT n.page_template FROM adm_article AS c
                  INNER JOIN adm_article AS n ON n.page_id=c.page_parent
                  WHERE c.page_id=".$_REQUEST["id"]);

//  print_r($jj);
  if ($jj[0][page_template]!="jnumber" && $jj[0][page_template]!="jnumber_cut")
  {
	  if ($rr[0][page_template]=="jrubric")
	  $jj=$DB->select("SELECT p.page_name AS rubric,n.year,n.page_name AS number,n.page_name_en AS number_en,n.j_name,n.journal AS jid,n.journal_new AS jid_new FROM adm_article AS c
	                   INNER JOIN adm_article AS p ON p.page_id=c.page_parent
	                   INNER JOIN adm_article AS n ON n.page_id=p.page_parent
	                   WHERE c.page_id=".$_REQUEST["id"]);
	  else
	  $jj=$DB->select("SELECT '***' AS rubric,n.year,n.page_name AS number,n.page_name_en AS number_en,n.j_name,n.journal AS jid,n.journal_new AS jid_new FROM adm_article AS c
	                   INNER JOIN adm_article AS n ON n.page_id=c.page_parent

	                   WHERE c.page_id=".$_REQUEST["id"]);


  }
//  print_r($jj);
  echo "<br />������ <b>".$jj[0][j_name]."</b> ����� <b>".$jj[0][number]."</b> �� <b>".$jj[0][year].
        "</b> ������� <b>".$jj[0][rubric]."</b> <br /><br />";
  $j_num=$jj[0][j_name]."-".$jj[0][number]."-".$jj[0][year];
}
//  print_r($jj);
// ��������� �������
/*
$avt=$DB->select("SELECT count(id) AS count FROM persons WHERE journal='".$j_num."' AND error=1");
if ($avt[0]['count']!=0)
{
   echo '<a href=/dreamedit/index.php?mod=personal&oper=show&jour="'.$j_num.' AND error=1">'.
   "<br />�� ������� ���������� � ������� ����� ������. ������� � ������ �����������</a>";
}
if (!empty($_REQUEST["id"]))
{
$avt0=$DB->select("SELECT id, CONCAT(surname,' ',name,' ',fname) AS fio  FROM persona WHERE id_article=".$_REQUEST["id"]." AND error=1");
foreach($avt0 as $avt)
{
	 echo "<br /><a href=/".$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=personal&oper=remake&oi=".$avt[id].">".
	 "������ �������� ��� ������ <b>".$avt[fio]."</b></a>";
}
}
*/
if (empty($jj[0][journal])) $jj[0][journal]=0;

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
			"prompt" => Dreamedit::translate("!������"),
			"value" => (int)@$_REQUEST["id"],
			"field" => "page_parent",
			"size" => "10",
			"buttons" => "article_id",
		),
        "template" => array(
			"class" => "base::selectbox",
			"prompt" => Dreamedit::translate("������"),
			"options" => site_templates(),
			"field" => "page_template",
			"value"=> "jarticle",
		),
        "article_special_template" => array(
            "class" => "base::selectbox",
            "prompt" => Dreamedit::translate("����������� ������ ������"),
            "options" => array("" => "", "mag_article_2021" => "������ 2021 ����"),
            "field" => "article_special_template",
            "value"=> "mag_article_2021",
        ),
		"page_name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�������� ��� �������"),
			"required" => TRUE,
			"size" => "81",
			"field" => "page_name",
		),

		"name" => array(
			"class" => "base::textarea",
			"prompt" => Dreamedit::translate("�������� ������"),
			"required" => TRUE,
			"cols" => "81",
			"rows"=>"3",
			"field" => "name",
		),
		"name_en" => array(
			"class" => "base::textarea",
			"prompt" => Dreamedit::translate("�������� �� ����������"),
			"cols" => "81",
			"rows"=>"3",
			"field" => "name_en",
        ),
        "article_url" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("����� ��������"),
            "size" => "101",
            "field" => "article_url",
            "buttons" => "generator",
            "generate_fields" => array("name_en", "name"),
        ),
        "name_black" => array(
            "class" => "base::textarea",
            "prompt" => Dreamedit::translate("������ ����� � ��������"),
            "cols" => "81",
            "help" => "����� ������ �� �������� ������ ����� �������� � ������ �����(��� ����������)",
            "rows"=>"3",
            "field" => "name_black",
        ),
        "name_black_en" => array(
            "class" => "base::textarea",
            "prompt" => Dreamedit::translate("������ ����� � �������� (En)"),
            "cols" => "81",
            "rows"=>"3",
            "field" => "name_black_en",
        ),
        "rinc" => array(
			"class" => "base::textarea",
			"prompt" => Dreamedit::translate("��������� � ����"),
			"cols" => "81",
			"rows"=>"3",
			"field" => "rinc",
        ),
        "id_of_article" => array(
			"class" => "base::textarea",
			"prompt" => Dreamedit::translate("ID ������ �� ����� �������"),
			"cols" => "81",
			"rows"=>"1",
			"field" => "id_of_article",
        ),
        "doi" => array(
			"class" => "base::textarea",
			"prompt" => Dreamedit::translate("DOI"),
			"cols" => "81",
			"rows"=>"3",
			"field" => "doi",
        ),
        "edn" => array(
            "class" => "base::textarea",
            "prompt" => Dreamedit::translate("EDN"),
            "cols" => "81",
            "rows"=>"3",
            "field" => "edn",
        ),

        "people" => array(
            "class" => "base::peopleAffiliation",
            "prompt" => Dreamedit::translate("������"),
            "required" => TRUE,
            "field" => "people",
            "people_affiliation_en" => $affiliationsArray,
            "organization_name" => $organizationNameArray,
            "organization_name_en" => $organizationNameEnArray
        ),
        "citation_authors_correct" => array(
            "class" => "base::textarea",
            "prompt" => Dreamedit::translate("������ ��� ���������� ������"),
            "cols" => "121",
            "rows"=>"1",
            "field" => "citation_authors_correct",
        ),
        "citation_authors_correct_en" => array(
            "class" => "base::textarea",
            "prompt" => Dreamedit::translate("������ ��� ���������� ������ (En)"),
            "cols" => "121",
            "rows"=>"1",
            "field" => "citation_authors_correct_en",
        ),
		"affiliation" => array(
			"class" => "base::editor_half",
			"prompt" => Dreamedit::translate("�� ������"),
            "cols" => "81",
			"rows"=>"5",
			"field" => "affiliation",

		),
        "affiliation_en" => array(
			"class" => "base::editor_half",
			"prompt" => Dreamedit::translate("�� ������ �� ����������"),
            "cols" => "81",
			"rows"=>"5",
			"field" => "affiliation_en",

		),
        "atype" => array(
			"class" => "base::selecttextbox",
			"prompt" => Dreamedit::translate("��� ������"),
			"field" => "atype",
			"texts" => "EDI|RAR",

		),
        "published_date_text" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("������ ��������� � ��������"),
            "field" => "published_date_text",

        ),
        "published_date_text_en" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("������ ��������� � �������� (En)"),
            "field" => "published_date_text_en",

        ),
		"annots" => array(
			"class" => "base::editor",
			"prompt" => Dreamedit::translate("���������"),
			"field" => "annots",

		),
        "annots_en" => array(
			"class" => "base::editor",
			"prompt" => Dreamedit::translate("��������� �� ����������"),
			"field" => "annots_en",

		),
        "add_text" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("����� ��������� � <br>��������� �������"),
            "field" => "add_text",

        ),
        "add_text_en" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("����� ��������� � <br>��������� ������� �� ����������"),
            "field" => "add_text_en",

        ),
		"keyword" => array(
			"class" => "base::editor_half",
			"prompt" => Dreamedit::translate("�������� �����"),
			"field" => "keyword",

		),
		"keyword_en" => array(
			"class" => "base::editor_half",
			"prompt" => Dreamedit::translate("�������� ����� �� ����������"),
			"field" => "keyword_en",

		),
		"tags" => array(
			"class" => "base::tags",
			"prompt" => Dreamedit::translate("����"),
			"field" => "tags",
			"cols" =>"60",
			"rows" =>"10",
		),
        "references" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("������ ����������"),
            "field" => "references",

        ),
        "references_en" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("������ ���������� �� ����������"),
            "field" => "references_en",

        ),
        "sources" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("������ ���������"),
            "field" => "sources",
        ),
        "sources_en" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("������ ��������� �� ����������"),
            "field" => "sources_en",
        ),
        "contents" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("����� ������"),
            "field" => "contents",

        ),
        "contents_en" => array(
            "class" => "base::editor",
            "prompt" => Dreamedit::translate("����� ������ �� ����������"),
            "field" => "contents_en",

        ),
		"links"     => array(
			"class"  => "base::editor",
			"name" => "links",
	        "prompt" => Dreamedit::translate("������������"),
	        "field" =>"links",

	    ),
		"link" => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("������ �� ����� � pdf"),
			"field" => "link",
 //           "value"=>'<img height="22" width="22" src="http://www.vestnik.isras.ru/files/Image/pdf.gif" alt="" />',
		),
		"link_en" => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("������ �� ����� � pdf (En)"),
			"field" => "link_en",
		),
		"fulltext_open" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("������� pdf ��� ������ �������"),
			"value" => "0",
			"options" => "",
			"field" => "fulltext_open",
		),
        "author_open_text" => array(
            "class" => "base::checkbox",
            "prompt" => Dreamedit::translate("������� pdf � ����������� ������"),
            "value" => "0",
            "options" => "",
            "field" => "author_open_text",
        ),
		"pages" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�������� � �������"),
			"size" => "41",
			"field" => "pages",

		),
        "to_publs_list" => array(
            "class" => "base::checkbox",
            "prompt" => Dreamedit::translate("� ������ ����������"),
            "value" => "0",
            "options" => "",
            "field" => "to_publs_list",
        ),
		"page_status" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("������"),
			"value" => "1",
			"options" => "",
			"field" => "page_status",
		),
        "page_status_en" => array(
            "class" => "base::checkbox",
            "prompt" => Dreamedit::translate("������ (En)"),
            "value" => "1",
            "options" => "",
            "field" => "page_status_en",
        ),
		"order" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("�������������"),
			"value" => "0",
			"options" => "",
			"field" => "order",
		),
        "j_name" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("����� �������"),
			"size" => "41",
			"field" => "j_name",
			"value" => $j_num,
		),
		"date" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("������� ����"),
			"size" => "41",
			"field" => "date",
			"value" => date('Ymd'),
		),
		"year" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("���"),
			"size" => "41",
			"field" => "year",
			"value" => $jj[0][year],
		),
		"number" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("����� �������"),
			"size" => "41",
			"field" => "number",
			"value" => $jj[0][number],
		),
		"number_en" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("����� ������� (En)"),
			"size" => "41",
			"field" => "number_en",
			"value" => $jj[0][number_en],
		),
		"journal" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("������ �� ������"),
			"size" => "41",
			"field" => "journal",
			"value" => $jj[0][jid],
		),
        "journal_new" => array(
            "class" => "base::hidden",
            "prompt" => Dreamedit::translate("������ �� ������"),
            "size" => "41",
            "field" => "journal_new",
            "value" => $jj[0][jid_new],
        ),
		"jid" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("������ �� ����� ������"),
			"size" => "41",
			"value" => findNumberIDbyArticleID((int)@$_REQUEST["id"]),
		),
		"order" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("order"),
			"size" => "41",
			"field" => "order",
			"value" => "0",
		),
	),
);


if($_CONFIG["global"]["general"]["test"])
{
	$mod_array["components"]["dell"] = array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("����������"),
		"value" => "0",
		"options" => "",
		"field" => "page_dell",
	);
}
?>