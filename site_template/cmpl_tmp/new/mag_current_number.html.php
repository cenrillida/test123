<?php

$pg=new MagazineNew();

$jid0=$pg->getLastMagazineNumber($_TPL_REPLACMENT["MAIN_JOUR_ID"]);

Dreamedit::sendHeaderByCode(301);

if ($_SESSION[lang]=="/en")
    Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/en/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$jid0[0][page_id]);
else
    Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$jid0[0][page_id]);