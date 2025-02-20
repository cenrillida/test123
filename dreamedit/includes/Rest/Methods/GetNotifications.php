<?php

namespace Rest\Methods;

use Rest\Models\Notification;

class GetNotifications implements \RestMethod {

    private $notifications;

    function __construct() {
        $this->notifications = array();
    }

    function execute($params) {
        $notificationService = new \NotificationService();
        $notifications = $notificationService->getUserUnreadNotifications();

        foreach ($notifications as $k=>$v) {
            $this->notifications[] = new Notification(
                $v['id'],
                iconv("cp1251","UTF-8", $v["date"]),
                iconv("cp1251","UTF-8", $v["notification_end"]),
                iconv("cp1251","UTF-8", $v["content"]),
                iconv("cp1251","UTF-8", $v["iline_id"])
            );
        }
        return $this->notifications;
    }

}