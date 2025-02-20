<?
global $_CONFIG, $site_templater, $DB;

if($_GET['ajax_mode']==1) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."ajax_mode");
    exit;
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.presscenter.html");

$pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,p.noright,p.notop,p.rightblock,p.mobile_right_totop, lc.cv_text AS left_col, rc.cv_text AS right_col
  FROM adm_pages AS p ".
    "INNER JOIN adm_pages_content AS lc ON lc.cv_name='LEFT_COLLUMN' AND lc.page_id=p.page_id ".
    "INNER JOIN adm_pages_content AS rc ON rc.cv_name='RIGHT_COLLUMN' AND rc.page_id=p.page_id ".
    " WHERE p.page_id=".(int)$_REQUEST[page_id]);
if(!empty($pname[0]['right_col'])):
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

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.presscenter.html");

?>
