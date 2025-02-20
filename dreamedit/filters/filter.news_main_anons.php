<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;

// Новости на главной
//print_r($page_content);

$ilines = new Ilines();
$ievent = new Events();
if ($_SESSION[lang]=='/en') $suff='_en';else $suff="";

if ($_SESSION[lang]=='/en,')
{
  $rows = $ilines->getLimitedElementsMultiSort("*", $page_content["NEWS_EN_COUNT"], 1,"DATE", "DESC", "status","type");
$name0=$ilines->getTypeById($page_content["NEWS_EN_LINE"]);
//echo "<h3>".$name0[itype_name]."</h3>";
//echo "<br />$$$".print_r($rows);
if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);
	
	foreach($rows as $k => $v)
	{

        if ($_SESSION[lang]=='/en')
		{
			$v["content"]["PREV_TEXT"]=$v["content"]["PREV_TEXT_EN"];
			$v["content"]["LAST_TEXT"]=$v["content"]["LAST_TEXT_EN"];
	//		if (empty($v["content"]["LAST_TEXT"])) $v["content"]["LAST_TEXT"]="@@".$v["content"]["PREV_TEXT"];
		}
		if(isset($v["content"]["DATE"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
		$v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		if (!isset($_REQUEST[en]))
			$v["content"]["DATE"] = date("d.m.Yг.", $v["content"]["DATE"]);
		else
			$v["content"]["DATE"] = date("m/d/d", $v["content"]["DATE"]);
		
	}

		$tpl = new Templater();

		$tpl->setValues($v["content"]);



		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("ANONS" => "on"));
		$tpl->appendValues(array("date" => $v["content"]["DATE"]));
		if ($v["content"]["DATE2"]<date("Y.m.d") && !empty($v["content"]["LAST_TEXT"]))
			$tpl->appendValues(array("PREV_TEXT" => $v["content"]["LAST_TEXT"]));
  		if (substr($v["content"]["DATE2"],0,10)==date("Y.m.d"))
			$tpl->appendValues(array("PREV_TEXT" => $v["content"]["TODAY_TEXT"]));
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("FULL_ID" => 208));
		if(!empty($v["content"]["FULL_TEXT"]))
		    $tpl->appendValues(array("GO" => true));
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.news_anons.html");

	}
}

