<?
// Главная новость

global $DB,$_CONFIG;
if ($_SESSION[lang]!='/en')
{
$rows=$DB->select("SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=3
				 WHERE a.icont_var='title' AND s.icont_text=1 AND c.icont_text!='' AND c.icont_text!='<p>&nbsp;</p>'
                 ORDER BY d.icont_text DESC LIMIT 2
                ");
/*
				else
$rows=$DB->select("SELECT c.el_id,c.icont_text AS title,d.icont_text AS prev_text
                  FROM adm_headers_content AS c
                  INNER JOIN adm_headers_content AS s ON s.el_id=c.el_id AND s.icont_var='status_en' AND s.icont_text=1				  
                  INNER JOIN adm_headers_content AS d ON d.el_id=c.el_id AND d.icont_var='text_en'
				  INNER JOIN adm_headers_element AS e ON e.el_id=c.el_id AND e.itype_id=3
				  WHERE c.icont_var='title_en' 
				  ORDER BY c.el_id DESC LIMIT 1
                ");
*/	
$commentsCount = 0;
foreach ($rows as $key => $value) {
	if($commentsCount>0)
		echo '<p></p>';
	     if(isset($value["date"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $value["date"], $matches);
		$value["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$value["date"] = date("d.m.Y", $value["date"]);
	}			
//echo "<div class='title red'>";
       echo $value["date"]."<br /><b style='font-size:16px;'><a href=/index.php?page_id=502&id=".$value[id]."&ret=640>".$value['title']."</a></b>";
//echo  "</div>";
echo $value[prev_text];
if (!empty($value[full_text]))
    echo "<a href=/index.php?page_id=502&id=".$value[id]."&ret=640>подробнее...</a>";
$commentsCount++;
}
}
else
{
	$rows=$DB->select("SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text_en'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text_en'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=3
				 WHERE a.icont_var='title_en' AND s.icont_text=1 AND c.icont_text!='' AND c.icont_text!='<p>&nbsp;</p>'
                 ORDER BY d.icont_text DESC LIMIT 2
                ");
$commentsCount = 0;
foreach ($rows as $key => $value) {
	if($commentsCount>0)
		echo '<p></p>';
	     if(isset($value["date"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $value["date"], $matches);
		$value["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$value["date"] = date("d.m.Y", $value["date"]);
	}			
//echo "<div class='title red'>";
       echo $value["date"]."<br /><b style='font-size:16px;'><a href=/en/index.php?page_id=502&id=".$value[id]."&ret=640>".$value['title']."</a></b>";
//echo  "</div>";
echo $value[prev_text];
if (!empty($value[full_text]))
    echo "<a href=/en/index.php?page_id=502&id=".$value[id]."&ret=640>more...</a>";
$commentsCount++;
}
}
?>
