<?php

class UriParser {

    private $ilinesList;
    private $publsList;
    private $periodicalRegexp = '/^(?:(?:publications\/(periodical|electronic-resources)\/(.+))|(pwjournal))\/archive/';
    private $periodicalRubricRegexp = '/^(?:(?:publications\/(periodical|electronic-resources)\/(.+))|(pwjournal))\/rubric-index\/rubric/';
    private $publPageId = 645;
    /**
     * @var Pages
     */
    private $pages;

    /**
     * @param Pages $pages
     */
    public function __construct($pages)
    {
        $this->ilinesList = array("NEWS_BLOCK_PAGE","FULL_SMI_ID", "DISSER_FULL_ID", "REC_COM_FULL_ID");
        $this->publsList = array("PUBL_PAGE");
        $this->pages = $pages;
    }

    private function tryToGetPage($pageUrl) {

        $articlePage = $this->parseArticle($pageUrl);
        if($articlePage != -1) {
            return $articlePage;
        }

        $articleRubricPage = $this->parseArticleRubric($pageUrl);
        if($articleRubricPage != -1) {
            return $articleRubricPage;
        }

        $ilinePage = $this->parseIline($pageUrl);
        if($ilinePage != -1) {
            return $ilinePage;
        }

        $publPage = $this->parsePubl($pageUrl);
        if($publPage != -1) {
            return $publPage;
        }

        return $this->pages->getPageByUrl($pageUrl, 1);
    }

    /**
     * @return int
     */
    public function parseUri() {
        global $DB;

        // парсим uri
        $uri = explode("?", $_SERVER["REQUEST_URI"]);

        $pageUrl = substr($uri[0], 1, strlen($uri[0]));

        if(\TelegramBot\TelegramBot::getInstance()->isTelegramRequest($pageUrl)) {
            \TelegramBot\TelegramBot::getInstance()->processRequest();
            exit;
        }

        // пробуе?найт?по urlname'?
        if(!empty($pageUrl))
        {

            if(!empty($_SESSION[lang])) {
                if($uri[0]=="/en") {
                    return -1;
                }
                if(substr($pageUrl,0,3) == "en/") {
                  $pageUrl = substr($pageUrl,3);
                }
                //$pageUrl = str_replace("en/", "", $pageUrl);
            }

            if (($_SERVER['SERVER_NAME'] == 'pwjournal.ru' || $_SERVER['SERVER_NAME'] == 'www.pwjournal.ru')) {
                $pageUrl = 'pwjournal/' . $pageUrl;
            }

            if(!empty($_SESSION[jour]))
            {

                if($_SESSION[jour]=="/jour")
                    $pageUrl = str_replace("jour/","",$pageUrl);
                if($_SESSION[jour]=="/jour_cut")
                    $pageUrl = str_replace("jour_cut/","",$pageUrl);
            }

            $pageUrl = rtrim($pageUrl, "/");

            $page = $this->tryToGetPage($pageUrl);

            $pageId = (int)@$page["page_id"];
            $this->pages->registHiddenVariables($pageId, $pageUrl);

            return $pageId;

        }
        else
        {

            return -1;
        }
    }

    public function parseArticleRubric($pageUrl) {
        global $DB;

        if(!preg_match($this->periodicalRubricRegexp,$pageUrl, $matchesUrls)) return -1;

        $page = $this->parseArticleRubricUri($pageUrl,$matchesUrls[0],$matchesUrls[2]);

        if(!empty($matchesUrls[3]) && $matchesUrls[3] === 'pwjournal') {
            $matchesUrls[2] = 'pwjournal';
        }

        if($page != -1) {
            return $page;
        }

        return -1;
    }

