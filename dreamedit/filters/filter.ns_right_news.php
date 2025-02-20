<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;

$ilines = new Ilines();
$ievent = new Events();

if($_SESSION['lang']=="/en") {
    $statusField = "status_en";
} else {
    $statusField = "status";
}
$rows = $ilines->getLimitedElementsMultiSortMainNewFunc($page_content["NEWS_BLOCK_LINE"], 2, 1, "DATE", "DESC", $statusField);

if (!empty($rows)) {
    $count_slider = 0;
    foreach ($rows as $k => $v) {

        if ($_SESSION[lang] == "/en") {
            $v["final_text"] = $v['final_text_en'];
            $v["date_formated"] = $v['date_formated_en'];
        }

        $count_slider++;
        $pg = new Pages();

        ?>
        <div class="col-12 col-md-6 col-xl-12 pb-3">
            <div class="shadow border bg-white p-3 h-100 position-relative">
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
                                    <a href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?><?= $pg->getPageUrl($page_content["NEWS_BLOCK_PAGE"], array("id" => $v[el_id], "p" => @$_REQUEST["p"])) ?>"><?php if ($_SESSION[lang] != "/en") echo 'подробнее...'; else echo "more..."; ?></a>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if (!empty($v["content"]["FULL_TEXT"]) && $v["content"]["FULL_TEXT"] != '<p>&nbsp;</p>'): ?>
                    <a href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?><?= $pg->getPageUrl($page_content["NEWS_BLOCK_PAGE"], array("id" => $v[el_id], "p" => @$_REQUEST["p"])) ?>"
                       class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight"
                       draggable="true"></a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

?>
