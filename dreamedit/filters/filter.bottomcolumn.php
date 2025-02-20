<?
global $page_content;

$headers = new Headers();
$rows=$headers->getINION();
//print_r($rows);
$elements = $headers->getHeaderElements("Главная - Нижний блок");

if(strpos($_SERVER[REQUEST_URI],"&en") !== false || strpos($_SERVER[REQUEST_URI],"?en") !== false)
$suff="_EN";
else $suff="";


if(!empty($rows))
{
	$num = 1;
	$tr=count($rows);
	if (count($rows)>3) $tr=ceil(count($rows)/2);
	if (count($rows)>6) $tr=ceil(count($rows)/3);

	echo "<table style='width:100%;'><tr><td valign='top'>";
 //   echo "<ul class='cols pad list2'>";
     echo "<ul class='speclist2' style='list-style: url(\"/images/marker_1.gif\") outside ;'>";
	foreach($rows as $k => $v)
	{


//		$tpl = new Templater();
//		$tpl->setValues($v);
//  		if($v["ctype"] == "Фильтр")
			 //$tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));
//			 echo $page_content[$v["fname"]];
//		else
			echo "<li><a href=#  style='color:#404040;list-style: url(\"/images/marker_1.gif\") outside ;'><b>".$v["text".$suff]."</b></a></li>";
		if ($num==$tr || $num==(2*$tr))
		{
		     echo "</ul>";//'cols pad list2'>";
		      	echo "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td valign='top'><ul  class='speclist2'  style='list-style: url(\"/images/marker_1.gif\") outside ;'>";
         }

		// if($num > 1)
			// $tpl->appendValues(array("NEEDMARGIN" => "marg_top1"));
		// else
			// $tpl->appendValues(array("NEEDMARGIN" => ""));

		//$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers.html");



		$num++;
	}

    echo "</ul></td></tr></table>"; //"</ul>";

}


?>
