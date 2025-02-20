	<?
global $page_content,$_TPL_REPLACMENT;

$pg = new Pages();

$page_id = $_REQUEST["page_id"];

$pp=$pg->getPageById($_REQUEST[page_id]);
$pp["content"] = $pg->getContentByPageId($_REQUEST[page_id]);

 $parent = $pg->getParents($page_id, 1);
$page_to_extract_submenu = 1;
$i=0;

if($pp["content"]['FROM_THIS_PAGE']) {
	$page_to_extract_submenu = $page_id;
} else {
	foreach($parent as $page)
	{
		if ($i==2)
		{
			$page_to_extract_submenu = $page["page_id"];
		}
		if ($i==3 && !empty($page[page_link])) $page_parent=$page[page_link];      //главная и не главное меню
		if ($i==3 && empty($page[page_link])) $page_parent=$page[page_id];
		if ($i==4 && !empty($page[page_link])) $page_parent2=$page[page_link];   //Центр?
		if ($i==4 && empty($page[page_link])) $page_parent2=$page[page_id];
		if ($page[page_status]==1) $i++;
	}
}

//echo $page_parent." * ".$page_parent2." @ ".$page[page_id];


if (empty($page_parent2))$page_parent2=$page_parent;
if ($_SESSION[lang]!="/en")
	$menuRes = $pg->getChildsMenu($page_to_extract_submenu,1);
else
	$menuRes = $pg->getChildsMenuEn($page_to_extract_submenu, 1);

