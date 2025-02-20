<?
global $_CONFIG, $DB, $site_templater, $page_content;
//echo $_TPL_REPLACMENT["TITLE_EN"];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");
if($_GET[debug]!=1) {

    $pg = new Pages();

//$parent_page = $pg->getParentId($_REQUEST['page_id']);
    $page = $pg->getPageById($_REQUEST['page_id']);
    $page = array_merge($page, $pg->getContentByPageId($_REQUEST['page_id']));

    if ($_SESSION[lang] == "/en") {
        $page["CONTENT"] = $page["CONTENT_EN"];
    }

    $parent_page = $pg->getPageById($page['page_parent']);
    $parent_page = array_merge($parent_page, $pg->getContentByPageId($page['page_parent']));

    $menu_elements_pages = $pg->getChilds($parent_page['page_id'], 1);

    $ilines = new Ilines();

    if($_SESSION[lang]!="/en")
        $sliders = $ilines->getLimitedElementsMultiSort(32, 999, "sort","SORT", "ASC", "status");
    else
        $sliders = $ilines->getLimitedElementsMultiSort(32, 999, "sort","SORT", "ASC", "status_en");
    $sliders = $ilines->appendContent($sliders);


    ?>
    <section class="pt-3 pb-3 bg-white">
        <div class="container mb-5" style="max-width: 1400px">
            <div class="row">
                <?php foreach ($sliders as $slider):

                    $type_id = $DB->select("SELECT itype_id FROM adm_ilines_type WHERE itype_name=?",$slider['content']['SLIDER']);

                    if(count($type_id)>0):
                    if($_SESSION[lang]!="/en")
                        $sliderMain = $ilines->getLimitedElementsMultiSort($type_id[0]['itype_id'], 6, "date","DATE", "DESC", "status");
                    else
                        $sliderMain = $ilines->getLimitedElementsMultiSort($type_id[0]['itype_id'], 6, "date","DATE", "DESC", "status_en");
                    $sliderMain = $ilines->appendContent($sliderMain);
                    ?>
                <div class="col-12 col-md-6 mt-0 px-md-5">
                    <div class="text-uppercase mt-5 mb-3" style="border-bottom: 1px solid #3d77bc">
                        <!--<a href="<?php if($_SESSION[lang]!="/en") echo $slider['content']['URL']; else echo $slider['content']['URL_EN'];?>" class="sliders-title-button position-relative d-inline-block m-0 py-2 px-3"><?php if($_SESSION[lang]!="/en") echo $slider['content']['TITLE']; else echo $slider['content']['TITLE_EN'];?></a>-->
                    </div>
                    <div>
                        <?php
                        if (!empty($sliderMain)):?>
                            <div id="carouselSlider<?=$slider['el_id']?>" class="carousel slide" data-ride="carousel" data-interval="false">
                                <div class="carousel-inner">
                                    <?php $first = true;
                                    foreach ($sliderMain as $sliderElement):
                                        preg_match_all('@src="([^"]+)"@', $sliderElement["content"]['PHOTO'], $imgSrc);
                                        preg_match_all('@alt="([^"]+)"@', $sliderElement["content"]['PHOTO'], $imgAlt);
                                        $imgSrc = array_pop($imgSrc);
                                        if (empty($imgSrc))
                                            continue;
                                        $imgAlt = array_pop($imgAlt);
                                        ?>
                                        <div class="carousel-item<?php if ($first) {
                                            echo " active";
                                            $first = false;
                                        } ?>">
                                            <div>
                                                <img class="d-block w-100 position-absolute overlay-bottom-null"
                                                     src="<?= $imgSrc[0] ?>?auto=no&bg=666&fg=444&text=Third slide"<?php if (!empty($imgAlt)) echo ' alt="' . $imgAlt[0] . '"'; ?>>
                                                <img class="d-block w-100"
                                                     src="<?= $imgSrc[0] ?>?auto=no&bg=666&fg=444&text=Third slide"<?php if (!empty($imgAlt)) echo ' alt="' . $imgAlt[0] . '"'; ?>>
                                                <div class="position-absolute img-ton img-ton-lighter">
                                                    <a href="<?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["URL"]; else echo $sliderElement['content']["URL_EN"] ?>"
                                                       class="w-100 h-100 position-absolute"></a>
                                                </div>
                                            </div>
                                            <div class="carousel-caption sliders-carousel-caption">
                                                <a class="text-white"
                                                   href="<?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["URL"]; else echo $sliderElement['content']["URL_EN"] ?>">
                                                    <h5 class="font-weight-bold"><?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["TITLE"]; else echo $sliderElement['content']["TITLE_EN"] ?></h5>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if(count($sliderMain)>1): ?>
                                <a class="carousel-control-prev" href="#carouselSlider<?=$slider['el_id']?>" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselSlider<?=$slider['el_id']?>" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                                <?php endif; ?>
                            </div>
                        <?php endif;

                        ?>
                    </div>
                </div>
                <?php
                    endif;
                    endforeach;?>
            </div>
        </div>
    </section>

    <?php
}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.html");
?>

