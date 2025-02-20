<?
global $_CONFIG, $DB, $site_templater, $page_content;
//echo $_TPL_REPLACMENT["TITLE_EN"];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");
if($_GET[debug]!=1) {

    $pg = new Pages();

    //$parent_page = $pg->getParentId($_REQUEST['page_id']);
    $page = $pg->getPageById($_REQUEST['page_id']);
    $page = array_merge($page, $pg->getContentByPageId($_REQUEST['page_id']));

    if($_SESSION[lang]=="/en") {
        $page["CONTENT"] = $page["CONTENT_EN"];
    }

    $parent_page = $pg->getPageById($page['page_parent']);
    $parent_page = array_merge($parent_page, $pg->getContentByPageId($page['page_parent']));

    $menu_elements_pages = $pg->getChilds($parent_page['page_id'], 1);

    if(!empty($page["FILES_PAGE"])) {
        $files_pages = $pg->getChilds($page["FILES_PAGE"], 1);
        $files_pages = $pg->appendContent($files_pages);
    }
    if(!empty($page["DAYS_PAGE"])) {
        $days_pages = $pg->getChilds($page["DAYS_PAGE"], 1);
        $days_pages = $pg->appendContent($days_pages);
    }

    //var_dump($page,$parent_page);
    include("pm_programm_top.php");
?>

    <section class="pt-3 pb-3 bg-color-lightergray">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="row">
                        <div class="col-xl-12 col-xs-12 pt-3 pr-xl-4">
                            <div class="container-fluid left-column-container">
                                <nav>
                                    <div class="container row justify-content-center justify-content-md-start nav-menu-container">
                                        <?php foreach ($files_pages as $file):
                                            if($_SESSION[lang]!="/en") {
                                                $name_download = $file["page_name"];
                                                $url_download = $file["content"]["URL"];
                                            } else {
                                                $name_download = $file["page_name_en"];
                                                $url_download = $file["content"]["URL_EN"];
                                            }
                                            if(!empty($url_download)):
                                            ?>
                                            <div class="py-3 px-2 mx-3 col-auto text-uppercase programm-download-element position-relative">
                                                <span class="d-table-cell align-middle"><i class="fas fa-2x fa-file-download text-color-imemo"></i></span>
                                                <span class="d-table-cell align-middle pl-2"><a target="_blank" href="<?=$url_download?>"><b><?=$name_download?></b></a></span>
                                            </div>
                                        <?php endif; endforeach; ?>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-xs-12 pb-3 pr-xl-4">
                            <div class="container-fluid left-column-container">
                                <nav>
                                    <div class="container row justify-content-center justify-content-md-start nav-menu-container">
                                        <div class="py-3 px-2 mx-2 col-auto text-uppercase position-relative">
                                            <a class="btn btn-lg imemo-button text-uppercase programm-day-button programm-day-choose-button-current" data-element-id="all" href="#" role="button"><?php if($_SESSION[lang]!="/en") echo "Все дни"; else echo "All days";?></a>
                                        </div>
                                        <?php foreach ($days_pages as $day):

                                            if($_SESSION[lang]=="/en") {
                                                $day["page_name"] = $day["page_name_en"];
                                            }

                                            ?>
                                            <div class="py-3 px-2 mx-2 col-auto text-uppercase position-relative">
                                                <a class="btn btn-lg imemo-button text-uppercase programm-day-button" data-element-id="<?=$day["page_id"]?>" href="#" role="button"><?=$day["page_name"]?></a>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($page["CONTENT"])):?>
                        <div class="container row">
                            <div class="col-xl-12 col-xs-12 pb-3 pr-xl-4">
                                <div class="container-fluid left-column-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <?=$page["CONTENT"]?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
                <div class="col-12 col-lg-4 my-lg-auto">
                    <p class="text-center text-lg-right"><strong><em><i class="fas fa-envelope"></i> </em><a href="mailto:forum@primakovreadings.com">forum@primakovreadings.com</a></strong></p>
                    <p class="text-center text-lg-right"><strong><em><i class="fas fa-phone"></i> </em>+7 (916) 083-4851</strong></p>
                </div>
                <?php if(false):?>
                <div class="col-12 col-lg-5">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <?php
                            if(!empty($page["COUNTDOWN_DATE"])):
                                if($_SESSION[lang]!="/en") {
                                    $countdown_title = $page["COUNTDOWN_TITLE"];
                                } else {
                                    $countdown_title = $page["COUNTDOWN_TITLE_EN"];
                                }
                                ?>


                            <h2 class="text-center"><?=$countdown_title?></h2>
                            <?php
                            include ("countdown.php");
                            ?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </section>
    <section class="pt-3 pb-3 bg-white">
        <?php foreach ($days_pages as $day):

            if($_SESSION[lang]=="/en") {
                $day["page_name"] = $day["page_name_en"];
            }

            $day_name = explode(" ", $day["page_name"]);
            ?>
        <div class="container-fluid mb-5 programm-day-element" data-element-id="<?=$day["page_id"]?>">
            <div class="row">
                <div class="d-none d-lg-block col-lg-2">

                </div>
                <div class="col-12 col-lg-2">
                    <h2><b><?=$day_name[0]?></b> <?=$day_name[1]?></h2>
                </div>
                <div class="d-none d-lg-block col-lg-8">

                </div>
            </div>
            <?php

                $day_elements = $pg->getChilds($day["page_id"],1);
                $day_elements = $pg->appendContent($day_elements);
                foreach ($day_elements as $day_element):

                    if($_SESSION[lang]=="/en") {
                        $day_element['page_name'] = $day_element['page_name_en'];
                        $day_element['content']["PLACE"] = $day_element['content']["PLACE_EN"];
                        $day_element['content']["TEXT_PREVIEW"] = $day_element['content']["TEXT_PREVIEW_EN"];
                        $day_element['content']["FULL_TEXT"] = $day_element['content']["FULL_TEXT_EN"];
                    }
            ?>
            <div class="row">
                <div class="d-none d-lg-flex align-items-lg-start col-lg-2">
                    <div class="w-100 text-right">
                        <div class="programm-time">
                            <h4><b><?=$day_element["content"]["TIME"]?></b></h4>
                        </div>
                        <div class="programm-place text-uppercase">
                            <?=$day_element["content"]["PLACE"]?>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="programm-vertical-line"><div class="programm-line-circle"></div></div>
                </div>
                <div class="col col-lg-9">
                    <div class="d-lg-none mb-2">
                        <div class="programm-time">
                            <h4><b><?=$day_element["content"]["TIME"]?></b></h4>
                        </div>
                        <div class="programm-place text-uppercase">
                            <?=$day_element["content"]["PLACE"]?>
                        </div>
                    </div>
                    <div class="programm-name">
                        <?php

                        $speakers = $pg->getChilds($day_element['page_id'], 1);
                        if(!empty($day_element["content"]["FULL_TEXT"]) || !empty($speakers)): ?>
                        <a href="#" onclick="return false;" class="programm-name-link">
                            <?php endif;?>
                            <h5 class="text-uppercase font-weight-bold speaker-text-color"><?=$day_element["page_name"]?></h5>
                            <?php if(!empty($day_element["content"]["FULL_TEXT"]) || !empty($speakers)): ?>
                        </a>
                    <?php endif;?>
                    </div>
                    <div class="programm-text">
                        <?=$day_element["content"]["TEXT_PREVIEW"]?>
                    </div>
                    <div class="programm-text-full">
                        <div>
                            <?=$day_element["content"]["FULL_TEXT"]?>
                        </div>
                        <?php
                        foreach ($speakers as $speaker):
                            if($_SESSION[lang]=="/en") {
                                $speaker['page_name'] = $speaker['page_name_en'];
                            }
                        ?>
                        <?php if($speaker['notop'] != 1): ?>
                        <div class="container-fluid mb-3">
                            <div class="row">
                                <div class="col-12 text-lg-left text-center">
                                    <b><?=$speaker['page_name']?></b>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php
                        $speaker_elements = $pg->getChilds($speaker['page_id'],1);
                        $speaker_elements = $pg->appendContent($speaker_elements);
                        foreach ($speaker_elements as $speaker_element):

                            if($_SESSION[lang]=="/en") {
                                $speaker_element['page_name'] = $speaker_element['page_name_en'];
                                $speaker_element['content']['INFO'] = $speaker_element['content']['INFO_EN'];
                            }

                            preg_match_all('@src="([^"]+)"@', $speaker_element['content']["PHOTO"], $imgSrc);
                            preg_match_all('@alt="([^"]+)"@', $parent_page['content']["PHOTO"], $imgAlt);

                            $imgSrc = array_pop($imgSrc);
                            $imgAlt = array_pop($imgAlt);
                        ?>
                        <div class="container-fluid mb-3">
                            <div class="row text-lg-left text-center">
                                <div class="col-12 col-lg-auto my-lg-auto">
                                    <img class="programm-speaker-img" src="<?=$imgSrc[0]?>" alt="<?=$imgAlt[0]?>">
                                </div>
                                <?php if(!empty($speaker_element['content']['INFO'])): ?>
                                <div class="col-12 col-lg-auto my-lg-auto">
                                    <b><?=$speaker_element['page_name']?></b>
                                </div>
                                <div class="col-12 col-lg my-lg-auto p-no-margin">
                                    <?=$speaker_element['content']['INFO']?>
                                </div>
                                <?php else:?>
                                    <div class="col-12 col-lg my-lg-auto">
                                        <b><?=$speaker_element['page_name']?></b>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php endforeach;
                        endforeach;?>
                        <div class="row justify-content-center">
                            <div class="py-3 px-2 mx-3 col-auto text-uppercase programm-download-element position-relative">
                                <span class="d-table-cell align-middle"><i class="fas fa-2x fa-chevron-circle-up text-color-imemo"></i></span>
                                <span class="d-table-cell align-middle pl-2"><a href="#" class="programm-text-full-close-button"><b><?php if($_SESSION[lang]!="/en") echo "Свернуть"; else echo "Close";?></b></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="d-none d-lg-block col-lg-2">
                </div>
                <div class="col-1">
                    <div class="programm-vertical-line py-4"></div>
                </div>
                <div class="col-11 col-lg-9">

                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach;?>
    </section>

    <?php
}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.html");
?>

