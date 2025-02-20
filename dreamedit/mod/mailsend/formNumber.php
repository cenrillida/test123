<?
$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "index.php?mod=mailsend&action=save",
	"components"	=> array (
		"from_name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("От кого (Имя)"),
			"field" => "from_name",
			"required" => true,
		),
		"from_email" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("От кого (email)"),
			"field" => "from_email",
			"required" => true,
			'validate_method'	=> 'base::email',
		),
		'mails_send'		=> array (
			'class'				=> 'base::file',
			"prompt" => Dreamedit::translate("Адреса email"),
			'size'				=> '30',
			"required" => true,
		),
		"etext" => array(
			"class" => "base::editor",
			"prompt" => Dreamedit::translate("Текст сообщения"),
			"help" => "%NAME% - Имя.<br> %THIRDNAME% - Отчество(или фамилия).<br> %WORDEND% - (-ый) или (-ая)",
			"field" => "etext",
			"required" => true,
		),
		'submit'		=> array (
			'class'				=> 'base::button',
			'type'				=> 'submit',
			'value'				=> 'Отправить',
		),
	),
);

?>