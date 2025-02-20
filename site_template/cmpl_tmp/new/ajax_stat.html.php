<?php

global $DB;

$eng_stat = "";
if($_GET['ajax_stat_lang']=="en")
    $eng_stat = "-en";

if($_GET['ajax_stat_mode']=="all") {
    Statistic::theCounter("all-web-site".$eng_stat);
    Statistic::addOsStat();
    Statistic::addBrowserStat();
    Statistic::addOsAgent();
}

if($_GET['ajax_stat_mode']=="jour") {
    $jour = preg_replace("/[^a-zA-Z-\d_ ]/","",$_GET['ajax_stat_id']);
    $jour = str_replace(" ","",$jour);
    if(!empty($jour)) {
        Statistic::theCounter($jour . $eng_stat);
    }
}

if($_GET['ajax_stat_mode']=="magarticle") {
    $id = (int)$_GET['ajax_stat_id'];
    if(!empty($id)) {
        Statistic::theCounter("magarticle-" . $id . $eng_stat);

        $count0=$DB->select("SELECT id,publ_count FROM publ_stat WHERE `module`='article' AND publ_id=? AND month=? AND year=?",$id,date('m'),date('Y'));
        $publ_count=$count0[0][publ_count]+1;

        if (count($count0) >0)
            $DB->query("UPDATE publ_stat SET publ_count=?, date=? WHERE id=?",$publ_count,date(Ymd),$count0[0][id]);
        else
            $DB->query("INSERT INTO publ_stat (id,publ_id,publ_count,pdf_count,date,month,year,`module`)
                   VALUES(0,?,1,0,?,?,?,'article')",$id,date(Ymd),date('m'),date('Y'));

        $m = new MongoClient();
        $visitsDb = $m->imemon;
        $collection = $visitsDb->publ_stat;

        $res = $collection->findOne(array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => (int)$id, "module" => "article"));

        if(!empty($res)) {
            $collection->update(array("_id" => $res['_id']),array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => (int)$id, "module" => "article", "publ_count" => $res['publ_count']+1, "pdf_count" => $res['pdf_count'], "date" => date(Ymd)));
        } else {
            $collection->insert(array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => (int)$id, "module" => "article", "publ_count" => 1, "pdf_count" => 0, "date" => date(Ymd)));
        }
    }
}

if($_GET['ajax_stat_mode']=="afjournal_article") {
    $id = (int)$_GET['ajax_stat_id'];
    if(!empty($id)) {
        $count0=$DB->select("SELECT id,publ_count FROM publ_stat WHERE `module`='afjourn' AND publ_id=? AND month=? AND year=?",$id,date('m'),date('Y'));
        if (count($count0) >0) {
            $publ_count=$count0[0][publ_count]+1;
            $DB->query("UPDATE publ_stat SET publ_count=?, date=? WHERE id=?",$publ_count,date(Ymd),$count0[0][id]);
        }
        else
            $DB->query("INSERT INTO publ_stat (id,publ_id,publ_count,pdf_count,date,month,year,`module`)
                   VALUES(0,?,1,0,?,?,?,'afjourn')",$id,date(Ymd),date('m'),date('Y'));
    }
}

if($_GET['ajax_stat_mode']=="pageid") {
    $id = (int)$_GET['ajax_stat_id'];
    if(!empty($id)) {
        Statistic::theCounter("pageid-" . $id . $eng_stat);
    }
}

if($_GET['ajax_stat_mode']=="specrub") {
    $id = (int)$_GET['ajax_stat_id'];
    if(!empty($id)) {
        Statistic::theCounter("specrub-" . $id . $eng_stat);
    }
}

if($_GET['ajax_stat_mode']=="presscenter") {
    Statistic::theCounter("presscenter");
}

if($_GET['ajax_stat_mode']=="newsfull") {
    $id = (int)$_GET['ajax_stat_id'];
    if(!empty($id)) {
        Statistic::theCounter("newsfull-" . $id . $eng_stat);
    }
}

if($_GET['ajax_stat_mode']=="publ") {
    $id = (int)$_GET['ajax_stat_id'];
    if(!empty($id)) {
        Statistic::theCounter("publ-" . $id . $eng_stat);

        $count0=$DB->select("SELECT id,publ_count FROM publ_stat WHERE `module`='publ' AND publ_id=? AND month=? AND year=?",$id,date('m'),date('Y'));
        $publ_count=$count0[0][publ_count]+1;

        if (count($count0) >0)
            $DB->query("UPDATE publ_stat SET publ_count=?, date=? WHERE id=?",$publ_count,date(Ymd),$count0[0][id]);
        else
            $DB->query("INSERT INTO publ_stat (id,publ_id,publ_count,pdf_count,date,month,year,`module`)
                   VALUES(0,?,1,0,?,?,?,'publ')",$id,date(Ymd),date('m'),date('Y'));

        $m = new MongoClient();
        $visitsDb = $m->imemon;
        $collection = $visitsDb->publ_stat;

        $res = $collection->findOne(array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => (int)$id, "module" => "publ"));

        if(!empty($res)) {
            $collection->update(array("_id" => $res['_id']),array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => (int)$id, "module" => "publ", "publ_count" => $res['publ_count']+1, "pdf_count" => $res['pdf_count'], "date" => date(Ymd)));
        } else {
            $collection->insert(array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => (int)$id, "module" => "publ", "publ_count" => 1, "pdf_count" => 0, "date" => date(Ymd)));
        }
    }
}

if($_GET['ajax_stat_mode']=="cerspecrub") {
    $id = (int)$_GET['ajax_stat_id'];
    if(!empty($id)) {
        Statistic::theCounter("cerspecrub-" . $id . $eng_stat);
    }
}

//views

if($_GET['ajax_get_views_mode']=="newsfull" || $_GET['ajax_get_views_mode']=="magarticle" || $_GET['ajax_get_views_mode']=="specrub" || $_GET['ajax_get_views_mode']=="pageid") {
    $id = (int)$_GET['ajax_stat_id'];
    $all_views = 0;
    if(!empty($id)) {
        $all_views = Statistic::getAllViews($_GET['ajax_get_views_mode']."-".$id.$eng_stat);
    }
    echo $all_views;
}

if($_GET['ajax_get_views_mode']=="all" ) {
    $visitors = Statistic::getStatMain();
    echo json_encode($visitors);
}

if($_GET['ajax_get_views_mode']=="jour") {
    $jour = preg_replace("/[^a-zA-Z-\d_ ]/","",$_GET['ajax_stat_id']);
    $jour = str_replace(" ","",$jour);
    $visitors = Statistic::getStatJour($jour);
    echo json_encode($visitors);
}