<?php

class OnSiteAdmin {

    public function __construct()
    {
    }

    public function saveContent() {
        global $DB;

        if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_POST['htmlData']) && !empty($_POST['page_edit_id']) && !empty($_POST['mode'])) {
            $pageEditStr = explode("-",$_POST['page_edit_id']);
            $_POST['htmlData'] = mb_convert_encoding($_POST['htmlData'],"windows-1251","UTF-8");

            if($_POST['mode']=="edit-page") {
                if($_POST['edit_lang']!="/en") {
                    $DB->query("UPDATE adm_pages_content SET cv_text=? WHERE cv_name='CONTENT' AND page_id=?d", $_POST['htmlData'], $pageEditStr[2]);
                } else {
                    $DB->query("UPDATE adm_pages_content SET cv_text=? WHERE cv_name='CONTENT_EN' AND page_id=?d", $_POST['htmlData'], $pageEditStr[2]);
                }
            }
            $cacheEngine = new CacheEngine();
            $cacheEngine->reset();
        }
    }
}