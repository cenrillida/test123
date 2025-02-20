<?php

if($_SESSION[lang]!="/en") {
    $text = $_TPL_REPLACMENT["IN_MAGAZINE_CONTENT"];
} else {
    $text = $_TPL_REPLACMENT["IN_MAGAZINE_CONTENT_EN"];
}

$text = str_replace("{HOME_PAGE_JOUR}",$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["MAIN_JOUR_ID"],$text);
$text = str_replace("{ARCHIVE_ID_LINK}",$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"],$text);
$text = str_replace("{RUBRICS_ID_LINK}",$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["RUBRICS_ID"],$text);
$text = str_replace("{AUTHORS_ID_LINK}",$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["AUTHORS_ID"],$text);
$text = str_replace("{YEARS_ID_LINK}",$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["YEARS_ID"],$text);
$text = str_replace("{AUTHORS_YEARS_ID_LINK}",$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["AUTHORS_YEARS_ID"],$text);
$text = str_replace("{ART_ARCHIVE_EN_ID_LINK}",$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["ART_ARCHIVE_EN_ID"],$text);

echo $text;