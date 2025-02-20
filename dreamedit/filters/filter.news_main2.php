<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;

// Новости на главной
//print_r($page_content);

$ilines = new Ilines();
$ievent = new Events();
if (isset($_REQUEST[enb]))
{
  $rows = $ilines->getLimitedElementsMultiSort($page_content["NEWS_EN_LINE"], 3, 1,"DATE", "DESC", "status");
$name0=$ilines->getTypeById($page_content["NEWS_EN_LINE"]);
//echo "<h3>".$name0[itype_name]."</h3>";
echo "<br />".print_r($rows);
if(!empty($rows))
{
	
	
	$rows = $ilines->appendContent($rows);
	foreach($rows as $k => $v)
	{

        
		if(isset($v["content"]["DATE"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
		$v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$v["content"]["DATE"] = date("d.m.Yг.", $v["content"]["DATE"]);
	}

		$tpl = new Templater();

		
		
		$tpl->setValues($v["content"]);



		$tpl->appendValues(array("ID" => $k));
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

$rows = $ilines->getLimitedElementsMultiSortMain($page_content["NEWS_BLOCK_LINE"], $page_content["NEWS_BLOCK_COUNT"], 1,"DATE", "DESC", "status");
$name0=$ilines->getTypeById($page_content["NEWS_BLOCK_LINE"]);
//echo "<h3>".$name0[itype_name]."</h3>";
echo "<br />";
//print_r($page_content);
//echo "<<<<<".$page_content["NEWS_BLOCK_PAGE"];
if(!empty($rows))
{
	echo '<div class="jcarousel-skin-wpzoom">';
	echo '<div class="jcarousel-container jcarousel-container-vertical" style="position: relative; display: block;">';
	echo '<div class="jcarousel-clip jcarousel-clip-vertical" style="overflow: hidden; position: relative;">';
	echo '<ul id="jCarouselVertNews" class="posts jcarousel-list jcarousel-list-vertical">'; 

	
	$rows = $ilines->appendContent($rows);
//print_r($rows);
	foreach($rows as $k => $v)
	{

		if (strlen($v["content"]["LAST_TEXT"])<20) $v["content"]["LAST_TEXT"]=$v["content"]["PREV_TEXT"];

        if(isset($v["content"]["DATE"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
		$v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		if (!isset($_REQUEST[en]))
			$v["content"]["DATE"] = date("d.m.Yг.", $v["content"]["DATE"]);
		else	
			$v["content"]["DATE"] = date("m/d/y", $v["content"]["DATE"]);

		}
        
		if (isset($_REQUEST[en]))
		{
			$v["content"]["PREV_TEXT"]=$v["content"]["PREV_TEXT_EN"];
			$v["content"]["LAST_TEXT"]=$v["content"]["LAST_TEXT_EN"];
	//		if (empty($v["content"]["LAST_TEXT"])) $v["content"]["LAST_TEXT"]="@@".$v["content"]["PREV_TEXT"];
		}
		$prevtext=$v["content"]["PREV_TEXT"];
		if (strlen(strip_tags($v["content"]["PREV_TEXT"]))>580) //Укоротить текст
		{
		   $nn=explode('.',strip_tags($v["content"]["PREV_TEXT"]));
//		   print_r($nn);
		  
		   $prevtext='';
		   for($i=0;$i<count($nn);$i++)
		   {
		      
			  if (strlen($prevtext.".".$nn[$i])<575)
			     $prevtext.=$nn[$i].".";
			
			  else 
			  {
					$prevtext.="...<br />";
					break;	 
			  }		
		   }
		   if (empty($prevtext)) $prevtext=substr(strip_tags($v["content"]["PREV_TEXT"],0,575))."...</p>";
           else $prevtext.="<br />";
	}
	$lasttext=$v["content"]["LAST_TEXT"];
	if (strlen(strip_tags($v["content"]["LAST_TEXT"]))>580) //Укоротить текст
		{
		   $nn=explode('.',strip_tags($v["content"]["LAST_TEXT"]));
//		   print_r($nn);
		  
		   $lasttext='';
		   for($i=0;$i<count($nn);$i++)
		   {
		      
			  if (strlen($lasttext.".".$nn[$i])<575)
			 	     $lasttext.=$nn[$i].".";
			
			  else 
			  {
				$lasttext.="...<br />";
				break;	 
			  }	
		   }
		   if (empty($lasttext)) $lasttext=substr(strip_tags($v["content"]["LAST_TEXT"]),0,575)."...</p>";
          
	}

//	echo "@@@".$prevtext."#".$v["content"]["TODAY_TEXT"]."@";
		$tpl = new Templater();

		$tpl->setValues($v["content"]);

		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("date" => $v["content"]["DATE"]));
		$tpl->appendValues(array("PREV_TEXT" => $prevtext));
		if ($v["content"]["DATE2"]<date("Y.m.d"))
        {		
		if(!empty($v["content"]["LAST_TEXT"]) && $v["content"]["LAST_TEXT"]!='<p>&nbsp;</p>')
			$tpl->appendValues(array("PREV_TEXT" => $lasttext));
		else
			$tpl->appendValues(array("PREV_TEXT" => $prevtext));
  		}
		if (substr($v["content"]["DATE2"],0,10)==date("Y.m.d"))
		{
		    if(!empty($v["content"]["TODAY_TEXT"]) && $v["content"]["TODAY_TEXT"]!='<p>&nbsp;</p>')
				$tpl->appendValues(array("PREV_TEXT" => $v["content"]["TODAY_TEXT"]));
			else
				$tpl->appendValues(array("PREV_TEXT" => $prevtext));
		}
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("FULL_ID" => $page_content["NEWS_BLOCK_PAGE"]));
		if(!empty($v["content"]["FULL_TEXT"]) && $v["content"]["FULL_TEXT"]!='<p>&nbsp;</p>')
		    $tpl->appendValues(array("GO" => true));
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.news_anons.html");

	}

	echo '</ul>';
	echo '</div>';	
	echo '<div class="jcarousel-prev jcarousel-prev-vertical" style="display: block;"></div>';
	echo '<div class="jcarousel-next jcarousel-next-vertical" style="display: block;"></div>';
	echo '</div>';	
	echo '</div>';	
	?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#jCarouselVertNews').jcarousel({
							scroll: 1,
							vertical: 1,
							visible: 2,
							wrap: 'null',
							itemFallbackDimension: 124
				});
			});
		</script>  
	<?
if (!isset($_REQUEST[en]))
	echo "<a href=/index.php?page_id=498>Другие новости</a>";
else
	echo "<a href=en/index.php?page_id=498>All News</a>";
	
}
}
?>
