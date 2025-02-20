<?
global $page_content;

$headers = new Headers();

$elements = $headers->getHeaderElements("Главная - Левая колонка");


if(!empty($elements))
{
	$num = 2; //отступ нужен сразу
	foreach($elements as $k => $v)
	{
		$tpl = new Templater();
		$tpl->setValues($v);
  		if($v["ctype"] == "Фильтр")
			 $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));



	echo '<div class="box">';
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	echo '</div>';

	}
	if($_GET[publ_smi]==1)
	{
		$tpl = new Templater();
		$v["ctype"]="Фильтр";
		$tpl->setValues($v);
		$tpl->appendValues(array("FILTERCONTENT" => $page_content["SMI_PUBL"]));



		echo '<div class="box">';
			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
		echo '</div>';
	}


	echo '<div class="cleaner">&nbsp;</div>';
}
?>