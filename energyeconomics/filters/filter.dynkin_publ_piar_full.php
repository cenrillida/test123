<?php
// Главная новость

$query = "SELECT * FROM publ WHERE dynkin_piar=1 ORDER BY year DESC" or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 

$count_smi_about_full=0;

while($rows = mysqli_fetch_array($result)) 
{ 
	$count_smi_about_full++;
}

//$num_of_rows=mysql_num_rows($result);
$mat_per_page=4; 
$total_pages=ceil($count_smi_about_full/$mat_per_page); 


if (isset($_GET['page_dynkin_publ'])) $page=($_GET['page_dynkin_publ']-1); else $page=0;

$start=abs($page*$mat_per_page);

$query = "SELECT * FROM publ WHERE dynkin_piar=1 ORDER BY year DESC LIMIT ".$start.",".$mat_per_page or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 




echo '<div class="single singleFull">';

echo '<br><b>Страницы:</b>';

  if($page!=0)
  	echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_dynkin_publ='.($page).'">'."<b> предыдущая&nbsp;&nbsp;←</b>"."</a> ";

$count_local_smi=0;
for($i=$page+1;$i<=$total_pages;$i++) {
  if ($i-1 == $page) {
    echo $i." ";
  } else {
    echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_dynkin_publ='.$i.'">'.$i."</a> ";
  }
  if($count_local_smi==5)
  	break;
  else
  	$count_local_smi++;
}

  if($total_pages>$page+1)
  	echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_dynkin_publ='.($page+2).'">'."<b>→&nbsp;следующая</b>"."</a> ";

  echo '<br><br>';
  
$current_left=true;

$numResultsR = mysqli_num_rows($result);
$counterR = 0;

while($rows = mysqli_fetch_array($result)) 
{ 
$counterR++;
if(!empty($rows[picsmall]))
$img_smi_piar=$rows[picsmall];
else
$img_smi_piar="e_logo.jpg";
if($rows[avtor]!='' && $rows[avtor]!='<br>')
{
  $query = "SELECT id,surname,name,fname FROM persons WHERE id=".strstr($rows[avtor], '<', true) or die("Error in the consult.." . mysqli_error($link)); 
  $result_smi_piar = $link->query($query); 
  $row_name_smi_piar = mysqli_fetch_array($result_smi_piar);

  $name_id=$row_name_smi_piar[id];
  $name_full=$row_name_smi_piar[surname]." ".substr($row_name_smi_piar[name], 0,2).".".substr($row_name_smi_piar[fname], 0,2).".";
}

if($current_left)
{
	echo '<table style="width:90%;" border="0"><tbody><tr>';
}
echo '<td style="vertical-align:top;">
            <a target="_blank" href="/index.php?page_id=645&amp;id='.$rows[id].'" title="Открыть"><img alt="../dreamedit/pfoto/'.$img_smi_piar.'" title="" src="../dreamedit/pfoto/'.$img_smi_piar.'" style="border-color:#cecce8; border: 3px solid #cecce8;" hspace="20" border="3" vspace="2"></a><br>
               </td>';
if(!$current_left)
{
	echo '</tr></tbody></table>';
	$current_left=true;
}
else
{
	$current_left=false;
	if ($counterR == $numResultsR) 
		echo '</tr></tbody></table>';
}
}
echo '<br><br><b>Страницы:</b>';

  if($page!=0)
  	echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_dynkin_publ='.($page).'">'."<b> предыдущая&nbsp;&nbsp;←</b>"."</a> ";

$count_local_smi=0;
for($i=$page+1;$i<=$total_pages;$i++) {
  if ($i-1 == $page) {
    echo $i." ";
  } else {
    echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_dynkin_publ='.$i.'">'.$i."</a> ";
  }
  if($count_local_smi==5)
  	break;
  else
  	$count_local_smi++;
}

  if($total_pages>$page+1)
  	echo '<a href="'.$_SERVER['PHP_SELF'].'?page_id='.$_GET['page_id'].'&page_dynkin_publ='.($page+2).'">'."<b>→&nbsp;следующая</b>"."</a> ";
  echo '<p></p>';
  

echo '</div>';
?>
