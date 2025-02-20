<?
global $DB,$_CONFIG;
$ilines = new Ilines();

if($_SESSION[lang]!="/en")
    $sliderMain = $ilines->getLimitedElementsMultiSort(28, 6, "date","DATE", "DESC", "status");
else
    $sliderMain = $ilines->getLimitedElementsMultiSort(28, 6, "date","DATE", "DESC", "status_en");
$sliderMain = $ilines->appendContent($sliderMain);

if(!empty($sliderMain)):?>
<div id="jssor_1" style="position: relative; top: 0px; left: 0px; width: 2216px; height: 382px; overflow: hidden; visibility: hidden;">
    <!-- Loading Screen -->
    <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
        <div style="position:absolute;display:block;background:url('/newsite/img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
    </div>
    <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 2216px; height: 382px; overflow: hidden;">
        <?php $first = true; foreach ($sliderMain as $sliderElement):
            preg_match_all( '@src="([^"]+)"@' , $sliderElement["content"]['PHOTO'], $imgSrc );
            preg_match_all( '@alt="([^"]+)"@' , $sliderElement["content"]['PHOTO'], $imgAlt );
            $imgSrc = array_pop($imgSrc);
            if(empty($imgSrc))
                continue;
            $imgAlt = array_pop($imgAlt);
            ?>
            <div style="display: none;">
                <img data-u="image" src="<?=$imgSrc[0]?>" />
            </div>
        <?php endforeach;?>
        <a data-u="ad" href="http://www.jssor.com" style="display:none">jQuery Slider</a>
    </div>
    <!-- Arrow Navigator -->
    <span data-u="arrowleft" class="jssora03l" style="top:0px;left:8px;width:55px;height:55px;" data-autocenter="2"></span>
    <span data-u="arrowright" class="jssora03r" style="top:0px;right:8px;width:55px;height:55px;" data-autocenter="2"></span>
</div>
<?php endif;?>
