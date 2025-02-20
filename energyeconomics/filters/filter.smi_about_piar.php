<?php
// Главная новость

$query = "SELECT c.el_id AS id,c.icont_text AS prev_text,rub.icont_text AS rubric,a.icont_text AS title,pe.icont_text AS people,sp.icont_text AS small_picture,d.icont_text AS date,f.icont_text AS full_text,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS rub ON rub.el_id=a.el_id AND rub.icont_var='rubric'
				 INNER JOIN adm_ilines_content AS pe ON pe.el_id=a.el_id AND pe.icont_var='people'
				 INNER JOIN adm_ilines_content AS sp ON sp.el_id=a.el_id AND sp.icont_var='small_picture'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=5
				 WHERE a.icont_var='title' AND s.icont_text=1 AND rub.icont_text=440
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
       echo $rows[date]."<br /><b style='font-size:16px;'><a target='_blank' href=/index.php?page_id=502&id=".$rows[id]."&ret=636>".$rows['title']."</a></b>";
//echo  "</div>";

$img_smi_piar=$rows[small_picture];
if($rows[people]!='' && $rows[people]!='<br>')
{
	$query = "SELECT picbig FROM persons WHERE id=".strstr($rows[people], '<', true) or die("Error in the consult.." . mysqli_error($link)); 
	$result_smi_piar = $link->query($query); 
	$row_picbig_smi_piar = mysqli_fetch_array($result_smi_piar);

	if($row_picbig_smi_piar[picbig]!='')
	$img_smi_piar="<p><img hspace=3 width=120 height=160 src=../dreamedit/foto/".$row_picbig_smi_piar[picbig]."></img></p>";
}


echo '<table vspace=3><tr><td>';
echo $img_smi_piar;
echo '</td><td>';
echo $rows[prev_text];
echo '</td></tr></table>';
if (!empty($rows[full_text]))
    echo "<a target='_blank' href=/index.php?page_id=502&id=".$rows[id]."&ret=636>подробнее...</a>";
}
?>
