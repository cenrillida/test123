<?
global $_CONFIG, $site_templater, $DB, $page_content;

if($_GET['ajax_mode']==1) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_mode");
    exit;
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");

$pg = new Pages();
$pageContent = $pg->getContentByPageId((int)$_REQUEST[page_id]);

if($pageContent['LIKE_MAIN']!=1):
    if(!empty($pageContent['RIGHT_COLLUMN'])):
    ?>

        <section class="pt-3 pb-5 bg-color-lightergray">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-xl-8 col-xs-12 pt-3 pb-3 pr-xl-4 left-column">
                        <div class="container-fluid left-column-container">
                            <?php include_once("block_presscenter_left.php");?>
                        </div>
                    </div>
                    <!-- right collumn -->
                    <div class="col-xl-4 col-xs-12 pt-3 pb-3 px-xl-0 right-column">
                        <div class="pr-3 right-column-container">
                            <div class="container-fluid">
                                <?php include_once("block_presscenter_right.php");?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    <?php
    else:?>
        <section class="pt-3 pb-5 bg-color-lightergray">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-xl-12 col-xs-12 pt-3 pb-3 pr-xl-4 central-column">
                        <div class="container-fluid left-column-container">
                            <?php include_once("block_presscenter_left.php");?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif;
else:
    $headers = new Headers();
    $elements = $headers->getHeaderElements($pageContent['LEFT_COLLUMN']);
    $elements = $headers->appendContent($elements);
    ?>

    <main>
        <?php
        if (!empty($elements)) {
            foreach ($elements as $k => $v) {
                $tpl = new Templater();
                $tpl->setValues($v);
                $tpl->setValues($v['content']);
                $tpl->appendValues(array("HEADER_ID_EDIT" => $k));
                if ($v["ctype"] == "Ôèëüòð")
                    $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));
                $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers.html");
            }
        }
        ?>
    </main>
<?php
endif;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.html");

?>
