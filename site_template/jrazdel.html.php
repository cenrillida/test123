<?
global $_CONFIG, $site_templater;

$hd=new Headers();
//print_r($_TPL_REPLACMENT);
$menu=$hd->getPageParamByColor($_TPL_REPLACMENT[MENU_COLOR]);
//echo "__".$menu[0][mainname] ." * ".$_TPL_REPLACMENT[MENU_COLOR];
//print_r($menu);

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.".$menu[0][mainname].".html");

/*
if ($_REQUEST[page_id]!=1067)
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.main.html");
else
		$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.main_green.html");
*/
?>

<div id="cromb" style="padding: 2px 4px 5px 8px;" >
    <?=@$_TPL_REPLACMENT["CRUMB"]?>

</div>

<div class="content sitepadding">
	<div id="colOne">
		<?=@$_TPL_REPLACMENT["LEFTRAZDELCOLUMN"]?>
	</div>
	<div id="colTwo">
		<div id="colTwo1">
			<div class='brownb'>
                     <?=@$_TPL_REPLACMENT["PAGE_NAME"]?>
	<!--		     <img src='image/ws.gif' class='whitespace' align='absmiddle' />
			     <?=@str_replace("</p>","",str_replace("<p>","",$_TPL_REPLACMENT["ICON"]))?>
			     <?=@$_TPL_REPLACMENT["TITLE"]?>     -->
<?

	echo "<div class='brownb'>".str_replace('height="32"','height="32" align="absmiddle"',str_replace("</p>","",str_replace("<p>","",$_TPL_REPLACMENT["ICON"])))."<img src='image/ws.gif' class='whitespace' align='absmiddle' />".$_TPL_REPLACMENT["TITLE"]."</div>";
?>

			</div>
<div class='webpartcontentw'>
			<?=@$_TPL_REPLACMENT["CONTENT"]?>
<?

	      echo $_TPL_REPLACMENT[$_TPL_REPLACMENT["FNAME"]];



?>
				<?=@$_TPL_REPLACMENT["CONTENT02"]?>
</div>
		</div>
		<div id="colTwo2">
			<?=@$_TPL_REPLACMENT["RAZDELRIGHTCOLUMN"]?>
		</div>
		<div style="clear: left;"> </div>

        <div id="colTwo3">



<?
   echo "<div class='brownb'>"."<img width='32' height='32' align='absmiddle' src='/files/Image/Icon/folderopen_gray.jpg' />"."<img src='image/ws.gif' class='whitespace' align='absmiddle' />".$_TPL_REPLACMENT["BOTTOMHEADER"]."</div>";
   ?>



<?
	for($ii=1;$ii<21;$ii++)
	{
		$beginstr =  "CONTENTBOTTOM";

		if($ii < 10)
			$beginstr = $beginstr."0";
        $len=strlen($_TPL_REPLACMENT[$beginstr.$ii]);
	//	$strtoprint = str_replace("<p>","",substr($_TPL_REPLACMENT[$beginstr.$ii],0,3)).substr($_TPL_REPLACMENT[$beginstr.$ii],3,$len-7).str_replace("</p>","",substr($_TPL_REPLACMENT[$beginstr.$ii],$len-4,4));
		$strtoprint = $_TPL_REPLACMENT[$beginstr.$ii];
		$i1=strpos($strtoprint,"<a");
        $i2=strpos($strtoprint,">",$i1);
        $ss=substr($strtoprint,($i1),($i2-$i1+1));
		if($strtoprint != "")
		{
			echo "<div class='webpartcontentw'>";
				echo $strtoprint;
				echo $ss."подробнее...</a>";
			echo "</div>";
			echo "<hr/>\n";
		}
	}

?>
	      </div>
	</div>
	<div style="clear: both;"> </div>
</div>

<?

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.main.html");
?>
