<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "podr",
		"value" => "������ ������������� (������)",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "101",
		"field" => "title",
		"buttons" => "quot",
        "required" => TRUE,
	),
	"title_en"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title �� ����������"),
		"size" => "101",
		"field" => "title_en",
		"buttons" => "quot",
	),
    "title_r"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("�������� � ����������� ������"),
        "size" => "101",
        "field" => "title_r",
        "required" => TRUE,
    ),
    "title_t"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("�������� � ������������ ������"),
        "size" => "101",
        "field" => "title_t",
        "required" => TRUE,
    ),
    "contest_no_include" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("��������� ��� ���������� ���� � ���������� ��������"),
        "field" => "contest_no_include",
    ),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),
    "chif" => array(
      "class" => "base::selectItable",
      "prompt" => "������������",
      "keyname" => "id",
      "field" => "chif",
      "textname" => "fio",
      "query" => "SELECT id,CONCAT(surname,' ',name,' ',fname) AS fio  FROM persons
					 ORDER BY surname,name,fname",
      ),
     "sekretar" => array(
      "class" => "base::selectItable",
      "prompt" => "������ ���������",
      "keyname" => "id",
      "field" => "sekretar",
      "textname" => "fio",
      "query" => "SELECT id,CONCAT(surname,' ',name,' ',fname) AS fio  FROM persons
					 ORDER BY surname,name,fname",
      ),
    "content_before_for"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("������� ����� ������������ ������������"),
        "field" => "content_before_for",
    ),
    "content_before_for_en"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("������� ����� ������������ ������������ (En)"),
        "field" => "content_before_for_en",
    ),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("�������"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������� �� ����������"),
		"field" => "content_en",
	),
    "personal_list_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("��������� ������ �����������"),
        "field" => "personal_list_off",
    ),
    "news_link_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("��������� ������ �� ������� �������������"),
        "field" => "news_link_off",
    ),
    "events_link_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("��������� ������ �� ����������� �������������"),
        "field" => "events_link_off",
    ),
    "list_link_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("��������� ������ � ������ �������������"),
        "field" => "list_link_off",
    ),
    "grant_link_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("��������� ����� �������"),
        "field" => "grant_link_off",
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

        "full_id-p"     => array(
	       "class" => "base::integer",
	       "prompt" => Dreamedit::translate("ID �������� �������"),
	       "size" => "10",
	       "field" => "full_id_p",
	       "value" => "453",
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