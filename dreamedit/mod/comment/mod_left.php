<?
include_once dirname(__FILE__)."/../../_include.php";

global $config,$DB;

$rows=$DB->select("SELECT DISTINCT p.page_id,p.page_name AS page_name ,p2.page_name AS razdel
                  FROM adm_pages AS p
                       INNER JOIN  adm_pages AS p2 ON p2.page_id=p.page_parent
                           INNER JOIN comment_txt AS c ON c.page_id=p.page_id
                  ORDER BY p2.page_name,p.page_name ");




$razdel="";
foreach($rows as $row)
{
	if ($razdel != $row[razdel])
	{
		echo "<br /><strong>".$row[razdel]."</strong>";
		$razdel=$row[razdel];
	}
	$count=$DB->select("SELECT count(id) AS count,verdict FROM comment_txt AS c
	         WHERE page_id=".$row[page_id].
	         " GROUP BY verdict ORDER BY verdict");

	$countall=$count[0]['count']+$count[1]['count'];
	if ($count[0][verdict]==0) $countnew=$count[0]['count'];
	else $countnew=0;

    if ($countnew!=0)
    {
	echo "<br />&nbsp;&nbsp;&nbsp;<a title='новых комментариев / всего'href=/dreamedit/index.php?mod=comment&action=edit&id=".
	     $row[page_id].
	     "><font color='#ff0000'>".$row[page_name]."[".$countnew."/".$countall."]"."</font></a>";
	}
	else
	{
	     echo "<br />&nbsp;&nbsp;&nbsp;<a title='новых комментариев / всего'href=/dreamedit/index.php?mod=comment&action=edit&id=".
	     $row[page_id].
	     "><font color='#a0a0a0'>".$row[page_name]."[".$countnew."/".$countall."]"."</font></a>";
     }
}
?>
