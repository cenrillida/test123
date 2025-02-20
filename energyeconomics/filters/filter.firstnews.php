<?php
// Главная новость

$query = "SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=3
				 WHERE a.icont_var='title' AND s.icont_text=1
                 ORDER BY d.icont_text DESC LIMIT 1
                " or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 

$count_firstnews=0;
while($rows = mysqli_fetch_array($result)) 
{ 
     if(isset($rows["date"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows["date"], $matches);
		$rows["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$rows["date"] = date("d.m.Y", $rows["date"]);
	}			
//echo "<div class='title red'>";
       echo $rows[date]."<br /><b style='font-size:16px;'><a target='_blank' href=/index.php?page_id=1594&id=".$rows[id]."&ret=640>".$rows['title']."</a></b>";
//echo  "</div>";
echo $rows[prev_text];
if (!empty($rows[full_text]))
    echo "<a target='_blank' href=/index.php?page_id=1594&id=".$rows[id]."&ret=640>подробнее...</a>";
}
?>