echo "<a href=/index.php?page_id=498>More news</a>";


}
else
{
//$rows = $ilines->getLimitedElementsMultiSort("*", $page_content["NEWS_BLOCK_COUNT"], 1,"DATE2", "DESC", "status");

$rows = $ilines->getLimitedElementsMultiSort("*", 15, 1,"DATE2", "DESC", "status");

$name0=$ilines->getTypeById($page_content["NEWS_BLOCK_LINE"]);

//echo "<a hidden=true href=aaa>".$page_content["NEWS_BLOCK_LINE"]."</a>";

$date = new DateTime();
$interval = new DateInterval('P1D');
$date->add($interval);
//echo "<h3>".$name0[itype_name]."</h3>";
//print_r($page_content);
//echo "<<<<<".$page_content["NEWS_BLOCK_PAGE"];
//print_r($rows);
if(!empty($rows) )
{
	$rows = $ilines->appendContent($rows);
//print_r($rows);
	foreach($rows as $k => $v)
	{
		//echo "<a hidden=true src=test>".$ilines->getNewsOutOfMain($v[el_id])."</a>";
		if($ilines->getNewsOutOfMain($v[el_id]))
			unset($rows[$k]);
						
	}

	$rows=array_values($rows);
	
	$rows = array_reverse($rows);
	foreach($rows as $k => $v)
	{
	if($v[itype_id]==1 || $v[itype_id]==4)
	{
	//echo "<a hidden=true href=aaa>".$v[itype_id]."</a>";
//echo "<br />___";print_r($v);"<br />___"; 
 if (empty($v["content"]["DATE2"])) $v["content"]["DATE2"]=$v["content"]["DATE"];
  if($v["content"]["DATE2"]> $date->format("Y.m.d"))
  {
        if ($_SESSION[lang]=='/en')
		{
			$v["content"]["PREV_TEXT"]=$v["content"]["PREV_TEXT_EN"];
			$v["content"]["LAST_TEXT"]=$v["content"]["LAST_TEXT_EN"];
			if($v["content"]["PREV_TEXT"]=="<p>&nbsp;</p>")
				continue;
	//		if (empty($v["content"]["LAST_TEXT"])) $v["content"]["LAST_TEXT"]="@@".$v["content"]["PREV_TEXT"];
		}
		if(isset($v["content"]["DATE"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
		$v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$v["content"]["DATE"] = date("d.m.Y г.", $v["content"]["DATE"]);
	}

		$date_word = "";
        $time_word = "";
        if(isset($v["content"]["DATE2"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE2"], $matches);

        $time_word = $matches[4].":".$matches[5];
        if($_SESSION[lang]!="/en") {
            switch ($matches[2]) {
                case "01":
                    $m = 'января';
                    break;
                case "02":
                    $m = 'февраля';
                    break;
                case "03":
                    $m = 'марта';
                    break;
                case "04":
                    $m = 'апреля';
                    break;
                case "05":
                    $m = 'мая';
                    break;
                case "06":
                    $m = 'июня';
                    break;
                case "07":
                    $m = 'июля';
                    break;
                case "08":
                    $m = 'августа';
                    break;
                case "09":
                    $m = 'сентября';
                    break;
                case "10":
                    $m = 'октября';
                    break;
                case "11":
                    $m = 'ноября';
                    break;
                case "12":
                    $m = 'декабря';
                    break;
            }
        }
        else {
            switch ($matches[2]) {
                case "01":
                    $m = 'january';
                    break;
                case "02":
                    $m = 'february';
                    break;
                case "03":
                    $m = 'march';
                    break;
                case "04":
                    $m = 'april';
                    break;
                case "05":
                    $m = 'may';
                    break;
                case "06":
                    $m = 'june';
                    break;
                case "07":
                    $m = 'july';
                    break;
                case "08":
                    $m = 'august';
                    break;
                case "09":
                    $m = 'september';
                    break;
                case "10":
                    $m = 'october';
                    break;
                case "11":
                    $m = 'november';
                    break;
                case "12":
                    $m = 'december';
                    break;
            }
		}

        $date_word = $matches[3] . " " . $m . " " . $matches[1];
		$v["content"]["DATE2"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$v["content"]["DATE2"] = date("d.m.Y г.", $v["content"]["DATE2"]);
	}
	$event_text = "Мероприятие";
        if($_SESSION[lang]=="/en")
            $event_text = "Event";
		$tpl = new Templater();

		$tpl->setValues($v["content"]);

		$tpl->appendValues(array("ID" => $v[el_id]));
		$tpl->appendValues(array("LINE" => $v["itype_name".$suff]));
      	$tpl->appendValues(array("TIME" => $time_word));
        $tpl->appendValues(array("EVENT_TEXT" => $event_text));
		$tpl->appendValues(array("ANONS" => "on"));
      	$tpl->appendValues(array("MESSAGE_ICON" => "off"));
		$tpl->appendValues(array("date" => $date_word));
		/*if ($v["content"]["DATE2"]<date("Y.m.d") && !empty($v["content"]["LAST_TEXT"]) && $v["content"]["LAST_TEXT"]!='<p>&nbsp;</p>')
			$tpl->appendValues(array("PREV_TEXT" => $v["content"]["LAST_TEXT"]));
  		if (substr($v["content"]["DATE2"],0,10)==date("Y.m.d"))
			$tpl->appendValues(array("PREV_TEXT" => $v["content"]["TODAY_TEXT"]));*/
		$tpl->appendValues(array("PREV_TEXT" => $v["content"]["PREV_TEXT"]));
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("FULL_ID" => $page_content["NEWS_BLOCK_PAGE"]));
		if(!empty($v["content"]["FULL_TEXT"]))
		    $tpl->appendValues(array("GO" => true));
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.news_anons.html");
	}
	}
  }	
}
if ($_SESSION[lang]!='/en')
	echo "<a href=/index.php?page_id=498>Другие новости</a>";
else
	echo "<a href=/en/index.php?page_id=498>Other News</a>";
}
?>
