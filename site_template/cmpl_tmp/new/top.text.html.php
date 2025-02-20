<?
	global $DB,$_CONFIG, $site_templater; 
//echo $_TPL_REPLACMENT["TITLE_EN"];	
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");
	$dd=$DB->select("SELECT page_template FROM adm_pages WHERE page_id=".(int)$_REQUEST["page_id"]);
	if (!empty($_REQUEST["id"]) && substr($dd[0]["page_template"],0,8)=='magazine' && $dd[0]["page_template"]!='magazine_author')
	{
	$pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,IFNULL(m.page_name,'') AS mname,IFNULL(m.page_name_en,'') AS mname_en,title_seo,title_seo_en FROM adm_pages AS p 
	 LEFT OUTER JOIN adm_magazine AS m ON m.page_id=".(int)$_REQUEST["id"].
	" WHERE p.page_id=".(int)$_REQUEST["page_id"]);
	
	} 
	 else
	  $pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,p.noright,p.notop,p.nobreadcrumbs,p.activatestat,p.noprint,p.title_uppercase
	  FROM adm_pages AS p ".
	 
	" WHERE p.page_id=".(int)$_REQUEST["page_id"]);
//print_r($pname); echo $_TPL_REPLACMENT["TITLE_EN"];

//echo "pname=".$pname[0][page_template]," title=".$_TPL_REPLACMENT["TITLE"];
if (empty($_TPL_REPLACMENT["TITLE_EN"]) || $_TPL_REPLACMENT["TITLE_EN"]=='Editions') $_TPL_REPLACMENT["TITLE_EN"]=$pname[0]["page_name_en"];
//print_r($pname); echo "!".$_TPL_REPLACMENT["TITLE_EN"];
if ($pname[0]["page_template"]=='magazine_full')
{
  $_TPL_REPLACMENT["TITLE"]=$pname[0]["mname"];
  if (!empty($pname[0]["mname_en"])) $_TPL_REPLACMENT["TITLE_EN"]=$pname[0]["mname_en"];
}
//print_r($pname); echo "!".$_TPL_REPLACMENT["TITLE_EN"];
if(empty($_TPL_REPLACMENT["TITLE_EN"]) || $_SESSION["lang"]=='/en' || $_TPL_REPLACMENT["TITLE_EN"]=='Editions')
{
if ($_SESSION["lang"]=='/en' && (empty($_TPL_REPLACMENT["TITLE"]) &&  $pname[0]["page_template"]!='news_full' && substr($pname[0]["page_template"],0,8)!='magazine'))
 $_TPL_REPLACMENT["TITLE_EN"]=$pname[0]["page_name_en"];
}
//print_r($pname); echo $_TPL_REPLACMENT["TITLE_EN"];


if($_REQUEST["rub"]==492 && $_REQUEST["page_id"]==498)
{
	if ($_SESSION["lang"]=='/en')
	$_TPL_REPLACMENT["TITLE"]='News FANO';
	else
	$_TPL_REPLACMENT["TITLE"]='Новости ФАНО России';
}
//echo "___".$_TPL_REPLACMENT["TITLE"]." ".$pname[0][page_name_en];
$all_views = 0;
if($pname[0]['activatestat']==1) {
    $eng_stat = "";
    if($_SESSION["lang"]=="/en")
        $eng_stat = "-en";
    //Statistic::theCounter("pageid-".(int)$_REQUEST[page_id].$eng_stat);
    Statistic::ajaxCounter("pageid",(int)$_REQUEST["page_id"]);
    $all_views = Statistic::getAllViews("pageid-".(int)$_REQUEST["page_id"].$eng_stat);
}

