<?php

require_once "Methods/GetAnnouncements.php";
require_once "Methods/GetNotifications.php";
require_once "Methods/GetFirstNews.php";
require_once "Methods/GetPages.php";

interface RestMethod {
    /**
     * @return array
     */
    function execute($params);
}