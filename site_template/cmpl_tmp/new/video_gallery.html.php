<?
global $_CONFIG, $site_templater;

if($_GET['ajax_mode']==1) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_mode");
    exit;
}

if($_TPL_REPLACMENT["PC_HEADER"]) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.presscenter.html");
    ?>
    <section class="pt-3 pb-5 bg-color-lightergray">
    <?php
} else {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top_full.text.html");
}

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

$videoGallery = new Videogallery();
if(!empty($_TPL_REPLACMENT["PERSON"])) {
    $videoElements = $videoGallery->getVideosByPerson($_TPL_REPLACMENT["PERSON"],$photogalaryid,0,13);
} else {
    $videoElements = $videoGallery->getVideos($photogalaryid,0,13);
}


echo "<div class='container-fluid videogallery-container'><div class='row video-row'>";
$first = true;
foreach ($videoElements as $videoElement) {
    $tpl = new Templater();
    $tpl->appendValues(array("ID" => $videoElement->getId()));
    $tpl->appendValues(array("PHOTO_STOP" => $videoElement->getPhotoStop()));
    $tpl->appendValues(array("YOUTUBE_URL" => $videoElement->getYoutubeUrl()));
    $tpl->appendValues(array("DATE" => $videoElement->getDate()));
    $tpl->appendValues(array("TEMPL" => $_TPL_REPLACMENT["TEMPL"]));
    $tpl->appendValues(array("PARAMS" => $videoElement->getParams()));
    $tpl->appendValues(array("PAR" => $videoElement->getParamsActive()));
    if($_SESSION[lang]!="/en") {
        $tpl->appendValues(array("TITLE" => $videoElement->getTitle()));
    } else {
        $tpl->appendValues(array("TITLE" => $videoElement->getTitleEn()));
    }
    if ($first) {
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.video_element_first.html");
        $first = false;
        continue;
    } else {
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.video_element.html");
    }
}
echo "</div>";
?>
<div class="d-flex justify-content-center videos-loader-main">
    <div class="spinner-border videos-loader mt-5" role="status" style="display: none">
        <span class="sr-only">Loading...</span>
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
    <script>
        events_page = 13;
        lockAjax = 0;

        function scrollVideoAjax(e) {
            if($('.videogallery-container')[0].getBoundingClientRect().bottom<1500) {
                if (lockAjax == 0) {
                    lockAjax = 1;
                    jQuery.ajax({
                        type: 'GET',
                        url: '<?=$_SESSION[lang]?>/index.php?page_id=<?=$_REQUEST[page_id]?>&ajax_mode=1<?php if(!empty($_TPL_REPLACMENT["PERSON"])) echo "&videoperson=".$_TPL_REPLACMENT["PERSON"];?>&ajax_videogallery=' + events_page,
                        success: function (data) {
                            events_page += 8;
                            //$('.videos-loader-main').before(data);
                            //$('.video-row').append(data);
                            var new_div = $(data).hide();
                            new_div.css("top","50px");
                            $('.video-row').append(new_div);
                            new_div.fadeIn({queue: false, duration: 700});
                            new_div.animate({top: 0, display: "block"},700);
                            if (data == "") {
                                lockAjax = 2;
                            }
                        },
                        complete: function (data) {
                            $('.videos-loader').hide();
                            if (lockAjax == 2) {
                                lockAjax = 1;
                            } else {
                                lockAjax = 0;
                            }
                        },
                        beforeSend: function () {
                            $('.videos-loader').show();
                        }
                    })
                }
            }
        }

        window.onresize = scrollVideoAjax;
        document.addEventListener('scroll', scrollVideoAjax, false);

    </script>
<?php
if($_TPL_REPLACMENT["PC_HEADER"]) {
    ?>
    </section>
    <?php
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.presscenter.html");
} else {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom_full.text.html");
}
?>