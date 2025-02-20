<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "sem",
		"value" => "�������. ��������",
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
		"prompt" => Dreamedit::translate("Title �� ����������"),
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
    "sem" => array(
      "class" => "base::selectItable",
      "prompt" => "�������",
      "keyname" => "id",
      "field" => "sem",
      "textname" => "sem",
      "query" => "SELECT c.el_id AS id,c.icont_text AS sem
                    FROM adm_directories_content AS c
                    INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=15
                    WHERE c.icont_var='text'
					 ORDER BY c.icont_text",
      ),
    "archive_sem" => array(
        "class" => "base::selectItable",
        "prompt" => "�������� �������",
        "keyname" => "id",
        "field" => "archive_sem",
        "textname" => "sem",
        "query" => "SELECT c.el_id AS id,c.icont_text AS sem
                    FROM adm_directories_content AS c
                    INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=15
                    WHERE c.icont_var='text'
					 ORDER BY c.icont_text",
    ),
/*
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������ �� ����������"),
		"field" => "content_en",
	),

	"submenu_filter" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("��������� ������� � ������ �� ����"),
		"size" => "1",
		"field" => "submenu_filter",
	),
	"links"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������ �� ����"),
		"field" => "links",
	),
*/
    "full_id-p"     => array(
	       "class" => "base::integer",
	       "prompt" => Dreamedit::translate("ID �������� �������"),
	       "size" => "10",
	       "field" => "full_id_p",
	       "value" => "538",
	       "buttons" => "page_id",
	),
	"spisok_page"     => array(
	       "class" => "base::integer",
	       "prompt" => Dreamedit::translate("ID ������ ���������"),
	       "size" => "10",
	       "field" => "spisok_page",
	       "value" => "178",
	       "buttons" => "page_id",
	),
	"people"   => array(
		"class" => "base::people",
		"prompt" => Dreamedit::translate("����"),
		"size" => "81",
		"field" => "people",
	),

);

?>