<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "jnumber",
		"value" => "������. ����� �������!!!",
	),


	"tema"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("�������� �������"),
		"size" => "101",
		"field" => "tema",
		"buttons" => "quot",
	),
	"subject"    => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("���� ������"),
			"field" => "subject",
	),
	"comment" => array(
			"class" => "base::editor",
			"prompt" => Dreamedit::translate("�����������"),
			"field" => "comment",
			"type"=>"Basic",

	),

);

?>