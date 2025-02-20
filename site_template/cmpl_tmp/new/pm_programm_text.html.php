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

//var_dump($page,$parent_page);
    include("pm_programm_top.php");
    ?>
    <section class="pt-3 pb-3 bg-white">
        <div class="container mb-5" style="max-width: 1400px">
            <div class="row">
                <div class="col-12">
                    <?= $page["CONTENT"] ?>
                </div>
            </div>
        </div>
    </section>

    <?php
}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.html");
?>

