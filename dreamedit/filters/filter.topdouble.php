<?
global $page_content;

$headers = new Headers();

$elements = $headers->getHeaderElements("Главная - Двойной верхний блок");

if(!empty($elements))
{
	
	foreach($elements as $k => $v)
	{		$tpl = new Templater();
		$tpl->setValues($v);
  		if($v["ctype"] == "Фильтр")
			 $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));

    	$tpl->appendValues(array("EQUALNUMBER" => $i));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");


		}
	
}
?>
