<?
global $page_content;

$headers = new Headers();
if ($_SESSION[jour]!='/jour' && $_SESSION[jour]!='/jour_cut')
	$elements = $headers->getHeaderElements("Главная - Баннер");
else
{	
    	$elements = $headers->getJourBanner();
}

//print_r($elements);
if(!empty($elements) && $_SESSION[jour]!='/jour' && $_SESSION[jour]!='/jour_cut')
{
echo '<div class="box" id="featPosts">';
	foreach($elements as $k => $v)
	{
	
		$tpl = new Templater();
		$tpl->setValues($v);
  		if($v["ctype"] == "Фильтр")
			 $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));

    	$tpl->appendValues(array("EQUALNUMBER" => $i));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");
	}
echo '</div>';
}
else
{
$aa['Баннер']=$elements[0];
echo '<div class="box" id="featPosts">';
$tpl = new Templater();
		$tpl->setValues($aa['Баннер']);
  //		if($v["ctype"] == "Фильтр")
	//		 $tpl->appendValues(array("FILTERCONTENT" => $aa));

    	$tpl->appendValues(array("EQUALNUMBER" => $i));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");

echo '</div>';
}

?>
