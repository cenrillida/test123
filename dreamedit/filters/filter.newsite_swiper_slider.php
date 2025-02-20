<?php

$photogalaryid=$_TPL_REPLACMENT['ILINE_ID'];

$ilines = new Ilines();

if($_SESSION[lang]!="/en")
    $sliderMain = $ilines->getLimitedElementsMultiSort($photogalaryid, 9999, "date","DATE", "DESC", "status");
else
    $sliderMain = $ilines->getLimitedElementsMultiSort($photogalaryid, 9999, "date","DATE", "DESC", "status_en");
$sliderMain = $ilines->appendContent($sliderMain);
if(!empty($sliderMain)) {
    $imgStyle = "";
    if(!empty($_TPL_REPLACMENT['SLIDER_BORDER_SIZE'])) {
        $imgBorderColor = "#ffffff";
        if(!empty($_TPL_REPLACMENT['SLIDER_BORDER_COLOR'])) {
            $imgBorderColor = $_TPL_REPLACMENT['SLIDER_BORDER_COLOR'];
        }
        $imgStyle = "border: {$_TPL_REPLACMENT['SLIDER_BORDER_SIZE']}px solid {$imgBorderColor}; background-color: {$imgBorderColor};";
    }
?>
<!-- Slider main container -->
<div class="swiper-container swiper-container<?=$_TPL_REPLACMENT["SORT"]?> py-3">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <?php $first = true;
        foreach ($sliderMain as $sliderElement):
            preg_match_all( '@src="([^"]+)"@' , $sliderElement['content']['PHOTO'], $imgSrc );
            preg_match_all( '@alt="([^"]+)"@' , $sliderElement['content']['PHOTO'], $imgAlt );
            $imgSrc = array_pop($imgSrc);
            $imgAlt = array_pop($imgAlt);
            preg_match_all( '@src="([^"]+)"@' , $sliderElement['content']['PHOTO_THUMB'], $imgSrcThumb );
            $imgSrcThumb = array_pop($imgSrcThumb);
            $imgBlockHeight = "80%";
            if(!empty($sliderElement['content']['HEIGHT_PHOTO_SECTION']))
                $imgBlockHeight = $sliderElement['content']['HEIGHT_PHOTO_SECTION'];
            ?>
                <!-- Slides -->
                <div class="swiper-slide">
                    <div class="d-flex w-100 h-100 flex-column">
                        <div class="d-flex m-auto w-100" style="height: <?=$imgBlockHeight?>">
                            <img <?php if(!empty($imgSrcThumb[0])) echo "src=\"{$imgSrcThumb[0]}\"";?> alt="<?=$imgAlt[0]?>" data-src="<?=$imgSrc[0]?>" class="swiper-lazy mx-auto" style="height: 100%; object-fit: contain;<?=$imgStyle?>"/>
                        </div>
                        <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                        <div class="p-3 text-white text-center">
                            <?php if($_SESSION[lang]!="/en"):?>
                                <?=$sliderElement['content']['TITLE']?>
                            <?php else:?>
                                <?=$sliderElement['content']['TITLE_EN']?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
    <?php if($_TPL_REPLACMENT['SLIDER_PAGINATION']): ?>
    <!-- If we need pagination -->
    <div class="swiper-pagination swiper-pagination<?=$_TPL_REPLACMENT["SORT"]?>"></div>
    <?php endif;?>

    <?php if($_TPL_REPLACMENT['SLIDER_BUTTONS']): ?>
    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev swiper-button-prev<?=$_TPL_REPLACMENT["SORT"]?>"></div>
    <div class="swiper-button-next swiper-button-next<?=$_TPL_REPLACMENT["SORT"]?>"></div>
    <?php endif;?>

    <?php if($_TPL_REPLACMENT['SLIDER_SCROLLBAR']): ?>
    <!-- If we need scrollbar -->
    <div class="swiper-scrollbar swiper-scrollbar<?=$_TPL_REPLACMENT["SORT"]?>"></div>
    <?php endif;?>
<!---->
<!--    <div class="w-100 h-100 position-absolute img-ton img-ton-lighter">-->
<!---->
<!--    </div>-->
</div>
<style>
    .swiper-container<?=$_TPL_REPLACMENT["SORT"]?> {
        height: <?=$_TPL_REPLACMENT['SLIDER_HEIGHT']?>;
        width: <?=$_TPL_REPLACMENT['SLIDER_WIDTH']?>;
    }
    .swiper-button-prev,.swiper-button-next {
        color: white;
    }
</style>
<script>
    $( document ).ready(function() {
        const swiper = new Swiper('.swiper-container<?=$_TPL_REPLACMENT["SORT"]?>', {
            // Optional parameters
            direction: '<?php if($_TPL_REPLACMENT['SLIDER_DIRECTION']=="Вертикальное") echo "vertical"; else echo 'horizontal';?>',
            loop: true,
            lazy: true,

            <?php if($_TPL_REPLACMENT['SLIDER_PAGINATION']): ?>
            // If we need pagination
            pagination: {
                el: '.swiper-pagination<?=$_TPL_REPLACMENT["SORT"]?>',
            },
            <?php endif;?>

            <?php if($_TPL_REPLACMENT['SLIDER_BUTTONS']): ?>
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next<?=$_TPL_REPLACMENT["SORT"]?>',
                prevEl: '.swiper-button-prev<?=$_TPL_REPLACMENT["SORT"]?>',
            },
            <?php endif;?>

            <?php if($_TPL_REPLACMENT['SLIDER_SCROLLBAR']): ?>
            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar<?=$_TPL_REPLACMENT["SORT"]?>',
            },
            <?php endif;?>


        });
    });
</script>
<?php }