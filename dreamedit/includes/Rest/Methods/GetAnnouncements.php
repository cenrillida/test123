<?php

namespace Rest\Methods;

use Rest\Models\Announcement;

class GetAnnouncements implements \RestMethod {

    private $announcements;

    function __construct() {
        $this->announcements = array();
    }

    function execute($params) {
        $news = new \News();
        $announcements = $news->getAnnouncements();

        $langPrefix = "";
        if($params['lang']=="en") {
            $langPrefix = "_EN";
        }
        foreach ($announcements as $k=>$v) {
            $this->announcements[] = new Announcement(
                $v['el_id'],
                iconv("cp1251","UTF-8", $v['content']["DATE_FORMAT"]),
                iconv("cp1251","UTF-8", $v['content']["PREV_TEXT".$langPrefix]),
                iconv("cp1251","UTF-8", $v["content"]["FULL_TEXT".$langPrefix])
            );
        }
        $announcement = new Announcement("1","2","3","4");
        $this->announcements[] = $announcement;
        return $this->announcements;
    }

}