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

$limit = "";
if(!empty($_TPL_REPLACMENT['NUMBER_VIDEOS'])) {
    $limit = " LIMIT ".(int)$_TPL_REPLACMENT['NUMBER_VIDEOS'];
}

$videos = $DB->select("SELECT * FROM youtube_videos".$limit);


if(!empty($videos)) {
    ?>

    <div class="col-12">
        <div class="shadow border bg-white p-3 h-100">
            <div class="row">
                <div class="col-12">

                    <div id="carouselSlider2" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $first = true;
                            foreach ($videos as $video):
                                $params="?rel=0&autoplay=1";
                                $par="1";
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
                                                         src="<?=$video['thumbnail']?>?auto=yes&bg=666&fg=444&text=Third slide">
                                                    <div class="video-iframe-button-div">
                                                        <a href="javascript:doPopup('//www.youtube.com/embed/<?=$video['url']?>?rel=0&autoplay=1', <?=$par?>)" class="btn btn-secondary video-iframe-button-presscenter"><i class="fas fa-video"></i> Смотреть</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="pr-photo-text"></div>
                                            <div class="col-12 my-auto text-center">
                                                <a target="_blank" class=""
                                                   href="https://www.youtube.com/watch?v=<?=$video['url']?>">
                                                    <h5 class="font-weight-bold"><?=$video['title']?></h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if(count($videos)>1):?>
                        <a class="carousel-control-prev" href="#carouselSlider2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselSlider2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        <?php endif;?>
                    </div>
<!--                    <div class="red-pl">Фоторепортаж</div>-->
                </div>
            </div>
        </div>
    </div>

    <?php
}



?>