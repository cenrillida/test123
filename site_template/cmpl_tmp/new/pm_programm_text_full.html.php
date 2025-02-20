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

    if(!empty($page["MENU_PAGE_ID"])) {
        $menu_elements_pages = $pg->getChilds($page["MENU_PAGE_ID"], 1);
    } else {
        $menu_elements_pages = $pg->getChilds($parent_page['page_id'], 1);
    }
//var_dump($page,$parent_page);
    include("pm_programm_top.php");

    ?>
    <section class="pt-3 pb-5 bg-color-lightergray">
    <div class="container-fluid">
    <div class="row">
    <!-- left column -->
<div class="<?php if ($pname[0]['noright'] == '1') echo 'col-xl-12'; else echo 'col-xl-9'; ?> col-xs-12 pt-3 pb-3 pr-xl-4">
    <div class="container-fluid left-column-container">
    <div class="row shadow border bg-white printables">
    <?php if ($pname[0]['nobreadcrumbs'] == 0): ?>
        <div class="col-12 pt-3 printable-none">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php
                    if($_GET[debug]==2) {
                        echo $_TPL_REPLACMENT[BREADCRUMBS];
                    } else {
                        include($_TPL_REPLACMENT[BREADCRUMBS]);
                    }?>
                </ol>
            </nav>
        </div>
    <?php endif; ?>
    <?php if ($pname[0]['notop'] == 0): ?>
        <div class="col-12 pt-3 pb-3">
            <div class="container-fluid">
                <div class="row mb-3 align-items-center">
                    <div class="col-lg-9 col-xs-12 printable-center">
                        <div class="author-img-section d-none">
                            <div class="author-img mr-2 d-inline-block align-middle"
                                 style="background-image: url('/newsite/img/18309_3.png')"></div>
                            <div class="d-inline-block align-middle"><a href=""><b class="font-italic">c.н.с. Олег
                                        Давыдов</b></a></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-12 mt-3 mt-lg-0 printable-none">
                        <div class="text-lg-right text-center">
                            <?php if ($_SESSION[lang] != "/en"): ?>
                                <?php if ($pname[0][page_template] != 'experts'): ?>
                                    <a class="btn btn-lg imemo-button text-uppercase imemo-print-button" href="#"
                                       onclick='event.preventDefault(); window.print();' role="button">Распечатать</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a class="btn btn-lg imemo-button text-uppercase imemo-print-button" href="#"
                                   onclick='event.preventDefault(); window.print();' role="button">Print</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 small">
                        <?php
                        if ($pname[0]['notop'] == 0) {
                            if ($_SESSION[lang] != "/en") {
                                echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\">" . $_TPL_REPLACMENT["TITLE"] . "</h3>";

                            } else {
                                if ($_TPL_REPLACMENT["TITLE_EN"] != '') {
                                    if ($_TPL_REPLACMENT["TITLE_EN"] == "News in detail") {
                                        if ($_TPL_REPLACMENT["TITLE"] != '')
                                            echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\">" . $_TPL_REPLACMENT["TITLE"] . "</h3>";
                                        else
                                            echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\">" . $_TPL_REPLACMENT["TITLE_EN"] . "</h3>";
                                    } else {
                                        echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\"'>" . $_TPL_REPLACMENT["TITLE_EN"] . "</h3>";
                                    }
                                } else
                                    echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\"'>" . $_TPL_REPLACMENT["TITLE"] . "</h3>";


                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-12 pl-lg-5 pr-lg-5 pl-md-3 pr-md-3 pl-xs-2 pr-xs-2 pb-5 border-bottom text-content">


    <?php


    if ($_SESSION[lang] != '/en') {
        if (!empty($_TPL_REPLACMENT["CONTENT"]) && $_TPL_REPLACMENT["CONTENT"] != '<p>&nbsp;</p>') {
            echo @$_TPL_REPLACMENT["CONTENT"];
        }
    } else {
        if (!empty($_TPL_REPLACMENT["CONTENT_EN"]) && $_TPL_REPLACMENT["CONTENT_EN"] != '<p>&nbsp;</p>') {
            echo @$_TPL_REPLACMENT["CONTENT_EN"];
        }
    }
    if (!isset($_REQUEST[printmode])) {
        ?>
        <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="https://yastatic.net/share2/share.js"></script>
        <div class="ya-share2" data-services="vkontakte,odnoklassniki,whatsapp,telegram,moimir,lj,viber,skype,collections,gplus" data-lang="<?php if($_SESSION[lang]!="/en") echo 'ru'; else echo 'en';?>" data-limit="6"></div>
        <?
    }

    ?>
    <?
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
}
?>