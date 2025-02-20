<?


if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_TPL_REPLACMENT['HEADER_ID_EDIT'])) {
?>
<div class="position-relative">
    <div class="position-absolute" style="top: 5px; left: 5px; z-index: 2">
        <a target="_blank" href="/dreamedit/index.php?mod=headers&action=edit&type=l&id=<?=$_TPL_REPLACMENT['HEADER_ID_EDIT']?>"><i class="fas fa-edit text-danger bg-white p-1"></i></a>
    </div>


    <?php
    }

$show = true;
if($_TPL_REPLACMENT["FNAME"] == "PRNEW_ANONS") {
    $ilines_headers = new Ilines();
    $rows_anons_headers = $ilines_headers->getLimitedElementsMultiSort("**", 15, 1, "DATE2", "DESC", "status");

    $date = new DateTime();
    $interval = new DateInterval('P1D');
    $date->add($interval);

    $rows_anons_headers = $ilines_headers->appendContent($rows_anons_headers);
//print_r($rows);
    foreach($rows_anons_headers as $k => $v)
    {
        //echo "<a hidden=true src=test>".$ilines->getNewsOutOfMain($v[el_id])."</a>";
        if($ilines_headers->getNewsOutOfMain($v[el_id]))
            unset($rows[$k]);

    }

    $rows_anons_headers=array_values($rows_anons_headers);

    $rows_anons_headers = array_reverse($rows_anons_headers);

    $anons_count = 0;
    foreach ($rows_anons_headers as $k => $v) {
        if (empty($v["content"]["DATE2"])) $v["content"]["DATE2"] = $v["content"]["DATE"];

        preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE2"], $matches);
        $time = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
        $day = date("Y.m.d", $time);
        $time = date("H:i:s", $time);
        $today_flag = false;
        if($day==date("Y.m.d")) {
            if (!$v["content"]["TIME_IMPORTANT"]) {
                $time = "07:00:00";
            }
            if (date("Y.m.d " . $time) > date("Y.m.d H:i:s")) {
                $today_flag = true;
            }
        }

        if (($v["content"]["DATE2"]> $date->format("Y.m.d")) || $today_flag) {
            if ($_SESSION[lang] == '/en') {
                $v["content"]["PREV_TEXT"] = $v["content"]["PREV_TEXT_EN"];
                $v["content"]["LAST_TEXT"] = $v["content"]["LAST_TEXT_EN"];
                if ($v["content"]["PREV_TEXT"] == "<p>&nbsp;</p>" || empty($v["content"]["PREV_TEXT"]))
                    continue;
            }
            $anons_count++;
        }
    }
    if($anons_count==0) {
        $show = false;
    }
}
if($_TPL_REPLACMENT["FNAME"] == "PRNEW_ANONS_SWITCHABLE") {
    $anons_ilines = new Ilines();
    $date_today = new DateTime();
    $rows_today = $anons_ilines->getLimitedElementsMultiSortByDate("**", 100, 1, "DATE2", "DESC", "status","",$date_today,">=");

    if(empty($rows_today)) {
        $show = false;
    }
}
if($show) {
    if ($_SESSION[lang] == '/en' || !empty($_TPL_REPLACMENT["TEXT"]) || $_TPL_REPLACMENT["CTYPE"] == "Фильтр") {

        if ($_SESSION[lang] != '/en') $suff = ''; else $suff = '_EN';
        if (!empty($_TPL_REPLACMENT["TITLENEW" . $suff])) $_TPL_REPLACMENT["TITLE" . $suff] = $_TPL_REPLACMENT["TITLENEW" . $suff];

        if (($_TPL_REPLACMENT["CTYPE"] == "Фильтр" && !empty($_TPL_REPLACMENT["FILTERCONTENT"])) || $_TPL_REPLACMENT["CTYPE"] != "Фильтр"):
            if ($_TPL_REPLACMENT["SHOWTITLE"]):
                $title_box = 'border-bottom';
                if ($_TPL_REPLACMENT["CCLASS"] == "Красный PR") {
                    $title_box = 'pr-red-title';
                }
                if ($_TPL_REPLACMENT["CCLASS"] == "Серый текст PR") {
                    $title_box = 'pr-graytext-title';
                }

                ?>
                <div class="row justify-content-center mb-3">
                    <div class="col-12 text-center">
                        <h5 class="pl-2 pr-2 <?=$title_box?> text-uppercase"><?= $_TPL_REPLACMENT["TITLE" . $suff] ?></h5>
                    </div>
                </div>
            <?endif;
        endif;

        $styleCommon = "";

        if(!empty($_TPL_REPLACMENT["BACKGROUND_COLOR"])) $styleCommon = ' style="background-color: '.$_TPL_REPLACMENT["BACKGROUND_COLOR"].'"';

        if ($_TPL_REPLACMENT["CTYPE"] == "Фильтр") {
            echo '<div class="row justify-content-center mb-3"'.$styleCommon.'>';
            if ($_GET[debug] == 2) {
                echo $_TPL_REPLACMENT["FILTERCONTENT"];
            } else {
                include($_TPL_REPLACMENT["FILTERCONTENT"]);
            }

            echo '</div>';
        } else if ($_TPL_REPLACMENT["CTYPE"] == "Текст") {
            ?>
            <?php if($_TPL_REPLACMENT['REM_CARD']!=1 && $_TPL_REPLACMENT["CCLASS"]!="Без подложки"):?>
            <div class="row justify-content-center mb-3"<?=$styleCommon?>>
                <div class="col-12 pb-3">
                    <div class="shadow border bg-white p-3 h-100">
                        <div class="row">
                            <div class="col-12">
            <?php endif;?>
                                <?= $_TPL_REPLACMENT["TEXT" . $suff] ?>

            <?php if($_TPL_REPLACMENT['REM_CARD']!=1 && $_TPL_REPLACMENT["CCLASS"]!="Без подложки"):?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <?
        } else if ($_TPL_REPLACMENT["CTYPE"] == "Jour") {

            $aa = explode('src="', $_TPL_REPLACMENT["TEXT" . $suff]);
            $aa2 = explode('"', $aa[1]);

            echo "<div style='height:236px;background: url(" . $aa2[0] . ") no-repeat';>";
            echo "<div style='text-align:right;position:relative;right:10px;top:170px;color:white;'>";
            echo "" . $_TPL_REPLACMENT[ISSN] . "<br />";
            if (!empty($_TPL_REPLACMENT[IMPACT]))
                if ($_SESSION[lang] != '/en')
                    echo "Импакт-фактор РИНЦ: " . $_TPL_REPLACMENT[IMPACT] . "<br />";
                else
                    echo "Impact-factor RINC: " . $_TPL_REPLACMENT[IMPACT] . "<br />";

            echo "" . $_TPL_REPLACMENT['SERIES' . $suff] . "<br />";
            echo "</div>";
            echo "</div>";
            echo "<h2>" . $_TPL_REPLACMENT[PAGE_NAME_EN] . "</h2>";
            //	echo $_TPL_REPLACMENT["TEXT".$suff];
        }
    }
}

    if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_TPL_REPLACMENT['HEADER_ID_EDIT'])) {
    ?>
</div>
<?php
}

?>