    public function parseArticleRubricUri($pageUrl,$uri,$magUrl) {
        global $DB;

        $magIndex = 0;
        $mag = $DB->selectRow("SELECT page_id FROM adm_pages 
                        WHERE page_template = 'mag_index'
                        AND page_urlname LIKE ?", "%/$magUrl");
        if(!empty($mag) && !empty($mag['page_id'])) {
            $magIndex = $mag['page_id'];
        }

        $urlExploded = explode("/",$pageUrl);
        $pageUrlExploded = explode("/",$uri);
        $pageUrlExplodedCount = count($pageUrlExploded);

        if(!empty($urlExploded[$pageUrlExplodedCount])) {
            $publ = $DB->selectRow("SELECT * FROM adm_article WHERE (article_url LIKE ? OR article_url=?) AND journal_new=?d", "%/".$urlExploded[$pageUrlExplodedCount],$urlExploded[$pageUrlExplodedCount],$magIndex);

            if(!empty($publ)) {

                $_REQUEST['article_id'] = $publ['page_id'];
                $_GET['article_id'] = $publ['page_id'];
                $page_res = $this->pages->getPageByUrl($uri, 1);
                return $page_res;
            }
        } else {
            if(!empty($_GET['article_id'])) {
                $article = $DB->selectRow("SELECT * FROM adm_article WHERE page_id=?d AND journal_new=?d", (int)$_GET['article_id'], $magIndex);
                if(!empty($article)) {

                    $urlExploded = explode("/",$article["article_url"]);
                    $pageUrlExplodedCount = count($urlExploded)-1;

                    $qStr = preg_replace("/article_id=".(int)$_GET["article_id"]."&?/", "", $_SERVER["QUERY_STRING"]);
                    Dreamedit::sendHeaderByCode(301);
                    // нужн?подставлять протокол!!!

                    if ($_SESSION[lang]=="/en")
                        Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/en/".$uri."/".$urlExploded[$pageUrlExplodedCount].(!empty($qStr)? "?".$qStr: ""));
                    else
                        Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/".$uri."/".$urlExploded[$pageUrlExplodedCount].(!empty($qStr)? "?".$qStr: ""));
                }
            }
        }
        return -1;
    }

    public function parseArticle($pageUrl) {
        global $DB;

        if(!preg_match($this->periodicalRegexp,$pageUrl, $matchesUrls)) return -1;

        if(!empty($matchesUrls[3]) && $matchesUrls[3] === 'pwjournal') {
            $matchesUrls[2] = 'pwjournal';
        }

        $page = $this->parseArticleUri($pageUrl,$matchesUrls[0],$matchesUrls[2]);

        if($page != -1) {
            return $page;
        }

        return -1;
    }

    public function parseArticleUri($pageUrl,$uri,$magUrl) {
        global $DB;

        $magIndex = 0;
        if ($magUrl === 'pwjournal') {
            $mag = $DB->selectRow("SELECT page_id FROM adm_pages 
                        WHERE page_template = 'mag_index'
                        AND page_urlname LIKE ?", "pwjournal");
        } else {
            $mag = $DB->selectRow("SELECT page_id FROM adm_pages 
                        WHERE page_template = 'mag_index'
                        AND page_urlname LIKE ?", "%/$magUrl");
        }

        if(!empty($mag) && !empty($mag['page_id'])) {
            $magIndex = $mag['page_id'];
        }

        $urlExploded = explode("/",$pageUrl);
        $articleUrl = substr($pageUrl,strlen($uri));

        if(substr($articleUrl,0,1)=="/") {
            $articleUrl = substr($articleUrl,1);
        }

        if(!empty($articleUrl)) {
            $article = $DB->selectRow("SELECT * FROM adm_article WHERE article_url=? AND journal_new=?d", $articleUrl, $magIndex);

            if(!empty($article)) {

                $_REQUEST['article_id'] = $article['page_id'];
                $_GET['article_id'] = $article['page_id'];
                $page_res = $this->pages->getPageByUrl($uri, 1);
                return $page_res;
            }
        } else {

            if(!empty($_GET['article_id'])) {
                $article = $DB->selectRow("SELECT * FROM adm_article WHERE page_id=?d AND journal_new=?d", (int)$_GET['article_id'], $magIndex);

                if(!empty($article)) {
                    $qStr = preg_replace("/article_id=".(int)$_GET["article_id"]."&?/", "", $_SERVER["QUERY_STRING"]);
                    Dreamedit::sendHeaderByCode(301);
                    // нужн?подставлять протокол!!!
                    if (($_SERVER['SERVER_NAME'] == 'pwjournal.ru' || $_SERVER['SERVER_NAME'] == 'www.pwjournal.ru')) {
                        if(substr($uri,0,10)=='pwjournal/') {
                            $uri = substr($uri,10);
                        }
                    }

                    if ($_SESSION[lang]=="/en")
                        Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/en/".$uri."/".$article["article_url"].(!empty($qStr)? "?".$qStr: ""));
                    else
                        Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/".$uri."/".$article["article_url"].(!empty($qStr)? "?".$qStr: ""));
                }
            }
        }
        return -1;
    }

    public function parsePubl($pageUrl) {
        global $DB;

        $publPage = $this->pages->getPageById($this->publPageId);
        $page = $this->parsePublUri($pageUrl,$publPage);

        if($page != -1) {
            return $page;
        }

        return -1;
    }

    public function parsePublUri($pageUrl,$publPage) {
        global $DB;

        $uri = $publPage['page_urlname'];

        if(substr($pageUrl,0,strlen($uri))==$uri && strlen($uri)>1) {
            $urlExploded = explode("/",$pageUrl);
            $pageUrlExploded = explode("/",$uri);
            $pageUrlExplodedCount = count($pageUrlExploded);

            if(!empty($urlExploded[$pageUrlExplodedCount])) {
                $publ = $DB->selectRow("SELECT * FROM publ WHERE uri=?", $urlExploded[$pageUrlExplodedCount]);

                if(!empty($publ)) {
                    $_REQUEST['id'] = $publ['id'];
                    $_GET['id'] = $publ['id'];
                    return $publPage;
                }
            } else {
                if(!empty($_GET['id'])) {
                    $publ = $DB->selectRow("SELECT * FROM publ WHERE id=?d", (int)$_GET['id']);
                    if(!empty($publ)) {
                        $qStr = preg_replace("/id=".(int)$_GET["id"]."&?/", "", $_SERVER["QUERY_STRING"]);
                        Dreamedit::sendHeaderByCode(301);
                        // нужн?подставлять протокол!!!

                        if ($_SESSION[lang]=="/en")
                            Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/en/".$uri."/".$publ["uri"].(!empty($qStr)? "?".$qStr: ""));
                        else
                            Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/".$uri."/".$publ["uri"].(!empty($qStr)? "?".$qStr: ""));
                    }
                }
            }
        }
        return -1;
    }

    public function parseIline($pageUrl) {
        global $DB;

        $ilinesPages = $DB->select("SELECT page_id,page_urlname FROM `adm_pages` 
                            WHERE (page_template='news_full' OR page_template='smi_full' OR page_template='diser_full')
                            AND page_status = 1 
                            AND page_urlname <> ''");
        foreach ($ilinesPages as $ilinesPage) {
            $page = $this->parseIlineUri($pageUrl,$ilinesPage);

            if($page != -1) {
                return $page;
            }
        }
        return -1;
    }

    public function parseIlineUri($pageUrl,$page) {
        global $DB;
        $uri = $page['page_urlname'];

        if(substr($pageUrl,0,strlen($uri))!=$uri || strlen($uri)<=1) {
            return -1;
        }

        $urlExploded = explode("/",$pageUrl);
        $pageUrlExploded = explode("/",$uri);
        $pageUrlExplodedCount = count($pageUrlExploded);

        if(!empty($urlExploded[$pageUrlExplodedCount])) {
            $iline = $DB->selectRow("SELECT * FROM adm_ilines_content WHERE icont_var='iline_url' AND icont_text=?", $urlExploded[$pageUrlExplodedCount]);
            if(!empty($iline)) {
                $_REQUEST['id'] = $iline['el_id'];
                $_GET['id'] = $iline['el_id'];
                return $page;
            }
        } else {
            if(!empty($_GET['id'])) {
                $iline = $DB->selectRow("SELECT * FROM adm_ilines_content WHERE icont_var='iline_url' AND el_id=?d", (int)$_GET['id']);
                if(!empty($iline) && !empty($iline['icont_text'])) {
                    $qStr = preg_replace("/id=".(int)$_GET["id"]."&?/", "", $_SERVER["QUERY_STRING"]);
                    Dreamedit::sendHeaderByCode(301);
                    // нужн?подставлять протокол!!!



                    if ($_SESSION[lang]=="/en")
                        Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/en/".$uri."/".$iline["icont_text"].(!empty($qStr)? "?".$qStr: ""));
                    else
                        Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/".$uri."/".$iline["icont_text"].(!empty($qStr)? "?".$qStr: ""));
                }
            }
        }
        return -1;
    }
}