<?
global $_CONFIG, $site_templater;
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top_full.text.html");

?>
    <script language="javascript">
        function doPopup(popupPath, par) {
            var percent = encodeURIComponent('%');
            if(par)
                popupPath += '&height=100' + percent + '&width=100' + percent;
            pWnd=window.open(popupPath,'name',
                'width=560,height=315,scrollbars=NO,left=350,top=100');
        }

        $(document).ready(function() {
            $(".box").hover(
                function() {
                    $( this ).find(".text-video-animated").slideDown(150);
                }, function() {
                    $( this ).find(".text-video-animated").slideUp(150);
                }
            );
        });
    </script>

<?
global $DB;
$photogalaryid=10;

$videoId = (int)$_GET[id];

if(empty($videoId)) {
    exit;
}

$videoGallery = new Videogallery();
$videoElements = $videoGallery->getVideoById($videoId,$photogalaryid);

echo "<div class='container-fluid videogallery-container'><div class='row video-row'>";

foreach ($videoElements as $videoElement) {
    $tpl = new Templater();
    $tpl->appendValues(array("ID" => $videoElement->getId()));
    $tpl->appendValues(array("PHOTO_STOP" => $videoElement->getPhotoStop()));
    $tpl->appendValues(array("YOUTUBE_URL" => $videoElement->getYoutubeUrl()));
    $tpl->appendValues(array("DATE" => $videoElement->getDate()));
    $tpl->appendValues(array("PARAMS" => $videoElement->getParams()));
    $tpl->appendValues(array("TEMPL" => $_TPL_REPLACMENT["TEMPL"]));
    $tpl->appendValues(array("PAR" => $videoElement->getParamsActive()));
    if($_SESSION[lang]!="/en") {
        $tpl->appendValues(array("TITLE" => $videoElement->getTitle()));
    } else {
        $tpl->appendValues(array("TITLE" => $videoElement->getTitleEn()));
    }
    $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.video_element_first.html");
}
echo "</div>";
echo "</div>";

$videoElements = $videoGallery->getVideosExclude($videoId,$photogalaryid,0,4);

echo "<div class='container-fluid'>";
?>
    <div class="row mb-3 mt-3">
        <div class="col-12">
            <h2 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?php if ($_SESSION[lang] != "/en") echo "Другие видео"; else echo "Other videos"; ?></h2>
        </div>
    </div>
<?php
echo "<div class='row'>";
foreach ($videoElements as $videoElement) {
    $tpl = new Templater();
    $tpl->appendValues(array("ID" => $videoElement->getId()));
    $tpl->appendValues(array("PHOTO_STOP" => $videoElement->getPhotoStop()));
    $tpl->appendValues(array("YOUTUBE_URL" => $videoElement->getYoutubeUrl()));
    $tpl->appendValues(array("DATE" => $videoElement->getDate()));
    $tpl->appendValues(array("PARAMS" => $videoElement->getParams()));
    $tpl->appendValues(array("TEMPL" => $_TPL_REPLACMENT["TEMPL"]));
    $tpl->appendValues(array("PAR" => $videoElement->getParamsActive()));
    if($_SESSION[lang]!="/en") {
        $tpl->appendValues(array("TITLE" => $videoElement->getTitle()));
    } else {
        $tpl->appendValues(array("TITLE" => $videoElement->getTitleEn()));
    }
    $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.video_element.html");
}
echo "</div>";
?>
    <div class="row">
        <div class="col-12 text-center">
            <div class="video-text mt-5 mb-3">
                <a class="btn btn-lg imemo-button text-uppercase" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1102" role="button"><?php if ($_SESSION[lang]!="/en") echo 'Перейти в видеогалерею'; else echo "To videogallery";?></a>
            </div>
        </div>
    </div>
<?php
echo "</div>";


?>
<?php if(!empty($_GET['scrollto'])):?>
    <script>
        $(document).ready(function() {
            $('html, body').animate({
                scrollTop: $('#<?=$_GET['scrollto']?>').offset().top-$('.site-header:eq(0)').height()-$('.site-header:eq(1)').height()
            }, 1);
        });
    </script>
<?php endif;?>
<?php
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom_full.text.html");
?>