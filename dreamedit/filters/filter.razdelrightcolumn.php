<?
global $page_content;

$headers = new Headers();

$elements = $headers->getHeaderElements("������  - ������ �������");


if(!empty($elements))
{
	foreach($elements as $k => $v)
	{		$tpl = new Templater();
		$tpl->setValues($v);
  		if($v["ctype"] == "������")
			 $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	}
}


?>