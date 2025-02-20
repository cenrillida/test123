<script>
_menuCloseDelay=500;
_menuOpenDelay=150;
_subOffsetTop=0;
_subOffsetLeft=0;

with(menuStyle=new mm_style()){
bordercolor="#999999";
borderstyle="solid";
borderwidth="0";
fontfamily="Arial,Helvetica,sans-serif";
fontsize="120%";
fontstyle="normal";
fontweight="normal";
headerbgcolor="#ffffff";
headercolor="#000000";
offbgcolor="none";
offcolor="none";
onbgcolor="#3a526c";
oncolor="#ffffff";
outfilter="randomdissolve(duration=0.3)";
<!--overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color=#777777', Direction=135, Strength=3)";/-->
overfilter="Fade(duration=0.2);Alpha(opacity=90)";
padding="12";
pagebgcolor="#3a526c";
pagecolor="white";
separatorcolor="none";
separatorsize="30";
subimage="arrow.gif";
subimagepadding="2";
}

with(menuStyle2=new mm_style()){
bordercolor="#999999";
borderstyle="solid";
borderwidth="1";
<!--fontfamily="Verdana, Tahoma, Arial"; /-->
fontsize="100%";
fontstyle="normal";
headerbgcolor="#ffffff";
headercolor="#000000";
offbgcolor="#eeeeee";
offcolor="#000000";
onbgcolor="#3a526c";
oncolor="#ffffff";
outfilter="randomdissolve(duration=0.3)";
<!--overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color=#777777', Direction=135, Strength=3)";/-->
overfilter="Fade(duration=0.2);Alpha(opacity=90)";
padding="4";
pagebgcolor="#3a526c";
pagecolor="#ffffff";
separatorcolor="#999999";
separatorsize="1";
subimage="arrow2.gif";
subimagepadding="2";
}


<?
global $page_content;

$pg = new Pages();
$menuRes = $pg->getChilds(2, 1);
//$menuRes = $pg->appendContent($menuRes);

foreach($menuRes as $row)
{
	$subMenu = $pg->getChilds($row["page_id"], 1);

	if(count($subMenu)>0)
	{
		echo "with(milonic=new menuname(\"menu".$row["page_id"]."\")){\n";
		echo "style=menuStyle2;\n";
		foreach($subMenu as $row2)
		{
        	$subMenu2 = $pg->getChilds($row2["page_id"], 1);
			if(count($subMenu2)>0)
			{
					//echo "aI("."\"showmenu=menu".$row2["page_id"].";text=".$row2["page_name"].";url=".$pg->getPageUrl($row2["page_id"])."\");\n";
				    echo "aI("."\"showmenu=menu".$row2["page_id"].";text=".$row2["page_name"].";url=/index.php?page_id=".$row2["page_id"]."\");\n";

				}
			else
			{
						//echo "aI("."\"text=".$row2["page_name"].";url=".$pg->getPageUrl($row2["page_id"])."\");\n";
						echo "aI("."\"text=".$row2["page_name"].";url=/index.php?page_id=".$row2["page_id"]."\");\n";

			}
		}
		echo "}\n\n";
	}
}

 foreach($menuRes as $row)
{
	$subMenu = $pg->getChilds($row["page_id"], 1);

	if(count($subMenu)>0)
	{
		foreach($subMenu as $row2)
		{
        	$subMenu2 = $pg->getChilds($row2["page_id"], 1);
        	if(count($subMenu2)>0)
        	{
       			echo "with(milonic=new menuname(\"menu".$row2["page_id"]."\")){\n";
				echo "style=menuStyle2;\n";

   				foreach($subMenu2 as $row3)
				{
		        	$subMenu3 = $pg->getChilds($row3["page_id"], 1);
					if(count($subMenu3)>0)
					{
						//echo "aI("."\"showmenu=menu".$row["page_id"].";text=".$row["page_name"].";url=".$pg->getPageUrl($row["page_id"])."\");\n";
				    echo "aI("."\"showmenu=menu".$row3["page_id"].";text=".$row3["page_name"].";url=/index.php?page_id=".$row3["page_id"]."\");\n";
						}
					else
					{
						echo "aI("."\"text=".$row3["page_name"].";url=/index.php?page_id=".$row3["page_id"]."\");\n";
					}
				}
				echo "}\n\n";
			}
		}

	}
}


?>

drawMenus();

</script>

<table class="milonicmenu"   cellspacing=0 cellpadding=0 style="margin: 0 30px 0 30px;">
<tr>
<td align=center valign=center>
<script>
with(milonic=new menuname("Main Menu")){
style=menuStyle;
alwaysvisible="true";
orientation="horizontal";
position="relative";
<?

//оно есть от верхней части
//print_r($menuRes);
foreach($menuRes as $row)
{
	if($row["page_name"]!="")
	{
		$subMenu = $pg->getChilds($row["page_id"], 1);


		if(count($subMenu)>0)
		{
		echo "aI("."\"showmenu=menu".$row["page_id"].";text=".$row["page_name"].";url=".$pg->getPageUrl($row["page_id"])."\");\n";
			//echo "aI("."\"showmenu=menu".$row["page_id"].";text=".$row["page_name"].";url=/index.php?page_id=".$row["page_id"]."\");\n";
		}
		else
		{
				echo "aI("."\"text=".$row["page_name"].";url=".$pg->getPageUrl($row["page_id"])."\");\n";
			//echo "aI("."\"text=".$row["page_name"].";url=/index.php?page_id=".$row["page_id"]."\");\n";
		}
	}
}

?>
}

drawMenus();
</script>
</td>
</tr>
</table>