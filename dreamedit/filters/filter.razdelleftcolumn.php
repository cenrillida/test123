<?
global $page_content;

$headers = new Headers();

$elements = $headers->getHeaderElements("Раздел - Левая колонка");




if(!empty($elements))
{
	$last = "";
	$klast = -1;
	foreach($elements as $k => $v)
	{		if(($v["cclass"]=="Целый")&&($klast>=0)&&($last =="ПЛ"))
		{
			$elements[$klast]["cclass"] = "Целый";
		}
		if(($v["cclass"]=="Половина") &&($last== ""))
		{			$elements[$k]["cclass"] = "Половина Левая";
			$last = "ПЛ";		}
		else if(($v["cclass"]=="Половина") &&($last== "ПЛ"))
		{
			$elements[$k]["cclass"] = "Половина Правая";
			$last = "";		}

		if($v["cclass"] == "Целый")
			$last = "";

		$klast = $k;
	}


	if($last == "ПЛ")
		$elements[$klast]["cclass"] = "Целый";

	$i=1;
	foreach($elements as $k => $v)
	{
		if($v["cclass"] == "Половина Левая")
			echo "<div class='clear indent-col'>\n";
		else if($v["cclass"] == "Целый")
			echo "<div class='clear'>\n";
		$tpl = new Templater();
		$tpl->setValues($v);
  		if($v["ctype"] == "Фильтр")
			 $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));

    	$tpl->appendValues(array("EQUALNUMBER" => $i));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");

		if($v["cclass"] != "Половина Левая")
			echo "</div>\n";

		if($v["cclass"] == "Половина Правая")
			$i++;


	}
}


?>