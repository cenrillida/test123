<?php
// ����� �� ������

global $link;

$query = "SELECT id FROM `persons` AS pers WHERE pers.otdel='424' OR pers.otdel2='424' OR pers.otdel3='424'" or die("Error in the consult.." . mysqli_error($link));
$result = $link->query($query);

$autors="";

$first=true;

while($row = mysqli_fetch_array($result))
{
  if($first) {
   $autors .= " WHERE avtor LIKE '" . $row[id] . "<br>%' OR avtor LIKE '%<br>" . $row[id] . "<br>%'";
   $first=false;
  }
  else
   $autors.=" OR avtor LIKE '".$row[id]."<br>%' OR avtor LIKE '%<br>".$row[id]."<br>%'";
}

$query = "SELECT id,name FROM publ".$autors." ORDER BY year DESC,id DESC LIMIT 3" or die("Error in the consult.." . mysqli_error($link));

$result = $link->query($query);

while($row = mysqli_fetch_array($result)) 
{
 echo "<p align=justify><strong><a target=_blank href=https://www.imemo.ru/index.php?page_id=645&amp;id=".$row[id]."><img alt= width=16 height=16 hspace=3 src=../files/Image/button.png /></a></strong><strong><a target=_blank href=/index.php?page_id=645&amp;id=".$row[id].">".$row['name']."</a></strong><strong> </strong></p>";
}

?>