?>
<section class="pt-3 pb-5 bg-color-lightergray">
    <div class="container-fluid">
        <div class="row printables-row">
            <!-- left column -->
            <div class="<?php if($pname[0]['noright']=='1' || $_TPL_REPLACMENT['NO_RIGHT_COLUMN']=='1') echo 'col-xl-12'; elseif(!empty($_TPL_REPLACMENT['LEFT_BLOCK_CUSTOM_SIZE'])) echo 'col-xl-'.$_TPL_REPLACMENT['LEFT_BLOCK_CUSTOM_SIZE']; else echo 'col-xl-9';?> col-xs-12 pt-3 pb-3 pr-xl-4">
                <div class="container-fluid left-column-container">
                    <div class="row shadow border bg-white printables">
                        <?php if($pname[0]['nobreadcrumbs']==0): ?>
                        <div class="col-12 pt-3 printable-none">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <?php
                                    if($_GET["debug"]==2) {
                                        echo $_TPL_REPLACMENT["BREADCRUMBS"];
                                    } else {
                                        include($_TPL_REPLACMENT["BREADCRUMBS"]);
                                    }?>
                                </ol>
                            </nav>
                        </div>
                        <?php endif;?>
                        <?php if($_REQUEST["page_id"]==491):?>
                            <div class="col-12 pt-3 pb-3">
                                <div class="container-fluid border-bottom mb-4">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 text-center text-lg-left order-lg-0">
                                            <img class="mb-3" src="/images/OrdenTKZ-PNG-01-sm.png" style="width: 80px;" alt="">
                                        </div>
                                        <div class="col-12 col-lg-4 mt-lg-auto order-last order-lg-1">
                                            <?php
                                            if($pname[0]['notop']==0) {
                                                if ($_SESSION["lang"] != "/en") {
                                                    $title_seo = $_TPL_REPLACMENT["TITLE"];

                                                    if(!empty($_TPL_REPLACMENT["TITLE_SEO_ILINES"])) {
                                                        $title_seo = $_TPL_REPLACMENT["TITLE_SEO_ILINES"];
                                                    } elseif(!empty($pname[0]["title_seo"])) {
                                                        $title_seo = $pname[0]["title_seo"];
                                                    }
                                                    echo "<h3 class=\"pl-2 pr-2 text-center h3-title\">" . $title_seo . "</h3>";

                                                } else {

                                                    $title_seo = $_TPL_REPLACMENT["TITLE_EN"];

                                                    if(!empty($_TPL_REPLACMENT["TITLE_SEO_ILINES_EN"])) {
                                                        $title_seo = $_TPL_REPLACMENT["TITLE_SEO_ILINES_EN"];
                                                    } elseif(!empty($pname[0]["title_seo_en"])) {
                                                        $title_seo = $pname[0]["title_seo_en"];
                                                    }

                                                    if ($title_seo != '') {
                                                        echo "<h3 class=\"pl-2 pr-2 text-center h3-title\"'>" . $title_seo . "</h3>";
                                                    } else
                                                        echo "<h3 class=\"pl-2 pr-2 text-center h3-title\"'>" . $_TPL_REPLACMENT["TITLE"] . "</h3>";


                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-12 col-lg-4 order-lg-2 mb-3 mb-lg-0">
                                            <div class="text-lg-right text-center">
                                                <?php if ($_SESSION["lang"] != "/en"): ?>
                                                    <?php if ($pname[0]["page_template"] != 'experts'):?>
                                                        <a class="btn btn-lg imemo-button text-uppercase imemo-print-button" href="#" onclick='event.preventDefault(); window.print();' role="button">Распечатать</a>
                                                    <?php endif;?>
                                                <?php else:?>
                                                    <a class="btn btn-lg imemo-button text-uppercase imemo-print-button" href="#" onclick='event.preventDefault(); window.print();' role="button">Print</a>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if($pname[0]['notop']==0 && $_REQUEST["page_id"]!=491): ?>
                        <div class="col-12 pt-3 pb-3">
                            <div class="container-fluid">
                                <?php if($pname[0]['noprint']==0): ?>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-lg-12 col-xs-12 mt-3 mt-lg-0 printable-none">
                                        <div class="text-lg-right text-center">
                                            <?php if ($_SESSION["lang"] != "/en"): ?>
                                                <?php if ($pname[0]["page_template"] != 'experts'):?>
                                                <a class="btn btn-lg imemo-button text-uppercase imemo-print-button" href="#" onclick='event.preventDefault(); window.print();' role="button">Распечатать</a>
                                                <?php endif;?>
                                            <?php else:?>
                                                <a class="btn btn-lg imemo-button text-uppercase imemo-print-button" href="#" onclick='event.preventDefault(); window.print();' role="button">Print</a>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <div class="row mb-3">
                                    <div class="col-12 small">
                                        <?php
                                        if($pname[0]['notop']==0 && $_TPL_REPLACMENT['NO_TOP']!=1) {
                                            $uppercaseTitle = "";
                                            if($pname[0]['title_uppercase'] == 1) {
                                                $uppercaseTitle = " text-uppercase";
                                            }
                                            if ($_SESSION["lang"] != "/en") {
                                                $title_seo = $_TPL_REPLACMENT["TITLE"];

                                                if(!empty($_TPL_REPLACMENT["TITLE_SEO_ILINES"])) {
                                                    $title_seo = $_TPL_REPLACMENT["TITLE_SEO_ILINES"];
                                                } elseif(!empty($pname[0]["title_seo"])) {
                                                    $title_seo = $pname[0]["title_seo"];
                                                }
                                                echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom h3-title$uppercaseTitle\">" . $title_seo . "</h3>";

                                            } else {

                                                $title_seo = $_TPL_REPLACMENT["TITLE_EN"];

                                                if(!empty($_TPL_REPLACMENT["TITLE_SEO_ILINES_EN"])) {
                                                    $title_seo = $_TPL_REPLACMENT["TITLE_SEO_ILINES_EN"];
                                                } elseif(!empty($pname[0]["title_seo_en"])) {
                                                    $title_seo = $pname[0]["title_seo_en"];
                                                }

                                                if ($title_seo != '') {
                                                    echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom h3-title$uppercaseTitle\"'>" . $title_seo . "</h3>";
                                                } else
                                                    echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom h3-title$uppercaseTitle\"'>" . $_TPL_REPLACMENT["TITLE"] . "</h3>";


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
                        if ($pname[0]['activatestat'] == 1) {
                            Statistic::getAjaxViews("pageid", (int)$_REQUEST["page_id"]);
                            echo "<div style='text-align: right; color: #979797;'><img alt='' width='15px' style='vertical-align: middle' src='/img/eye.png'/> <span id='stat-views-counter' style='vertical-align: middle'>".$all_views."</span></div>";
                        }
                        ?>
