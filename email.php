<?php
if($_SERVER['HTTP_REFERER']=="https://".$_SERVER['SERVER_NAME']."/index.php?page_id=960" || $_SERVER['HTTP_REFERER']=="https://".$_SERVER['SERVER_NAME']."/index.php?page_id=1538")
{
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.'=?UTF-8?B?'.base64_encode('ИМЭМО РАН').'?='.' <memojournal@imemo.ru>' . "\r\n";
	mail($_GET[email], '=?UTF-8?B?'.base64_encode('Статья на imemo.ru').'?=', "Здравствуйте, ".iconv("cp1251", "utf-8", $_GET[fio])."!<br><br>Сообщаем Вам, что Ваш материал \"".iconv("cp1251", "utf-8", $_GET[name])."\" дошел до редакции.<br><br>С уважением,<br>imemo.ru",	$headers);
	header("Location: ".$_GET[file]);
}
else
{
	echo "У вас нет прав для просмотра этой страницы.";
}
?>