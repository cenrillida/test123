<?php

class PwJournalParser
{
    /**
     * @var Pages
     */
    private $pages;

    /**
     * @param Pages $pages
     */
    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    public function tryLoadPwJournal() {
        global $DB;

        $pwJournalPages = $DB->select("SELECT page_id FROM adm_pages WHERE to_pwjournal=1");
        $pwJournalPages = array_map(function ($page) {
            return $page['page_id'];
        }, $pwJournalPages);

        //$pwJournalPages = array_merge($pwJournalPages, array(1555));
        $bothAllowedPages = array(
            1555
        );

//        $pwJournalAllowedPages = array(
//            1298,
//            2132,
//            2134,
//            2135,
//            2136,
//            2137,
//            2138,
//            2139,
//            2140,
//            2141,
//            2142,
//            2143,
//            2144,
//            2145,
//            2146,
//            2147,
//            2148,
//        );

        if (($_SERVER['SERVER_NAME'] == 'pwjournal.ru' || $_SERVER['SERVER_NAME'] == 'www.pwjournal.ru')) {
            if(! in_array($_REQUEST['page_id'], $pwJournalPages) && ! in_array($_REQUEST['page_id'], $bothAllowedPages)) {
                Dreamedit::sendHeaderByCode(404);
                exit;
            }
        } else {
            // TODO: redirect to pwjournal.ru
            if(in_array($_REQUEST['page_id'], $pwJournalPages)) {

                if(substr($_SERVER['REQUEST_URI'],0,13) == '/en/pwjournal') {
                    $uri = substr($_SERVER['REQUEST_URI'],13);
                } elseif(substr($_SERVER['REQUEST_URI'],0,10) == '/pwjournal') {
                    $uri = substr($_SERVER['REQUEST_URI'], 10);
                }

                if (!is_null($uri)) {
                    Dreamedit::sendHeaderByCode(301);
                    // нужн?подставлять протокол!!!

                    if ($_SESSION[lang]=="/en")
                        Dreamedit::sendLocationHeader("https://www.pwjournal.ru/en".$uri);
                    else
                        Dreamedit::sendLocationHeader("https://www.pwjournal.ru".$uri);
                    exit;
                }

                Dreamedit::sendHeaderByCode(404);
                exit;
            }
        }
    }
}