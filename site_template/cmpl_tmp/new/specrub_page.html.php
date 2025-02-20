<?
global $_CONFIG, $site_templater;

if($_GET['ajax_mode']==1) {
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_mode");
	exit;
}

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

	$all_views = Statistic::getAllViews("specrub-".(int)$_REQUEST["page_id"]);
	$specrubInt = (int)$_REQUEST["page_id"];

	if(!empty($specrubInt)) {
		Statistic::ajaxCounter("specrub",$specrubInt);
		Statistic::getAjaxViews("specrub", $specrubInt);
	}

	echo "<div style='text-align: right; color: #979797;'><img width='15px' style='vertical-align: middle' src='/img/eye.png' alt=''/> <span id='stat-views-counter' style='vertical-align: middle'>".$all_views."</span></div>";

	if (empty($_TPL_REPLACMENT["FULL_SMI_ID"])) $_TPL_REPLACMENT["FULL_SMI_ID"]=502;
	if (empty($_TPL_REPLACMENT["SORT_TYPE"])) $_TPL_REPLACMENT["SORT_TYPE"]="DESC";
	if (empty($_TPL_REPLACMENT["SORT_FIELD"])) $_TPL_REPLACMENT["SORT_FIELD"]="date";
	if (empty($_TPL_REPLACMENT["COUNT"])) $_TPL_REPLACMENT["COUNT"]=9;

	$ilines = new Ilines();

	if(isset($_GET["printall"]))
		$_TPL_REPLACMENT["COUNT"]=1000000;

	$pages = new Pages();

	$branch = $pages->getBranch((int)$_REQUEST["page_id"],1);

	$specrubs = array();
	foreach ($branch as $page) {
	    $specrubs[] = $page['page_id'];
    }

	$rows = $ilines->getLimitedElementsDateRubSpecRub("*", @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"],$specrubs);

	if(!empty($_TPL_REPLACMENT["TPL_NAME"]))
		$tplname=$_TPL_REPLACMENT["TPL_NAME"];
	else
		$tplname='smi_specrub';

	if(!empty($_TPL_REPLACMENT["EXTRA_SECTION"]) && $_SESSION["lang"]!="/en")
		echo "<div>".$_TPL_REPLACMENT["EXTRA_SECTION"]."</div>";

	if(!empty($_TPL_REPLACMENT["EXTRA_SECTION_EN"]) && $_SESSION["lang"]=="/en")
		echo "<div>".$_TPL_REPLACMENT["EXTRA_SECTION_EN"]."</div>";

	if (!isset($_GET["printmode"]))
	{
		if (empty($_SERVER["REDIRECT_URL"]))
			echo "<div class='mt-3' style='text-align:right;'><a class=\"btn btn-lg imemo-button text-uppercase imemo-print-button\" href=\"/index.php?".$_SERVER["QUERY_STRING"]."&printmode&printall\" role=\"button\">Весь список</a></div>";
		else
			echo "<div class='mt-3' style='text-align:right;'><a class=\"btn btn-lg imemo-button text-uppercase imemo-print-button\" href=\"/".substr($_SERVER["REDIRECT_URL"],1)."?".$_SERVER["QUERY_STRING"]."&printmode&printall\" role=\"button\">Весь список</a></div>";
	}

	$i=1;
	echo '<div class="row specrub-elements-list">';
	if(!empty($rows))
	{
		$rows = $ilines->appendContent($rows);
		if(empty($_REQUEST["p"]))
			$currentPage=0;
		else
			$currentPage=(int)$_REQUEST["p"]-1;
		$elementCounter = $_TPL_REPLACMENT["COUNT"]*$currentPage+1;
		foreach($rows as $k => $v)
		{
			//	print_r($v);
			$tpl = new Templater();
			if(isset($v["content"]["DATE"]))
			{
				preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
				$v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
				$v["content"]["DATE"] = date("d.m.Y г.", $v["content"]["DATE"]);
			}

			$tpl->setValues($v["content"]);
	//		$tpl->appendValues($_TPL_REPLACMENT);
			$tpl->appendValues(array("ID" => $k));
			$tpl->appendValues(array("NUMBER" => $i));
            if(isset($v['content']['NOTIFICATION_END'])) {
                $endTime = DateTime::createFromFormat("Y.m.d H:i",$v['content']['NOTIFICATION_END']);
                $now = new DateTime();
                if($endTime>$now) {
                    $tpl->appendValues(array("NEW" => 1));
                }
            }
			$tpl->appendValues(array("TITLE_NEWS" => $v["content"]["TITLE"]));
			$tpl->appendValues(array("PDF_FILE" => $v["content"]["PDF_FILE"]));
			$tpl->appendValues(array("RET" => $_REQUEST["page_id"]));
			$tpl->appendValues(array("COMMENT_COLOR" => $_TPL_REPLACMENT["COMMENT_COLOR"]));
			$tpl->appendValues(array("SPECRUB" => $_REQUEST["specrub"]));
			$tpl->appendValues(array("FULL_ID" => $_TPL_REPLACMENT["FULL_SMI_ID"]));
            $tpl->appendValues(array("ROW_COUNT" => $_TPL_REPLACMENT["ROW_COUNT"]));
			$tpl->appendValues(array("GO" => false));
			$tpl->appendValues(array('COUNTER_EL' => $elementCounter));
			if(!empty($v["content"]["FULL_TEXT"]) && $v["content"]["FULL_TEXT"]!="<p>&nbsp;</p>")
				$tpl->appendValues(array("GO" => true));

			$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.".$tplname.".html");
			$i++;
			$elementCounter++;
		}
	}

	echo '</div>';

?>
<div class="d-flex justify-content-center specrubs-loader-main">
	<div class="spinner-border specrubs-loader mt-5" role="status" style="display: none">
		<span class="sr-only">Loading...</span>
	</div>
</div>
<?php
$notificationService = new NotificationService();
$unreadNotifications = $notificationService->getUserUnreadNotifications(62);

foreach ($unreadNotifications as $notification) {
    ?>
    <script>
        var largeExpDate = new Date ();
        largeExpDate.setTime(largeExpDate.getTime() + (365 * 24 * 3600 * 1000));
        setCookie('notification-<?=$notification['id']?>-showed',"1",largeExpDate,null,null,1);
    </script>
    <?php
}

	if(!isset($_GET["printall"])):
	?>
<script>
	events_page = 2;
	lockAjax = 0;

	function scrollSpecRub(e) {
		if($('.specrub-elements-list')[0].getBoundingClientRect().bottom<1500) {
			if (lockAjax == 0) {
				lockAjax = 1;
				jQuery.ajax({
					type: 'GET',
					url: '<?=$_SESSION["lang"]?>/index.php?page_id=<?=$_REQUEST["page_id"]?>&ajax_mode=1&ajax_specrubs=' + events_page,
					success: function (data) {
						events_page += 1;
						var new_div = $(data).hide();
						new_div = new_div.filter("div");
						new_div.css("top","50px");
						$('.specrub-elements-list').append(new_div);
						new_div.fadeIn({queue: false, duration: 700});
						new_div.animate({top: 0, display: "block"},700);
						if (data == "") {
							lockAjax = 2;
						}
					},
					complete: function (data) {
						$('.specrubs-loader').hide();
						if (lockAjax == 2) {
							lockAjax = 1;
						} else {
							lockAjax = 0;
						}
					},
					beforeSend: function () {
						$('.specrubs-loader').show();
					}
				})
			}
		}
	}

	window.onresize = scrollSpecRub;
	document.addEventListener('scroll', scrollSpecRub, false);

</script>
	<?php
	endif;

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

?>
