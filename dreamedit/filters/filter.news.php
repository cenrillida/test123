<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;


/*print_r($page_content);*/

$ilines = new Ilines();


//$rows = $ilines->getLimitedElementsMultiSort($page_content["NEWS_BLOCK_LINE"], $page_content["NEWS_BLOCK_COUNT"], @$_REQUEST["p"],"DATE", "DESC", "status");
//$rows = $ilines->getLimitedElementsMultiSort($page_content["NEWS_BLOCK_LINE"], $page_content["NEWS_BLOCK_COUNT"], 1,"DATE", "DESC", "status");
$rows = $ilines->getLimitedElementsMultiSort("**", $page_content["NEWS_BLOCK_COUNT"], 1,"DATE", "DESC", "status");

//print_r($rows);

if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);

	foreach($rows as $k => $v)
	{
     
     if ($_SESSION[lang]=='/en')
		{
             $v[content][TITLE]=$v[content][TITLE_EN];
			 $v[content][PREV_TEXT]=$v[content][PREV_TEXT_EN];
			 $v[content][LAST_TEXT]=$v[content][LAST_TEXT_EN];
			 $v[content][TODAY_TEXT]=$v[content][TODAY_TEXT_EN];
		}

	 if(isset($rows[@$_REQUEST["id"]]["content"]["DATE"]))
	{
	 if ($_SESSION[lang]!='/en')
     {	 
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[@$_REQUEST["id"]]["content"]["DATE"], $matches);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = date("d.m.Yг.", $rows[@$_REQUEST["id"]]["content"]["DATE"]);
     }
     else
		  {
		    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $$rows[@$_REQUEST["id"]]["content"]["DATE"], $matches);
			$rows[@$_REQUEST["id"]]["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
			$rows[@$_REQUEST["id"]]["content"]["DATE"] = date("m/d/y", $rows[@$_REQUEST["id"]]["content"]["DATE"]);
		  }	 

	}

    if (!empty($v[content]['TITLE']) && strlen($v[content][PREV_TEXT])>15)
	{
		$tpl = new Templater();

		$tpl->setValues($v["content"]);
/*		$tpl->appendValues($page_content);*/
		if ($v[itype_id]!=6)
		{

		if (substr($v["content"]["DATE2"],0,10)<date("Y.m.d"))
		{
		   if (!empty($v[content]["LAST_TEXT"]) && $v["content"]["LAST_TEXT"]!='<p>&nbsp;</p>')
			$tpl->appendValues(array("PREV_TEXT" => $v[content]["LAST_TEXT"]));
			else	
			$tpl->appendValues(array("PREV_TEXT" => $v[content]["PREV_TEXT"]));
			
		}
		if (substr($v["content"]["DATE2"],0,10)>date("Y.m.d")) {
		   $tpl->appendValues(array("PREV_TEXT" =>$v[content]["PREV_TEXT"])); 
		}
		if (substr($v["content"]["DATE2"],0,10)==date("Y.m.d"))
		   {

		   	if(date("Y.m.d H:i:s")<date("Y.m.d 16:00:00")) {
			   if (!empty($v[content]["TODAY_TEXT"]) && $v["content"]["TODAY_TEXT"]!='<p>&nbsp;</p>')
				$tpl->appendValues(array("PREV_TEXT" => $v[content]["TODAY_TEXT"]));
				else	
				$tpl->appendValues(array("PREV_TEXT" => $v[content]["PREV_TEXT"]));
			}
			else
			{
			  	if (!empty($v[content]["LAST_TEXT"]) && $v["content"]["LAST_TEXT"]!='<p>&nbsp;</p>')
					$tpl->appendValues(array("PREV_TEXT" => $v[content]["LAST_TEXT"]));
				else	
					$tpl->appendValues(array("PREV_TEXT" => $v[content]["PREV_TEXT"]));
			}
			
		   }
        }
	
		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("date" => $v["content"]["DATE"]));
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("FULL_ID" => 502));
		if(!empty($v["content"]["FULL_TEXT"]))
		    $tpl->appendValues(array("GO" => true));
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.news_anons.html");
     }
	}
}

$news_count = $ilines->countElements($page_content["NEWS_BLOCK_LINE"],"status");
$pagination = new Pagination();
//$pages = $pagination->createPages($news_count[$page_content["NEWS_BLOCK_LINE"]], $page_content["NEWS_BLOCK_COUNT"], 3, @$_REQUEST["p"]);
$pages = $pagination->createPages($news_count[$page_content["NEWS_BLOCK_LINE"]], $page_content["NEWS_BLOCK_COUNT"], 3, 1);


$pg = new Pages();
foreach($pages as $v)
{
	echo "<a href=\"".$pg->getPageUrl($page_id)."?p=".$v[0]."\">".$v[1]."</a>&nbsp;&nbsp;";
}
if ($_SESSION[lang]!='/en')
	echo "<a href=/index.php?page_id=498>другие новости</a>";
       
else
	echo "<a href=/en/index.php?page_id=498>Other News</a>";
?>