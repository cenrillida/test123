<?php

class CacheEngine {
    private $page;
    private $excludedTemplates;
    private static $_instance = null;

    public function __construct()
    {
        global $DB;

        $uri = $_SERVER["REQUEST_URI"];

        if (($_SERVER['SERVER_NAME'] == 'pwjournal.ru' || $_SERVER['SERVER_NAME'] == 'www.pwjournal.ru')) {
            if(!empty($_SESSION[lang])) {
                if (substr($uri,0,3) == '/en') {
                    $uri = '/en/pwjournal' . substr($uri,3);
                }
            } else {
                $uri = '/pwjournal' . $uri;
            }
        }

        $this->page = $DB->selectRow("SELECT * FROM cached_pages WHERE uri=?",$uri);
        $this->excludedTemplates = array(
            "specrub_statistic",
            "statistic_show",
            "adminv6",
            "adminv6_table_source",
            "adminv6_table_update",
            "cei_admin",
            "click",
            "ajax_stat",
            "delay",
            "download",
            "feedback_full",
            "feedback_view",
            "login_imemo",
            "login_meimo",
            "oni_documents_2nd_module",
            "oni_documents_ver2",
            "psw",
            "iframe_retranslator",
            "ajax",
            "sitemap",
            "asp_lk",
            "asp_lk_login",
            "asp_lk_register",
            "asp_lk_register_confirm",
            "asp_lk_password_reset",
            "ac_lk",
            "ac_lk_login",
            "crossref_lk",
            "crossref_lk_login",
            "contest_lk",
            "contest_lk_login",
            "ac_questionnaire",
            "mag_article_send",
            "cer_model",
            "cer_model2",
            "cer_model3",
            "cer_model4",
            "energyeconomics",
            "rest",
            "dissertation_councils_lk",
            "dissertation_councils_lk_login"
        );
    }

    public static function getInstance() {
        if(self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function tryLoadPage() {
        if(!empty($this->page)) {
            $filename = $this->page['filename'];
            if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/cache/".$filename)) {
                include_once($_SERVER["DOCUMENT_ROOT"] . "/cache/" . $filename);
                exit;
            } else {
                global $DB;
                $DB->query("DELETE FROM cached_pages WHERE filename=?", $filename);
            }
        }
    }

    public function saveAndLoadPage() {
        global $DB,$_CONFIG,$page_attr,$site_templater;
        if(empty($cachedPage)) {

            include_once substr($_CONFIG["global"]["paths"]['admin_path'], 0, -10) . "classes/guid/guid.php";

            ob_start();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . $page_attr["page_template"] . ".html");
            $html_index = ob_get_clean();

            $guid = new guid();
            $uniqid = $_REQUEST["page_id"] . "_" . str_replace("-", "_", $guid->tostring()) . ".html";

            //var_dump($_SERVER["DOCUMENT_ROOT"]."/cache/".$uniqid.".html");
            $handle = fopen($_SERVER["DOCUMENT_ROOT"] . "/cache/" . $uniqid, "w");
            fwrite($handle, $html_index);
            fclose($handle);

            $uri = $_SERVER["REQUEST_URI"];

            if (($_SERVER['SERVER_NAME'] == 'pwjournal.ru' || $_SERVER['SERVER_NAME'] == 'www.pwjournal.ru')) {
                if(!empty($_SESSION[lang])) {
                    if (substr($uri,0,3) == '/en') {
                        $uri = '/en/pwjournal' . substr($uri,3);
                    }
                } else {
                    $uri = '/pwjournal' . $uri;
                }
            }

            $DB->query("INSERT INTO cached_pages(uri,filename) VALUES(?,?)", $uri, $uniqid);

            if(!file_exists($_SERVER["DOCUMENT_ROOT"] . "/cache/".$uniqid)) {
                $DB->query("DELETE FROM cached_pages WHERE filename=?", $uniqid);
                $this->saveAndLoadPage();
            }

            include_once($_SERVER["DOCUMENT_ROOT"] . "/cache/".$uniqid);
        }
    }

    public function checkExclude() {
        global $page_attr;

        if(!empty($_POST)) {
            return false;
        }

        if($_REQUEST["userid_meimo"]==1 || $_COOKIE["userid_meimo"]==1) {
            return false;
        }

        if($_SESSION['meimo_authorization']==1) {
            return false;
        }

        if($_SESSION["on_site_edit"]==1) {
            return false;
        }

        if(in_array($page_attr["page_template"],$this->excludedTemplates)) {
            return false;
        }

        if(!empty($_GET['ajax_mode'])) {
            return false;
        }

        if(!empty($_GET['ajax_stat_mode'])) {
            return false;
        }

        if(!empty($_GET['ajax_get_views_mode'])) {
            return false;
        }
        if(!empty($_GET['debug'])) {
            return false;
        }
        return true;
    }

    public function reset() {
        global $DB;

        //$DB->query("LOCK TABLES cached_pages WRITE");
        $DB->query('DELETE FROM cached_pages');
        $DB->query('DELETE FROM cached_filters');
        //$DB->query("UNLOCK TABLES");

        $files = glob($_SERVER["DOCUMENT_ROOT"]."/cache/*");

        foreach ($files as $file) {
            if(is_file($file))
                unlink($file);
        }
    }

    public function startRegister() {
        ob_start();
    }

    public function finishRegisterFilter($filterId, $withBack, $english) {
        global $DB;

        $content = ob_get_clean();

        $DB->query("INSERT INTO cached_filters(filter_id,with_back,content,english) VALUES(?d,?d,?,?d)",
            $filterId,
            $withBack,
            $content,
            $english
        );

        echo $content;
    }

    public function tryLoadFilter($filterId, $withBack, $english) {
        global $DB;

        $content = $DB->selectRow("SELECT content FROM cached_filters WHERE filter_id=?d AND with_back=?d AND english=?d",$filterId, $withBack, $english);

        if(!empty($content)) {
            echo $content['content'];
            return false;
        }

        return true;
    }
}