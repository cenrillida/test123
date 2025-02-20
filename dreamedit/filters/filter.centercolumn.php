<?
global $page_content;

$headers = new Headers();

$elements = $headers->getHeaderElements("Главная - Центральная колонка");


if(!empty($elements))
{
	$num = 2;
	foreach($elements as $k => $v)
	{

		$tpl = new Templater();
		$tpl->setValues($v);
  		if($v["ctype"] == "Фильтр")
			 $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));

		if($num > 1)
			$tpl->appendValues(array("NEEDMARGIN" => "marg_top1"));
		else 
			$tpl->appendValues(array("NEEDMARGIN" => ""));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");

		$num++;
	}
}
?>