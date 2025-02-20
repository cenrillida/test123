<?
global $_CONFIG, $page_id,$page_content;

$ilines = new Ilines();

if($_SESSION['lang']=="/en") {
    $statusField = "status_en";
} else {
    $statusField = "status";
}

$maxMobileSlider = 4;
$elementsOnPage = 5;
$staticElement = false;
$staticElementText = "";
$staticElementLink = "";

if ($_SESSION['lang'] == "/en" && $_TPL_REPLACMENT["LAST_ELEMENT_STATIC_EN"]) {
    $staticElement = true;
    $staticElementText = $_TPL_REPLACMENT["LAST_ELEMENT_STATIC_TEXT_EN"];
    $staticElementLink = $_TPL_REPLACMENT["LAST_ELEMENT_LINK_EN"];
    $maxMobileSlider = 3;
    $elementsOnPage = 4;
}
if ($_SESSION['lang'] != "/en" && $_TPL_REPLACMENT["LAST_ELEMENT_STATIC"]) {
    $staticElement = true;
    $staticElementText = $_TPL_REPLACMENT["LAST_ELEMENT_STATIC_TEXT"];
    $staticElementLink = $_TPL_REPLACMENT["LAST_ELEMENT_LINK"];
    $maxMobileSlider = 3;
    $elementsOnPage = 4;
}

$rows = $ilines->getLimitedElementsMultiSortMainNewFunc($page_content["NEWS_BLOCK_LINE"], $elementsOnPage, 1,"DATE", "DESC", $statusField);

if (!empty($rows)) {
    echo '<div class="row">';
    $countSlider = 0;
    foreach ($rows as $k => $v) {
        if ($_SESSION[lang] == "/en") {
            $v["final_text"] = $v['final_text_en'];
            $v["date_formated"] = $v['date_formated_en'];
        }

        $countSlider++;
        $pg = new Pages();

        if(!empty($v['url'])) {
            $url = $pg->getPageUrl($page_content["NEWS_BLOCK_PAGE"])."/".$v['url'];
        } else {
            $url = $pg->getPageUrl($page_content["NEWS_BLOCK_PAGE"], array("id" => $v[el_id], "p" => @$_REQUEST["p"]));
        }

        ?>
        <div class="col-12 col-md pb-3<?php if ($countSlider == $maxMobileSlider) echo ' d-none d-xl-block'; ?><?php if ($countSlider > $maxMobileSlider) echo ' d-none d-xxl-block'; ?>">
            <div class="shadow bg-white p-3 h-100 position-relative">
                <div class="row">
                    <div class="col-12 text-right">
                        <div style="color: darkgrey;"><?= $v["date_formated"] ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="news-element">
                            <?= $v["final_text"] ?>
                            <?php if (!empty($v["content"]["FULL_TEXT"]) && $v["content"]["FULL_TEXT"] != '<p>&nbsp;</p>'): ?>
                                <p>
                                    <a href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?><?= $url ?>"><?php if ($_SESSION[lang] != "/en") echo 'подробнее...'; else echo "more..."; ?></a>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if (!empty($v["content"]["FULL_TEXT"]) && $v["content"]["FULL_TEXT"] != '<p>&nbsp;</p>'): ?>
                    <a href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?><?= $url ?>"
                       class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight"
                       draggable="true"></a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    if($staticElement) {
        ?>
        <div class="col-12 col-md pb-3">
            <div class="shadow bg-white p-3 h-100 position-relative">
                <div class="row">
                    <div class="col-12 news-main-static-text">
                        <?= $staticElementText ?>
                    </div>
                </div>
                <a href="<?= $staticElementLink ?>"
                   class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight"
                   draggable="true"></a>
            </div>
        </div>
        <?php
    }
    echo '</div>';

    ?>
    <div class="row">
        <div class="col-12 text-center">
            <div class="video-text mt-5 mb-3">
                <a class="btn btn-lg imemo-button text-uppercase"
                   href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?>/index.php?page_id=498"
                   role="button"><?php if ($_SESSION[lang] != "/en") echo 'Другие новости'; else echo "All news"; ?></a>
            </div>
        </div>
    </div>
    <?
}

?>
