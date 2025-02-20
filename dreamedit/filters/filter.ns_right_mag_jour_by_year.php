<?php
global $DB,$_CONFIG,$site_templater;

$mz = new MagazineNew();
$rowsm=$mz->getMagazineAllYearByName($_TPL_REPLACMENT["MAIN_JOUR_ID"]);
$years="";

    foreach($rowsm as $row)
    {
        $years.=" <a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"].
            "&article_id=".$row["page_id"].
            ">".$row["year"]."</a> |";

    }

echo $years;