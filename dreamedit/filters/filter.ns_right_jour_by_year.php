<?php
global $DB,$_CONFIG,$site_templater;

$mz = new Magazine();
$rowsm=$mz->getMagazineAllYear($_SESSION[jour_id]);
$years="";
if($_SESSION[jour_url]=="REBQUE")
{
    $rows_rebque=$mz->getMagazineAllPublic();
    foreach($rows_rebque as $row)
    {
        $years.=" <a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=1025&jid=".$row[jid].
            ">".$row[year]."</a> |";
    }
}
else
{
    foreach($rowsm as $row)
    {
        $years.=" <a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT["YEARS_ID"].
            "&year=".$row[year].
            ">".$row[year]."</a> |";

    }
}
echo $years;