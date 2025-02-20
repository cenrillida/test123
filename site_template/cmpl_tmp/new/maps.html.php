<?
global $_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

 echo $_TPL_REPLACMENT["CONTENT"];


echo "<div class='speclist'>";
$pg = new Pages();
if (!isset($_REQUEST[en]))
	$cc=$pg->getChildsMenu(2,1);
else
	$cc=$pg->getChildsMenuEn(2,1);

echo "<ul>";
foreach($cc as $k=>$page)
{
if ($_SESSION[lang]=="/en") $page[page_name]=$page[page_name_en];
	$blank = "";
	if($page["blank"]) {
		$blank = ' target="_blank"';
	}
echo "<li><strong><a".$blank." href=".$_SESSION[lang]."/index.php?page_id=".$page[page_id].">".$page[page_name]."</a></strong>";

if ($_SESSION[lang]!="/en") $bb=$pg->getChildsMenu($page[page_id],1);
else $bb=$pg->getChildsMenuEn($page[page_id],1);
//print_r($bb);
if (count($bb)>0) echo "<ul>";

  foreach($bb as $k2 => $level2)
  {
  	 if ($_SESSION[lang]=="/en") $level2[page_name]=$level2[page_name_en];
	  $blank = "";
	  if($level2["blank"]) {
		  $blank = ' target="_blank"';
	  }
	 if ($level2[page_template]!='news_full' && $level2[page_template]!='1publ_2011' && $level2[page_template]!='pers_full' &&
	     $level2[page_template]!='grant_full' && $level2[page_template]!='search_persona' && $level2[page_template]!='smi_full')
	 echo "<li><a".$blank." href=".$_SESSION[lang]."/index.php?page_id=".$level2[page_id].">".$level2[page_name]."</a>";
  	 if ($_SESSION[lang]!="/en") $ee=$pg->getChildsMenu($level2[page_id],1);
	 else $ee=$pg->getChildsMenuEn($level2[page_id],1);
  	     if (isset($ee))
  	     {
  	         if (count($ee)>0) echo "<ul>";
  	         foreach($ee as $k3=>$level3)
  	         {
				 $blank = "";
				 if($level3["blank"]) {
					 $blank = ' target="_blank"';
				 }
			  if ($_SESSION[lang]=="/en") $level3[page_name]=$level3[page_name_en];
 if ($level3[page_template]!='news_full' && $level3[page_template]!='1publ_2011' && $level3[page_template]!='pers_full' &&
	     $level3[page_template]!='grant_full' && $level3[page_template]!='search_persona' && $level3[page_template]!='smi_full')

				 if (substr($level3[page_template],0,8)=='magazine')
                     echo "<li><a".$blank." href=".$_SESSION[lang]."/jour/".$level3[page_journame].">".$level3[page_name]."</a></li>";
				 else
                     echo "<li><a".$blank." href=".$_SESSION[lang]."/index.php?page_id=".$level3[page_id].">".$level3[page_name]."</a></li>";
	  	            

  	         }
  	         if (count($ee)>0)echo "</ul>";
  	       }
  	  echo "</li>";
  }

if (count($bb)>0) echo "</ul>";

if ($_SESSION[lang]!='/en') $ee=$pg->getChildsMenu($page[page_id],1);
else $ee=$pg->getChildsMenuEn($page[page_id],1);
echo "</li>";
}
echo "</ul></div>";

?>
<?
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