if (!empty($page_parent) || !empty($page_parent2) || $pp[page_parent]==2 || $pp[page_parent]==440 || $pp[page_template]=="submenu")
{
	if($pp["content"]["NOENTRYTEXT"]!=1) {
		if ($_SESSION[lang] != '/en')
			echo "<b>В этом разделе:</b>";
		else
			if (!empty($pp[page_name_en])) echo "<b>In this section:</b>";
	}
echo "<ul class='speclist'>";  //Первый уровень
foreach($menuRes as $row)
{
if (substr($row[page_template],0,8)=='magazine') $prefjour="/jour/".$_SESSION[jour_url];
else $prefjour="";
if (empty($page_parent))
{
	$news_templater = new Templater();
	$news_templater->setValues($row);

	if((($row["page_id"] == $page_parent || $row["page_link"] == $page_parent) && !empty($page_parent))) //&& 
		$news_templater->appendValues(array("CURRENT" => true));

	$news_templater->appendValues(array("PAGE_URLNAME" => $prefjour."/index.php?page_id=".$row[page_id]));

	$capitalize = "";
	$bold = "";
	$color = "";
	$fontSize = "";

	if($pp["content"]["CAPITALIZE_LINKS"]==1) {
		$capitalize = 1;
	} else {
		$capitalize = $row[submenu_page_capitalize];
	}

	if($pp["content"]["BOLD_LINKS"]==1) {
		$bold = 1;
	} else {
		$bold = $row[submenu_bold];
	}

	if(!empty($row[list_color])) {
		$color = $row[list_color];
	} else {
		if(!empty($pp["content"]["LINKS_COLOR"])) {
			$color = $pp["content"]["LINKS_COLOR"];
		}
	}

    $news_templater->appendValues(array("CAPITALIZE" => $capitalize));
	$news_templater->appendValues(array("LINK_BOLD" => $bold));
	$news_templater->appendValues(array("LINK_COLOR" => $color));
	$news_templater->appendValues(array("LINK_FONT_SIZE" => $pp["content"]["FONT_SIZE_LINKS"]));
	echo "<li>";
	$news_templater->displayResultFromPath($_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."tpl.submenu.html");
}
	//echo $page_parent.' ' .$row[page_id] ." ".$page_parent2.' ';
  if (($page_parent==$row[page_id] || $page_parent==$row[page_link]))

  {
   // $rr=$pg->getPageById($page_parent2);
	if ($_SESSION[lang]!="/en")
		$menuRes2 = $pg->getChildsMenu($row[page_id],1);
	else	
		$menuRes2 = $pg->getChildsMenuEn($row[page_id],1);

	if(!empty($menuRes2)) //&& $finded )
	{
		echo "<ul class='speclist'>";    //Второй уровень
		foreach($menuRes2 as $row2)
		{
	//	print_r($row2);
		if (substr($row2[page_template],0,8)=='magazine') $prefjour="/jour/".$row2[page_journame];
		else $prefjour="";

			$news_templater2 = new Templater();
			$news_templater2->setValues($row2);

            $news_templater2->appendValues(array("page_name" => "".$row2[page_name]));
			if ($_SESSION[lang]!="/en")
				$menuRes3 = $pg->getChildsMenu($row2[page_id], 1);
			else
			    $menuRes3 = $pg->getChildsMenuEn($row2[page_id], 1);
			if((count($menuRes3) > 0 && $pp[page_parent]==$row2[page_id]) || $row2[page_id]==$_REQUEST[page_id])
				$news_templater2->appendValues(array("CURRENT" => true));

			$capitalize = "";
			$bold = "";
			$color = "";
			$fontSize = "";

			if($pp["content"]["CAPITALIZE_LINKS"]==1) {
				$capitalize = 1;
			} else {
				$capitalize = $row2[submenu_page_capitalize];
			}

			if($pp["content"]["BOLD_LINKS"]==1) {
				$bold = 1;
			} else {
				$bold = $row2[submenu_bold];
			}

			if(!empty($row2[list_color])) {
				$color = $row2[list_color];
			} else {
				if(!empty($pp["content"]["LINKS_COLOR"])) {
					$color = $pp["content"]["LINKS_COLOR"];
				}
			}

			$news_templater2->appendValues(array("CAPITALIZE" => $capitalize));
			$news_templater2->appendValues(array("LINK_BOLD" => $bold));
			$news_templater2->appendValues(array("LINK_COLOR" => $color));
			$news_templater2->appendValues(array("LINK_FONT_SIZE" => $pp["content"]["FONT_SIZE_LINKS"]));
			if($prefjour=="")
				$news_templater2->appendValues(array("PAGE_URLNAME" => $prefjour."/index.php?page_id=".$row2["page_id"]));
			else
                $news_templater2->appendValues(array("PAGE_URLNAME" => $prefjour));

			echo "<li>";
			$news_templater2->displayResultFromPath($_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."tpl.submenu.html");
			// Третий уровень
	        if (!empty($menuRes3))
			echo "<ul class='speclist'>";    //третий уровень
				foreach($menuRes3 as $row3)
				{
				if (substr($row3[page_template],0,8)=='magazine') $prefjour="/jour/".$_SESSION[jour_url];
				else $prefjour="";	
					if ($row3[page_id]!=$row2[page_id])
					{
						$news_templater3 = new Templater();
						$news_templater3->setValues($row3);
			            $news_templater3->appendValues(array("page_name" => "".$row3[page_name]));
						if($row3["page_id"] == $page_id)
							$news_templater3->appendValues(array("CURRENT" => true));

						$news_templater3->appendValues(array("PAGE_URLNAME" => $pg->getPageUrl($prefjour.$row3["page_id"]), "LINK_NUM" => $i));

						$capitalize = "";
						$bold = "";
						$color = "";
						$fontSize = "";

						if($pp["content"]["CAPITALIZE_LINKS"]==1) {
							$capitalize = 1;
						} else {
							$capitalize = $row3[submenu_page_capitalize];
						}

						if($pp["content"]["BOLD_LINKS"]==1) {
							$bold = 1;
						} else {
							$bold = $row3[submenu_bold];
						}

						if(!empty($row3[list_color])) {
							$color = $row3[list_color];
						} else {
							if(!empty($pp["content"]["LINKS_COLOR"])) {
								$color = $pp["content"]["LINKS_COLOR"];
							}
						}

						$news_templater3->appendValues(array("CAPITALIZE" => $capitalize));
						$news_templater3->appendValues(array("LINK_BOLD" => $bold));
						$news_templater3->appendValues(array("LINK_COLOR" => $color));
						$news_templater3->appendValues(array("LINK_FONT_SIZE" => $pp["content"]["FONT_SIZE_LINKS"]));
						echo "<li>";
						$news_templater3->displayResultFromPath($_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."tpl.submenu.html");
						echo "</li>";
					}
				}
			if (!empty($menuRes3))echo "</ul>";   //третий уровень


		}
		echo "</li>";echo "</ul>"; // Второй урвоень
	}
   
   }
}
echo "</li>";echo "</ul>";
if ($_SESSION[lang]=='/en' && empty($pp[page_name_en])) echo "<b>Sorry! This page is not in the English version</b><br /><br />";
}
?>
