<?
// кнопки ыоссетей
global $page_content;

$ilines = new Ilines();

$elements = $ilines->getLimitedElements(7,20,1,"sort");
echo "<p align='left'>";
if(!empty($elements))
{
$elements=$ilines->appendContent($elements);
foreach($elements as $e)
{
	if($_SESSION[lang]!="/en")
 echo "<a href=".$e[content]["LINK"]." target=_blank >".
 str_replace("</p>","",str_replace("<p>","",$e[content]["SMALL_PICTURE"]))."</a>&nbsp;&nbsp;&nbsp;";
 else
 {
 	if(!empty($e[content]["SMALL_PICTURE_EN"]) && $e[content]["SMALL_PICTURE_EN"]!="<p>&nbsp;</p>")
 		 echo "<a href=".$e[content]["LINK"]." target=_blank >".
 			str_replace("</p>","",str_replace("<p>","",$e[content]["SMALL_PICTURE_EN"]))."</a>&nbsp;&nbsp;&nbsp;";
 	else
 		 echo "<a href=".$e[content]["LINK"]." target=_blank >".
 		str_replace("</p>","",str_replace("<p>","",$e[content]["SMALL_PICTURE"]))."</a>&nbsp;&nbsp;&nbsp;";
 }

}
echo "</p>";
}
?>
