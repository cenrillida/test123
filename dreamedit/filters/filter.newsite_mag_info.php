<?php
    $pages = new Pages();
    $magazinePage = $pages->getContentByPageId($_TPL_REPLACMENT['MAG_ID']);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="container-fluid shadow border bg-white printables">
                <div class="row my-3">
                    <div class="col-12 py-3">
                        <h3><?php if ($_SESSION[lang] != "/en") echo $magazinePage["TITLE"]; else echo $magazinePage["TITLE_EN"]; ?></h3>
                    </div>
                    <div class="col-12 col-sm-4">
                        <?php
                        preg_match_all('@src="([^"]+)"@', $magazinePage['LOGO_MAIN'], $imgSrc);
                        preg_match_all('@alt="([^"]+)"@', $magazinePage['LOGO_MAIN'], $imgAlt);
                        $imgSrc = array_pop($imgSrc);
                        $imgAlt = array_pop($imgAlt);
                        $alt_str = "";
                        if (!empty($imgAlt))
                            $alt_str = ' alt="' . $imgAlt[0] . '"';
                        ?>
                        <?php if (!empty($imgSrc)): ?>
                            <img class="border" src="<?= $imgSrc[0] ?>" alt="<?= $alt_str ?>">
                        <?php endif; ?>
                    </div>
                    <div class="col-12 col-sm-8">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <?php if ($_SESSION[lang] != "/en") echo $magazinePage["LOGO_MAIN_INFO"]; else echo $magazinePage["LOGO_MAIN_INFO_EN"]; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>