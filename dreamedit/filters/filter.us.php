<?
// ќбъ€вление о заседании ”ченого совета
global $DB,$_CONFIG;

$rows=$DB->select("SELECT c.el_id,c.icont_text AS date2,
                    t.icont_text AS prev_text,
					t2.icont_text AS today_text,
					t3.icont_text AS last_text
					FROM adm_ilines_content AS c 
					INNER JOIN adm_ilines_element AS e ON e.el_id=c.el_id AND e.itype_id=4
					INNER JOIN adm_ilines_content AS u ON u.el_id=c.el_id AND u.icont_text='465' AND u.icont_var='sem'
					INNER JOIN adm_ilines_content AS s ON s.el_id=c.el_id AND s.icont_var='status' AND s.icont_text=1
					INNER JOIN adm_ilines_content AS t ON t.el_id=c.el_id AND t.icont_var='prev_text'
					LEFT OUTER JOIN adm_ilines_content AS t2 ON t2.el_id=c.el_id AND t2.icont_var='today_text'
					LEFT OUTER JOIN adm_ilines_content AS t3 ON t3.el_id=c.el_id AND t3.icont_var='last_text'
					WHERE c.icont_var='date2'
					ORDER BY c.icont_text DESC LIMIT 1
                ");
if (count($rows)>0)
{
   
   $row=$rows[0];
  
   $date=date("Y.m.d");
   echo "<b>".substr($row[date2],8,2).".".substr($row[date2],5,2).".".substr($row[date2],0,4)."</b>";
   if (empty($row[today_text]))$row[today_text]=$row[prev_text]; 
   if (empty($row[last_text]))$row[last_text]=$row[prev_text]; 
   if ($row[date2]==$date) echo $row[today_text];
   if ($row[date2]>$date) echo $row[prev_text];
   if ($row[date2]<$date) echo $row[last_text];
  echo "<a href=/index.php?page_id=502&id=".$row[el_id].">подробнее...</a>";

}
				
?>
