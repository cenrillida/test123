<?
global $page_content;
/*
$pg = new Pages();
$menuRes = $pg->getChilds(89, 1);
$menuRes = $pg->appendContent($menuRes);
*/
if(strpos($_SERVER[REQUEST_URI],"&en") !== false || strpos($_SERVER[REQUEST_URI],"?en") !== false)
   $suff="_en";
else
   $suff="";
$pg=new Directories();

$menuRes=$pg->getDirectoryRubrics("Тематические рубрики");
//print_r($menuRes);

$page_content["RAZDEL"] = "";

// //определяем сколько горизонтальных линий для меню нужно
// $temp = 0;
// foreach($menuRes as $row)
// $temp++;

$i = 1;

if(!empty($menuRes))
{
echo '<ul  class="speclist">';
	foreach($menuRes as $row)
	{

		$news_templater = new Templater();
		$news_templater->setValues($row);
		$news_templater->appendValues($row["content"]);
//		$news_templater->appendValues(array("PAGE_URLNAME" => $pg->getPageUrl($row["page_id"]), "LINK_NUM" => $i));

//		$news_templater->displayResultFromString("<li class='bg_list_un'><a href=\"{PAGE_URLNAME}\" >".$row["page_name"]."</a></li>\n");
if ($row[id]!=19)
        echo "<li  class='bg_list_un'><a href=/index.php?page_id=".$page_content[PUBL_SPISOK]."&rub2=".$row[id].">".$row['text'.$suff]."</a></li>";
else
        echo "<li  class='bg_list_un'><a href=/index.php?page_id=".$page_content[SEARCH_PAGE]."&rub2=".$row[id].">".$row['text'.$suff]."</a></li>";

	}
echo '</ul>';
}
