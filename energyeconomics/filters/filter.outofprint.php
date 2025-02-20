<?php
// Вышли из печати

global $link;

$query = "SELECT id,name FROM publ WHERE out_from_print=1" or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 

while($row = mysqli_fetch_array($result)) 
{
 echo "<p align=justify><strong><a target=_blank href=https://www.imemo.ru/index.php?page_id=645&amp;id=".$row[id]."><img alt= width=16 height=16 hspace=3 src=../files/Image/button.png /></a></strong><strong><a target=_blank href=/index.php?page_id=645&amp;id=".$row[id].">".$row['name']."</a></strong><strong> </strong></p>";
}

?>
