<?
global $page_content;

$headers = new Headers();

$elements = $headers->getHeaderElements("������ - ����� �������");




if(!empty($elements))
{
	$last = "";
	$klast = -1;
	foreach($elements as $k => $v)
	{		if(($v["cclass"]=="�����")&&($klast>=0)&&($last =="��"))
		{
			$elements[$klast]["cclass"] = "�����";
		}
		if(($v["cclass"]=="��������") &&($last== ""))
		{			$elements[$k]["cclass"] = "�������� �����";
			$last = "��";		}
		else if(($v["cclass"]=="��������") &&($last== "��"))
		{
			$elements[$k]["cclass"] = "�������� ������";
			$last = "";		}

		if($v["cclass"] == "�����")
			$last = "";

		$klast = $k;
	}


	if($last == "��")
		$elements[$klast]["cclass"] = "�����";

	$i=1;
	foreach($elements as $k => $v)
	{
		if($v["cclass"] == "�������� �����")
			echo "<div class='clear indent-col'>\n";
		else if($v["cclass"] == "�����")
			echo "<div class='clear'>\n";
		$tpl = new Templater();
		$tpl->setValues($v);
  		if($v["ctype"] == "������")
			 $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));

    	$tpl->appendValues(array("EQUALNUMBER" => $i));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");

		if($v["cclass"] != "�������� �����")
			echo "</div>\n";

		if($v["cclass"] == "�������� ������")
			$i++;


	}
}


?>