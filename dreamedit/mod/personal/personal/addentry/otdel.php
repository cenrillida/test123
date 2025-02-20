<?

$pg = new Pages();

$podr = $pg->getPages();
$spe = $podr[49][childNodes];

$menu1 = '';
$old = '';
$new = '';

echo ("<br><b>Отдел</b><br>");

for ($i=0; $i<count($spe); $i++)
 {
 $podpunct1 = $podr[$spe[$i]][childNodes];
  $menu1[$i] .= ("<OPTION value='".$podr[$spe[$i]][page_name]."'>".($i+1).". ".$podr[$spe[$i]][page_name]."</OPTION>");
 if(count($podpunct1)>0)
  {
   for ($j=0; $j<count($podpunct1); $j++)
    {
     $podpunct2 = $podr[$podr[$spe[$i]][childNodes][$j]][childNodes];
      $old[$i][$j] .= ("<option value='".$podr[$podr[$spe[$i]][childNodes][$j]][page_name]."' >&nbsp;&nbsp;&nbsp;".
	($i+1).".".($j+1).". ".$podr[$podr[$spe[$i]][childNodes][$j]][page_name]."</option>");
     if(count($podpunct2)>0)
      {
       for ($k=0; $k<count($podpunct2); $k++)
       {
       $new[$i][$j][$k] .= ("<OPTION VALUE='".$podr[$podr[$podr[$spe[$i]][childNodes][$j]][childNodes][$k]][page_name]."'>".
"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($i+1).".".($j+1).".".($k+1).". ".
$podr[$podr[$podr[$spe[$i]][childNodes][$j]][childNodes][$k]][page_name]."</OPTION>");
       }
      }
    }
  }
 }

if ($_POST['otdel'])
echo "<select name=otdel><option value='".$_POST['otdel']."'>".$_POST['otdel']."</option><option value=''>&nbsp;</option>";
else
echo "<select name=otdel><option value='".$cow[9]."'>".$cow[9]."</option><option value=''>&nbsp;</option>";
for ($i=0; $i<count($spe); $i++)
 {
  echo $menu1[$i];
  for ($j=0; $j<count($podr[$spe[$i]][childNodes]); $j++)
   {
    echo $old[$i][$j]; 
    for ($k=0; $k < count($podr[$podr[$spe[$i]][childNodes][$j]][childNodes]); $k++)
     echo $new[$i][$j][$k];
   }
 }

echo "</select><br>";

?>

