<?
global $_CONFIG, $site_templater;
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

	$ilines = new Ilines();

	$notifications = $ilines->getLimitedElements($_TPL_REPLACMENT['NEWS_LINE'],9999,1,"date","DESC","status");
	$notifications = $ilines->appendContent($notifications);

	foreach ($notifications as $notification) {
	    $newClass = "";
	    if(isset($notification['content']['NOTIFICATION_END'])) {
            $endTime = DateTime::createFromFormat("Y.m.d H:i",$notification['content']['NOTIFICATION_END']);
            $now = new DateTime();
            if($endTime>$now) {
                $newClass = " notification__content-new";
            }
        }

	    echo "<div class=\"notification__content{$newClass}\">";
        echo $notification['content']['CONTENT'];
        echo "</div>";
    }

	$notificationService = new NotificationService();
	$unreadNotifications = $notificationService->getUserUnreadNotifications(59);
?>
    <style>
        .notification__content-new::before {
            content: '<?php if($_SESSION['lang']!="/en") echo "Новое"; else echo "New";?>';
        }
    </style>
<?php
	foreach ($unreadNotifications as $notification) {
		?>
		<script>
			var largeExpDate = new Date ();
			largeExpDate.setTime(largeExpDate.getTime() + (365 * 24 * 3600 * 1000));
			setCookie('notification-<?=$notification['id']?>-showed',"1",largeExpDate,null,null,1);
		</script>
		<?php
	}

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

?>
