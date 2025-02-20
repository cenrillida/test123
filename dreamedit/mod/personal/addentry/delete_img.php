<?php
global $DB, $CONFIG;

$result =  $DB->selectRow('SELECT * from persons where id='.$_REQUEST['oi']);

if(!empty($result)) {
    if(!empty($result['picsmall'])) {
        $DB->query("UPDATE persons SET picsmall='' WHERE id=?",$_REQUEST['oi']);
        unlink(__DIR__ . '/../../../foto/'.$result['picsmall']);
    }
    if(!empty($result['picbig'])) {
        $DB->query("UPDATE persons SET picbig='' WHERE id=?",$_REQUEST['oi']);
        unlink(__DIR__ . '/../../../foto/'.$result['picbig']);
    }
    echo "Фотографии удалены";
} else {
    echo "Ошибка.";
}