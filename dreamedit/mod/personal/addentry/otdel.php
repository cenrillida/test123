<?

$pg = new Pages();

$podr = $pg->getPages();
$spe = $podr[4965][childNodes];
$podr_page=417;

$menu1 = '';
$old = '';
$new = '';



echo "<select name=".$_POST[otd_name].">";
echo "<option value=''></option>";
$pp0=$pg->getChilds($podr_page);

foreach($pp0 as $pp)
{
    if($pp['page_name']=="Дополнительные страницы")
        continue;
	if ($cow[$_POST[otd_name]]==$pp[page_id]) $sel="selected"; else $sel="";
	echo "<option value='".$pp[page_id]."' ".$sel.">".$pp[page_name]."</option>";
	$pp20=$pg->getChilds($pp[page_id]);
	foreach ($pp20 as $pp2)
	{
        if($pp2['page_name']=="Дополнительные страницы")
            continue;
        if ($cow[$_POST[otd_name]]==$pp2[page_id]) $sel="selected"; else $sel="";
        echo "<option value='".$pp2[page_id]."' ".$sel.">".$pp2[page_name]."</option>";

        $pp30=$pg->getChilds($pp2[page_id]);
	   foreach ($pp30 as $pp3)
    	{
            if($pp3['page_name']=="Дополнительные страницы")
                continue;
           if ($cow[$_POST[otd_name]]==$pp3[page_id]) $sel="selected"; else $sel="";
           echo "<option value='".$pp3[page_id]."' ".$sel.">".$pp3[page_name]."</option>";
        }
     }
 }


echo "</select><br>";

?>

