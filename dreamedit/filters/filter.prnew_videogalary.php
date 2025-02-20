<script language="javascript">
    function doPopup(popupPath, par) {
        var percent = encodeURIComponent('%');
        if(par)
            popupPath += '&height=100' + percent + '&width=100' + percent;
        pWnd=window.open(popupPath,'name',
            'width=560,height=315,scrollbars=NO,left=350,top=100');
    }
</script>
<?php
global $DB, $_CONFIG;


//echo '<div><img alt="" src="/files/Image/DCC-20_05.jpg" height="264" width="396">
//&nbsp;&nbsp;<img alt="" src="/files/Image/DCC-20_10.jpg" height="264" width="176"></div>';

//SELECT * FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=9

$ilines = new Ilines();

if($_SESSION[lang]!="/en")
    $sliderMain = $ilines->getLimitedElementsMultiSort(10, 6, "date","DATE", "DESC", "status");
else
    $sliderMain = $ilines->getLimitedElementsMultiSort(10, 6, "date","DATE", "DESC", "status_en");
$sliderMain = $ilines->appendContent($sliderMain);


if(!empty($sliderMain)) {
    ?>

    <div class="col-12">
        <div class="shadow border bg-white p-3 h-100">
            <div class="row">
                <div class="col-12">

                    <div id="carouselSlider2" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $first = true;
                            foreach ($sliderMain as $sliderElement):
                                $params="?rel=0&autoplay=1";
                                if(!empty($sliderElement["content"]['TIME_SECONDS'])) $params .= "&start=".$sliderElement["content"]['TIME_SECONDS'] . "&t=" . $sliderElement["content"]['TIME_SECONDS'];
                                $par="1";
                                if($sliderElement["content"]['PARAMS'])
                                {
                                    $params="";
                                    $par="0";
                                }
                                ?>
                                <div class="carousel-item<?php if ($first) {
                                    echo " active";
                                    $first = false;
                                } ?>">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-12 my-auto">
                                                <div class="position-relative">
                                                    <img class="d-block w-100"
                                                         src="<?= $sliderElement["content"]['PHOTO_STOP'] ?>?auto=yes&bg=666&fg=444&text=Third slide"<?php if (!empty($imgAlt)) echo ' alt="' . $imgAlt[0] . '"'; ?>>
                                                    <div class="video-iframe-button-div">
                                                        <a href="javascript:doPopup('//<?=$sliderElement["content"]['YOUTUBE_URL'].$params?>', <?=$par?>)" class="btn btn-secondary video-iframe-button-presscenter"><i class="fas fa-video"></i> ��������</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="pr-photo-text"></div>
                                            <div class="col-12 my-auto text-center">
                                                <?php if(!empty($sliderElement['content']["URL"])): ?>
                                                <a target="_blank" class=""
                                                   href="<?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["URL"]; else echo $sliderElement['content']["URL_EN"] ?>">
                                                    <h5 class="font-weight-bold"><?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["TITLE"]; else echo $sliderElement['content']["TITLE_EN"] ?></h5>
                                                </a>
                                                <?php else: ?>
                                                    <h5 class="font-weight-bold"><?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["TITLE"]; else echo $sliderElement['content']["TITLE_EN"] ?></h5>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselSlider2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselSlider2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

<!--                    <div class="red-pl">������������</div>-->
                </div>
            </div>
        </div>
    </div>

    <?php
}



?>