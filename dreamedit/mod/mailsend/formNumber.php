<?
$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "index.php?mod=mailsend&action=save",
	"components"	=> array (
		"from_name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�� ���� (���)"),
			"field" => "from_name",
			"required" => true,
		),
		"from_email" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�� ���� (email)"),
			"field" => "from_email",
			"required" => true,
			'validate_method'	=> 'base::email',
		),
		'mails_send'		=> array (
			'class'				=> 'base::file',
			"prompt" => Dreamedit::translate("������ email"),
			'size'				=> '30',
			"required" => true,
		),
		"etext" => array(
			"class" => "base::editor",
			"prompt" => Dreamedit::translate("����� ���������"),
			"help" => "%NAME% - ���.<br> %THIRDNAME% - ��������(��� �������).<br> %WORDEND% - (-��) ��� (-��)",
			"field" => "etext",
			"required" => true,
		),
		'submit'		=> array (
			'class'				=> 'base::button',
			'type'				=> 'submit',
			'value'				=> '���������',
		),
	),
);

?>