<?php
/*
function findNumberIDbyArticleID($id) {
    global $DB;
    //$page_parent = $DB->select("SELECT page_parent FROM adm_article WHERE page_id=".(int)$id);
    if($id!=0) {
        $number = $DB->select("SELECT page_parent, page_template FROM adm_article WHERE page_id=".$id);
        if(!empty($number)) {
            if($number[0][page_template]=='jnumber')
                return $id;
            else
                return findNumberIDbyArticleID((int)$number[0][page_parent]);
        }
    }
    return 0;
}

include_once dirname(__FILE__)."/_include.php";

$articles = $DB->select("SELECT * FROM adm_article WHERE page_template='jarticle'");

foreach ($articles as $article) {
    $jid = findNumberIDbyArticleID($article['page_id']);

    if(!empty($jid) && $jid!=0) {
        $jidArr=$DB->select("SELECT cv_text AS date_public FROM adm_article_content WHERE cv_name='DATE_PUBLIC' AND page_id=".$jid);
        if(!empty($jidArr[0][date_public])) {
            $DB->query("UPDATE adm_article SET date_public=? WHERE page_id=?d", $jidArr[0][date_public],$article["page_id"]);
        }
    }
}*/