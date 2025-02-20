<?php

global $_CONFIG, $DB, $site_templater;
//
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

if(!empty($_REQUEST['article_id'])) {

    $article = new Article();

    $articleEl = $article->getPageById((int)$_REQUEST['article_id'],1);


    if(!empty($articleEl) && $articleEl['journal_new']==$_TPL_REPLACMENT["MAIN_JOUR_ID"]) {
        switch ($articleEl['page_template']) {
//            case 'jarticle':
//                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."mag_article.html");
//                break;
//            case 'jnumber':
//                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."mag_number.html");
//                break;
//            case 'jrubric':
//                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."mag_rubric.html");
//                break;
            default:
                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
        }
    } else {
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        echo "<p>—траница не найдена</p>";

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }


} else {

    if ($_TPL_REPLACMENT['NO_PREFIX'] == 1) {
        if ($_SESSION[lang] == '/en') {
            $suff = '_en';
            $txt = "No. ";
        } else {
            $suff = '';
            $txt = "є ";
        }
    } else {
        if ($_SESSION[lang] == '/en') {
            $suff = '_en';
            $txt = "";
        } else {
            $suff = '';
            $txt = "";
        }
    }

    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.html");

    ?>

    <section class="pt-3 pb-5 bg-color-lightergray">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-xs-12 pt-3 pb-3 pr-xl-4">
                    <div class="container-fluid left-column-container">
                        <?php if(!$_TPL_REPLACMENT['LEFT_COLLUMN_CUSTOM']):?>
                        <div class="row shadow border bg-white printables mb-5">
                            <div class="col-12 pt-3 pb-3">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 py-3">
                                            <h3><?php if ($_SESSION[lang] != "/en") echo $_TPL_REPLACMENT["TITLE"]; else echo $_TPL_REPLACMENT["TITLE_EN"]; ?></h3>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <?php
                                            preg_match_all('@src="([^"]+)"@', $_TPL_REPLACMENT['LOGO_MAIN'], $imgSrc);
                                            preg_match_all('@alt="([^"]+)"@', $_TPL_REPLACMENT['LOGO_MAIN'], $imgAlt);
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
                                                        <?php if ($_SESSION[lang] != "/en") echo $_TPL_REPLACMENT["LOGO_MAIN_INFO"]; else echo $_TPL_REPLACMENT["LOGO_MAIN_INFO_EN"]; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row shadow border bg-white printables">
                            <div class="col-12 pt-5 pb-3">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php

                                            if (!empty($last_number)) {
                                                if (!empty($last_number[0][page_name_en]))
                                                    $page_name_number_en = $last_number[0][page_name_en];
                                                else {
                                                    $page_name_number_en = str_replace("≈жегодник", "Yearbook", $last_number[0][page_name]);
                                                }
                                                if ($_SESSION[jour_url] != 'god_planety' && $_SESSION[jour_url] != 'Russia-n-World' && $_SESSION[jour_url] != 'SIPRI') {
                                                    $vol_pos = strripos($last_number[0][page_name], "т.");
                                                    if ($vol_pos === false) {
                                                        if ($_SESSION[lang] != '/en') {
                                                            if ($_SESSION[jour_url] != "WER")
                                                                echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                                                                    "<a href=/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                                                                    "“екущий номер Ц " . $txt . $last_number[0][page_name] . ", " . $last_number[0][year] . "</a>";
                                                            else
                                                                echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                                                                    "<a href=/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                                                                    "“екущий номер Ц " . $last_number[0][page_name] . "</a>";
                                                        } else
                                                            echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                                                                "<a href=/en/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                                                                "Current Issue Ц " . $last_number[0][year] . ", " . $txt . $page_name_number_en . "</a>";
                                                    } else {
                                                        $volume = substr($last_number[0][page_name], $vol_pos);
                                                        if ($_SESSION[lang] == '/en')
                                                            $volume = str_replace("т.", "vol.", $volume);
                                                        $number = spliti(",", $last_number[0][page_name]);
                                                        if ($_SESSION[lang] != '/en')
                                                            echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                                                                "<a href=/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                                                                "“екущий номер Ц " . $volume . ", " . $txt . $number[0] . ", " . $last_number[0][year] . "</a>";
                                                        else
                                                            echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                                                                "<a href=/en/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                                                                "Current Issue Ц " . $last_number[0][year] . ", " . $volume . ", " . $txt . $number[0] . "</a>";
                                                    }
                                                } else {
                                                    if ($_SESSION[lang] != '/en') {
                                                        if ($_SESSION[jour_url] == 'god_planety')
                                                            echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                                                                "<a href=/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                                                                "“екущий выпуск Ц " . $txt . $last_number[0][page_name] . ", " . $last_number[0][year] . "</a>";
                                                        else
                                                            echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                                                                "<a href=/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                                                                "“екущий выпуск Ц " . $txt . $last_number[0][page_name] . "</a>";
                                                    } else {
                                                        if ($_SESSION[jour_url] == 'god_planety')
                                                            echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                                                                "<a href=/en/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                                                                "Current Issue Ц " . $last_number[0][year] . ", Yearbook</a>";
                                                        else
                                                            echo "<img src=/files/Image/info.png />&nbsp;&nbsp;" .
                                                                "<a href=/en/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $last_number[0][page_summary] . "&jid=" . $last_number[0][page_id] . ">" .
                                                                "Current Issue Ц " . $last_number[0][page_name_en] . "</a>";
                                                    }
                                                }
                                                echo "<br />";
                                            }

                                            if ($_SESSION[lang] == '/en') {
                                                echo $_TPL_REPLACMENT["MAIN_CONTENT_EN"];
                                            } else {
                                                echo $_TPL_REPLACMENT["MAIN_CONTENT"];
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php else:?>
                            <?php include_once("block_presscenter_left.php");?>
                        <?php endif;?>
                    </div>
                </div>
                <div class="col-xl-4 col-xs-12 d-xl-block pt-3 pb-3 px-xl-0 right-column">
                    <div class="pr-3">
                        <div class="container-fluid">
                            <?php include_once("block_mag_right.php"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php


    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.html");
}