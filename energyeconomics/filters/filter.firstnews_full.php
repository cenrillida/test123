<?php
// Главная новость

$query = "SELECT id FROM `persons` AS pers WHERE pers.otdel='424' OR pers.otdel2='424' OR pers.otdel3='424'" or die("Error in the consult.." . mysqli_error($link));
$result = $link->query($query);

$autors="";

$first=true;

while($row = mysqli_fetch_array($result))
{
    $autors.=" OR pl.icont_text LIKE '".$row[id]."<br>%' OR pl.icont_text LIKE '%<br>".$row[id]."<br>%'";
}

$query = "SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text'
				 INNER JOIN adm_ilines_content AS pl ON pl.el_id=a.el_id AND pl.icont_var='people'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND (e.itype_id=3 OR e.itype_id=16)
				 WHERE a.icont_var='title' AND s.icont_text=1 AND (1<>1$autors OR e.itype_id=16)
                 ORDER BY d.icont_text DESC
                " or die("Error in the consult.." . mysqli_error($link));

$result = $link->query($query); 

$count_smi_about_full=0;

while($rows = mysqli_fetch_array($result)) 
{ 
	$count_smi_about_full++;
}


//$num_of_rows=mysql_num_rows($result);
$mat_per_page=3; 
$total_pages=ceil($count_smi_about_full/$mat_per_page); 


if (isset($_GET['page_akt'])) $page=($_GET['page_akt']-1); else $page=0;

$start=abs($page*$mat_per_page); // +1 --- кроме самого актуального

$query = "SELECT c.el_id AS id,c.icont_text AS prev_text,a.icont_text AS title,d.icont_text AS date,f.icont_text AS full_text,
                 IF(d.icont_text<>'',d.icont_text,d0.icont_text) AS date
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_content AS d ON d.el_id=a.el_id AND d.icont_var='date2'
				 INNER JOIN adm_ilines_content AS d0 ON d0.el_id=a.el_id AND d0.icont_var='date'
				 INNER JOIN adm_ilines_content AS c ON c.el_id=a.el_id AND c.icont_var='prev_text'
				 INNER JOIN adm_ilines_content AS pl ON pl.el_id=a.el_id AND pl.icont_var='people'
				 LEFT OUTER JOIN adm_ilines_content AS f ON f.el_id=a.el_id AND f.icont_var='full_text'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND (e.itype_id=3 OR e.itype_id=16)
				 WHERE a.icont_var='title' AND s.icont_text=1 AND (1<>1$autors OR e.itype_id=16)
                 ORDER BY d.icont_text DESC LIMIT ".$start.",".$mat_per_page."
                " or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 




echo '<div class="single singleFull">';

echo '<br><b>Страницы:</b>';

  if($page!=0)
  	echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_akt='.($page).'">'."<b> предыдущая&nbsp;&nbsp;←</b>"."</a> ";

$count_local_smi=0;
for($i=$page+1;$i<=$total_pages;$i++) {
  if ($i-1 == $page) {
    echo $i." ";
  } else {
    echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_akt='.$i.'">'.$i."</a> ";
  }
  if($count_local_smi==5)
  	break;
  else
  	$count_local_smi++;
}

  if($total_pages>$page+1)
  	echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_akt='.($page+2).'">'."<b>→&nbsp;следующая</b>"."</a> ";

  echo '<br><br>';

while($rows = mysqli_fetch_array($result)) 
{ 
     if(isset($rows["date"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows["date"], $matches);
		$rows["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$rows["date"] = date("d.m.Y", $rows["date"]);
	}			
//echo "<div class='title red'>";
//       echo $rows[date]."<br /><b style='font-size:16px;'><a target='_blank' href=/index.php?page_id=502&id=".$rows[id]."&ret=636>".$rows['title']."</a></b>";
//echo  "</div>";


echo '<table bgcolor="#f7f7f7" cellpadding="6" width="100%">
	<tbody><tr>
		<td style="padding: 10px 10px 10px 10px;" valign="top">
			</td>
		<td valign="top" width="100%">
			<font size="3"><b>'.$rows['title'].'</b></font>
			'.$rows[prev_text];
if (!empty($rows[full_text]))
    echo "<a target='_blank' href=/index.php?page_id=502&id=".$rows[id]."&ret=527>подробнее...</a>";
echo '</td>
	</tr><tr>
</tr></tbody></table>';


/*echo '<table vspace=3><tr><td>';
echo $img_smi_piar;
echo '</td><td>';
echo $rows[prev_text];
echo '</td></tr></table>';
if (!empty($rows[full_text]))
    echo "<a target='_blank' href=/index.php?page_id=502&id=".$rows[id]."&ret=636>подробнее...</a>";*/
    echo '<br clear="all">';
}
echo '<br><br><b>Страницы:</b>';

  if($page!=0)
  	echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_akt='.($page).'">'."<b> предыдущая&nbsp;&nbsp;←</b>"."</a> ";



$count_local_smi=0;
for($i=$page+1;$i<=$total_pages;$i++) {
  if ($i-1 == $page) {
    echo $i." ";
  } else {
    echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_akt='.$i.'">'.$i."</a> ";
  }
  if($count_local_smi==5)
  	break;
  else
  	$count_local_smi++;
}

  if($total_pages>$page+1)
  	echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_akt='.($page+2).'">'."<b>→&nbsp;следующая</b>"."</a> ";
  echo '<p></p>';
  

echo '</div>';
?>
