<?
// переводы в ./translate/ru_RU/LC_MESSAGES/DreamEdit.mo
$ext = array_flip(get_loaded_extensions());
if(isset($ext["gettext"]))
{
	setlocale(LC_ALL, 'ru_RU');
	bindtextdomain("DreamEdit", "./translate");
	textdomain("DreamEdit");
}

?>