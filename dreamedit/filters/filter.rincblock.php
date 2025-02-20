<?
// Информация из РИНЦ

global $_CONFIG;

//include_once 'simple_html_dom.php';

//phpinfo();

if ($_SESSION[lang]!='/en')
{
	
	//include "rincblock/count.php";
	//$html = file_get_html('http://elibrary.ru/');
	
	/*$ch = curl_init('http://php.su');
	curl_exec($ch); // выполняем запрос curl - обращаемся к сервера php.su
	curl_close($ch);*/
	
	// Инициализируем курл
	//$ch = curl_init('http://elibrary.ru/org_profile.asp?id=5574');

	// Параметры курла
	/*curl_setopt($ch, CURLOPT_USERAGENT, 'IE20');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	// Следующая опция необходима для того, чтобы функция curl_exec() возвращала значение а не выводила содержимое переменной на экран
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');

	// Получаем html
	$text = curl_exec($ch);

	// Отключаемся
	curl_close($ch);

	// Находим и сохраняем нужный фрагмент
	preg_match( '/<ul><li>(.*?)<\/li><\/ul>/is' , $text , $links );

	// Выводим результат на экран
	echo $links[0];*/
	
	/*GET ALL LINKS FROM http://www.w3schools.com/asp/default.asp*/
	//$page = file_get_contents('http://elibrary.ru/org_profile.asp');
	//echo $page;
	/*preg_match_all("/<a.*>(.*?)<\/a>/", $page, $matches, PREG_SET_ORDER);
	echo "All links : <br/>";
	foreach($matches as $match)
	{
		echo $match[1]."<br/>";
	}*/
	
	
	// Find all images 
	/*foreach($html->find('img') as $element) 
       echo $element->src . '<br>';

	foreach($html->find('a') as $element) 
       echo $element->href . '<br>';*/
	//$html = file_get_contents('http://elibrary.ru/org_profile.asp?id=5574');

	//$list_=$html->find('a[title=Список публикаций данной организации в РИНЦ]', 0)->innertext;
	//echo "<a hidden=true src=aaa>".$list_."</a>";
	
	echo "<p style='white-space: normal; word-spacing: 0px; text-transform: none; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; letter-spacing: normal; text-indent: 0px; -webkit-text-stroke-width: 0px'><img alt='' width=150 height=33 src=https://www.imemo.ru/files/Image/rinc/elibrary_logo.gif></p>";
	?>
	<p style="white-space: normal; word-spacing: 0px; text-transform: none; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; letter-spacing: normal; text-indent: 0px; -webkit-text-stroke-width: 0px">
<table style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; border-left: rgb(211,211,211) 1px dotted" cellspacing="1" cellpadding="1" width="100%" border="0">
    <tbody>
        <tr>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">Общее число публикаций организации в РИНЦ</td>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">
            <p align="right"><? include "rincblock/block1.php"; ?></p>
            </td>
        </tr>
        <tr>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">Суммарное число цитирований публикаций организации</td>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">
            <p align="right"><? include "rincblock/block2.php"; ?></p>
            </td>
        </tr>
        <tr>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">h-индекс (индекс Хирша)</td>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">
            <p align="right"><? include "rincblock/block3.php"; ?></p>
            </td>
        </tr>
        <tr>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">Позиция&nbsp;в общем рейтинге организаций по индексу Хирша</td>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">
            <p align="right"><? include "rincblock/block4.php"; ?></p>
            </td>
        </tr>
    </tbody>
</table>
</p>
	<a target="_blank" href="http://elibrary.ru/org_profile.asp?id=5574">Подробнее см. на сайте http://elibrary.ru</a>
	
	
	<?
}
else
{
	//$html = file_get_contents('http://elibrary.ru/org_profile.asp?id=5574');
	
	//echo $html;
	
	//$list_=$html->find('a[title=Список публикаций данной организации в РИНЦ]', 0)->innertext;
	//echo "<a hidden=true src=aaa>".$list_."</a>";
	
	echo "<p style='white-space: normal; word-spacing: 0px; text-transform: none; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; letter-spacing: normal; text-indent: 0px; -webkit-text-stroke-width: 0px'><img alt='' width=150 height=33 src=https://www.imemo.ru/files/Image/rinc/elibrary_logo.gif></p>";
	?>
	<p style="white-space: normal; word-spacing: 0px; text-transform: none; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; letter-spacing: normal; text-indent: 0px; -webkit-text-stroke-width: 0px">
<table style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; border-left: rgb(211,211,211) 1px dotted" cellspacing="1" cellpadding="1" width="100%" border="0">
    <tbody>
        <tr>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">Total number of organization publications in RINС</td>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">
            <p align="right"><? include "rincblock/block1.php"; ?></p>
            </td>
        </tr>
        <tr>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">The total number of citations of organization publications</td>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">
            <p align="right"><? include "rincblock/block2.php"; ?></p>
            </td>
        </tr>
        <tr>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">h-index (Hirsch index)</td>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">
            <p align="right"><? include "rincblock/block3.php"; ?></p>
            </td>
        </tr>
        <tr>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">Position overall organizations rating by Hirsch index</td>
            <td style="border-top: rgb(211,211,211) 1px dotted; border-right: rgb(211,211,211) 1px dotted; border-bottom: rgb(211,211,211) 1px dotted; color: rgb(0,0,0); font: 12px Arial, Verdana, Helvetica, sans-serif; border-left: rgb(211,211,211) 1px dotted">
            <p align="right"><? include "rincblock/block4.php"; ?></p>
            </td>
        </tr>
    </tbody>
</table>
</p>
	<a target="_blank" href="https://imemo.ru/links.php?go=http://elibrary.ru/org_profile.asp?id=5574">More on http://elibrary.ru</a>
	
	
	<?
}


?>