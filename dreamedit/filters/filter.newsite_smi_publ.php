<?
global $_CONFIG;

if (empty($_TPL_REPLACMENT["FULL_SMI_ID"])) $_TPL_REPLACMENT["FULL_SMI_ID"]=503;
$ilines = new Ilines();

if($_SESSION[lang]!="/en")
    $rows = $ilines->getLimitedElementsDateRub(5, 4, @$_REQUEST["p"], "date", "DESC", "status",439,"", true);
else
    $rows = $ilines->getLimitedElementsDateRubEn(5, 4, @$_REQUEST["p"], "date", "DESC", "status",439, "", true);


$tplname='smi';


$i=1;
if(!empty($rows))
{
    echo '<div class="row">';

    $rows = $ilines->appendContent($rows);
    foreach($rows as $k => $v)
    {
        $pg = new Pages();

        if(isset($v["content"]["DATE"]))
        {
            preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
            $v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
            $v["content"]["DATE"] = date("d.m.Y", $v["content"]["DATE"]);
            if($_SESSION['lang']!="/en") {
                $v["content"]["DATE"] .= " г.";
            }
        }
        if($_SESSION['lang']=="/en") {
            $v["content"]["TITLE"] = $v["content"]["TITLE_EN"];
            $v["content"]["PREV_TEXT"] = $v["content"]["PREV_TEXT_EN"];
        }

        ?>

        <div class="col-lg-3 col-md-6 col-xs-12 pb-3<?php if($i>2) echo ' d-none d-lg-block';?>">
            <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative h-100">
                <div class="row">
                    <div class="col-12">
                        <div class="massmedia-element link-color-text">
                            <div class="massmedia-element-header mb-2"><div class="massmedia-date"><?=$v["content"]["DATE"]?></div></div>
                            <?=$v["content"]["PREV_TEXT"]?>
                        </div>
                    </div>
                </div>
                <?php if(!empty($v["content"]["FULL_TEXT"])):?>
                <div class="news-upper-link position-absolute"><a href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl($_TPL_REPLACMENT[FULL_SMI_ID], array("id" => $k, "p" => @$_REQUEST["p"]))?>"><i class="fas fa-link"></i></a></div>
                <a href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl($_TPL_REPLACMENT[FULL_SMI_ID], array("id" => $k, "p" => @$_REQUEST["p"]))?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                <?php endif;?>
            </div>
        </div>

        <?php

        $i++;
    }
    echo  '</div>';
    ?>
    <div class="row">
        <div class="col-12 text-center">
            <div class="video-text mt-5 mb-3">
                <a class="btn btn-lg imemo-button text-uppercase" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=632" role="button"><?php if ($_SESSION[lang]!="/en") echo 'Все'; else echo "All";?></a>
            </div>
        </div>
    </div>
    <?php
}

?>
