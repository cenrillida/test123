<?

global $DB,$_CONFIG, $site_templater;
$_REQUEST["id"]=(int)$DB->cleanuserinput($_REQUEST["id"]);
$_REQUEST["page_id"]=$DB->cleanuserinput($_REQUEST["page_id"]);

if(empty($_GET['param'])) {
    $_GET['param'] = 'https://imemo.ru';
}

$module = "";
if($_GET['module']=="publ" || $_GET['module']=="article" || $_GET['module']=="afjourn") {
    $module = $_GET['module'];
}

if(!empty($module)) {
//Записать счетчик pdf
    $count0 = $DB->select("SELECT id,publ_count,pdf_count FROM publ_stat WHERE publ_id=?d AND `month`=? AND `year`=? AND `module`=?", (int)$_REQUEST["id"], date('m'), date('Y'), $module);
    $publ_count = $count0[0]["publ_count"];
    $pdf_count = $count0[0]["pdf_count"] + 1;

    if (count($count0) > 0)
        $DB->query("UPDATE publ_stat SET publ_count=?,pdf_count=?, `date`=? WHERE id=?", $publ_count, $pdf_count, date("Ymd"), $count0[0]["id"]);
    else
        $DB->query("INSERT INTO publ_stat (id,publ_id,publ_count,pdf_count,`date`,`month`,`year`,`module`)
                   VALUES(0,?,1,1,?,?,?,?)", (int)$_GET["id"], date("Ymd"), date('m'), date('Y'), $module);


    $m = new MongoClient();
    $visitsDb = $m->imemon;
    $collection = $visitsDb->publ_stat;

    $res = $collection->findOne(array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => (int)$_GET["id"], "module" => $module));

    if(!empty($res)) {
        $collection->update(array("_id" => $res['_id']),array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => (int)$_GET["id"], "module" => $module, "publ_count" => $res['publ_count'], "pdf_count" => $res['pdf_count']+1, "date" => date(Ymd)));
    } else {
        $collection->insert(array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => (int)$_GET["id"], "module" => $module, "publ_count" => 1, "pdf_count" => 1, "date" => date("Ymd")));
    }
}
//////////////////
if($_GET["script_download"]!=1) {
    ?>
    <meta http-equiv=refresh
          content="0; url=<?= @str_replace('^', ' ', $_GET["param"]) ?>">
    <?
}
else {
    ?>
    <meta http-equiv=refresh
          content="0; url=https://imemo.ru<?php echo $_SESSION["lang"]; ?>/index.php?page_id=1248&file=<?= @str_replace('^', ' ', $_GET["param"]) ?>">
    <?
}
