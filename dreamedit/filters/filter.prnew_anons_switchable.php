<?php

function date_to_str($date) {
    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $date, $matches);

    if($_SESSION[lang]!="/en") {
        switch ($matches[2]) {
            case "01":
                $m = 'января';
                break;
            case "02":
                $m = 'февраля';
                break;
            case "03":
                $m = 'марта';
                break;
            case "04":
                $m = 'апреля';
                break;
            case "05":
                $m = 'мая';
                break;
            case "06":
                $m = 'июня';
                break;
            case "07":
                $m = 'июля';
                break;
            case "08":
                $m = 'августа';
                break;
            case "09":
                $m = 'сентября';
                break;
            case "10":
                $m = 'октября';
                break;
            case "11":
                $m = 'ноября';
                break;
            case "12":
                $m = 'декабря';
                break;
        }
    }
    else {
        switch ($matches[2]) {
            case "01":
                $m = 'january';
                break;
            case "02":
                $m = 'february';
                break;
            case "03":
                $m = 'march';
                break;
            case "04":
                $m = 'april';
                break;
            case "05":
                $m = 'may';
                break;
            case "06":
                $m = 'june';
                break;
            case "07":
                $m = 'july';
                break;
            case "08":
                $m = 'august';
                break;
            case "09":
                $m = 'september';
                break;
            case "10":
                $m = 'october';
                break;
            case "11":
                $m = 'november';
                break;
            case "12":
                $m = 'december';
                break;
        }
    }

    $date_word = $matches[3] . " " . $m . " " . $matches[1];
    $dateResult = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
    $dateResult = date("d.m.Y г.", $date);
    return $date_word;
}

global $_CONFIG;

$pg = new Pages();

    $anons_ilines = new Ilines();

    $date_today = new DateTime();

    $date_tomorrow = new DateTime();

    $interval = new DateInterval('P1D');
    $date_tomorrow->add($interval);

    $rows_today = $anons_ilines->getLimitedElementsMultiSortByDate("**", 100, 1, "DATE2", "DESC", "status","",$date_today,"=");
    $rows_today = $anons_ilines->appendContent($rows_today);

    $rows_tomorrow = $anons_ilines->getLimitedElementsMultiSortByDate("**", 100, 1, "DATE2", "DESC", "status","",$date_tomorrow,"=");
    $rows_tomorrow = $anons_ilines->appendContent($rows_tomorrow);

    $rows_soon = $anons_ilines->getLimitedElementsMultiSortByDate("**", 100, 1, "DATE2", "DESC", "status","",$date_tomorrow,">");
    $rows_soon = $anons_ilines->appendContent($rows_soon);

    $col_md_today = 6;
    $col_xl_today = 4;

    if(count($rows_today)==1) {
        $col_md_today = 12;
        $col_xl_today = 12;
    }
    if(count($rows_today)==2) {
        $col_md_today = 6;
        $col_xl_today = 6;
    }

    $col_md_tomorrow = 6;
    $col_xl_tomorrow = 4;

    if(count($rows_tomorrow)==1) {
        $col_md_tomorrow = 12;
        $col_xl_tomorrow = 12;
    }
    if(count($rows_tomorrow)==2) {
        $col_md_tomorrow = 6;
        $col_xl_tomorrow = 6;
    }

    $col_md_soon = 6;
    $col_xl_soon = 4;

    if(count($rows_soon)==1) {
        $col_md_soon = 12;
        $col_xl_soon = 12;
    }
    if(count($rows_soon)==2) {
        $col_md_soon = 6;
        $col_xl_soon = 6;
    }

    ?>
<div class="col-12">
    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
        <?php if(!empty($rows_today)): ?>
        <li class="nav-item">
            <a class="nav-link anons-pill active" id="pills-today-anons-tab" data-toggle="pill" href="#pills-today-anons" role="tab" aria-controls="pills-today-anons" aria-selected="true">Сегодня</a>
        </li>
        <?php endif;?>
        <?php if(!empty($rows_tomorrow)): ?>
        <li class="nav-item">
            <a class="nav-link anons-pill<?php if(empty($rows_today)) echo ' active'; else echo '';?>" id="pills-tomorrow-anons-tab" data-toggle="pill" href="#pills-tomorrow-anons" role="tab" aria-controls="pills-tomorrow-anons" aria-selected="<?php if(empty($rows_today)) echo 'true'; else echo 'false';?>">Завтра</a>
        </li>
        <?php endif;?>
        <?php if(!empty($rows_soon)): ?>
        <li class="nav-item">
            <a class="nav-link anons-pill<?php if(empty($rows_today) && empty($rows_tomorrow)) echo ' active';?>" id="pills-soon-anons-tab" data-toggle="pill" href="#pills-soon-anons" role="tab" aria-controls="pills-soon-anons" aria-selected="<?php if(empty($rows_today) && empty($rows_tomorrow)) echo 'true'; else echo 'false';?>">Скоро</a>
        </li>
    <?php endif;?>
    </ul>
</div>
<div class="col-12 p-0">
    <div class="tab-content" id="pills-tabContent">
        <?php if(!empty($rows_today)):?>
        <div class="tab-pane fade show active" id="pills-today-anons" role="tabpanel" aria-labelledby="pills-today-anons-tab">
            <div class="row justify-content-center">
            <?php foreach ($rows_today as $today_element):
                if(isset($today_element["content"]["DATE2"]))
                {
                    $date_word = date_to_str($today_element["content"]["DATE2"]);
                }
                preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $today_element["content"]["DATE2"], $matches);

                $time_word = $matches[4].":".$matches[5];


                ?>
                <div class="col-12 col-md-<?=$col_md_today?> col-xl-<?=$col_xl_today?> pb-3">
                    <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative pb-5 h-100">
                        <div class="row">
                            <div class="col-12">
                                <div class="massmedia-element">
                                    <div class="massmedia-element-header mb-2"><div style="color: darkgrey;"><?=$date_word?> | <i class="far fa-clock"></i> <?=$time_word?> </div><?=$today_element["content"]["PREV_TEXT"]?></div>
                                </div>
                            </div>
                        </div>
                        <div class="news-upper-link position-absolute"><a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $today_element[el_id]))?>"><i class="fas fa-link"></i></a></div>
                        <a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $today_element[el_id]))?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
        </div>
        <?php endif;?>
        <?php if(!empty($rows_tomorrow)):?>
        <div class="tab-pane fade<?php if(empty($rows_today)) echo ' show active';?>" id="pills-tomorrow-anons" role="tabpanel" aria-labelledby="pills-tomorrow-anons-tab">
            <div class="row justify-content-center">
                <?php foreach ($rows_tomorrow as $today_element):
                    if(isset($today_element["content"]["DATE2"]))
                    {
                        $date_word = date_to_str($today_element["content"]["DATE2"]);
                    }
                    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $today_element["content"]["DATE2"], $matches);

                    $time_word = $matches[4].":".$matches[5];


                    ?>
                    <div class="col-12 col-md-<?=$col_md_tomorrow?> col-xl-<?=$col_xl_tomorrow?> pb-3">
                        <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative pb-5 h-100">
                            <div class="row">
                                <div class="col-12">
                                    <div class="massmedia-element">
                                        <div class="massmedia-element-header mb-2"><div style="color: darkgrey;"><?=$date_word?> | <i class="far fa-clock"></i> <?=$time_word?> </div><?=$today_element["content"]["PREV_TEXT"]?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="news-upper-link position-absolute"><a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $today_element[el_id]))?>"><i class="fas fa-link"></i></a></div>
                            <a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $today_element[el_id]))?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif;?>
        <?php if(!empty($rows_soon)):?>
        <div class="tab-pane fade<?php if(empty($rows_today) && empty($rows_tomorrow)) echo ' show active'; else echo '';?>" id="pills-soon-anons" role="tabpanel" aria-labelledby="pills-soon-anons-tab">
            <div class="row justify-content-center">
                <?php foreach ($rows_soon as $today_element):
                    if(isset($today_element["content"]["DATE2"]))
                    {
                        $date_word = date_to_str($today_element["content"]["DATE2"]);
                    }
                    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $today_element["content"]["DATE2"], $matches);

                    $time_word = $matches[4].":".$matches[5];


                    ?>
                    <div class="col-12 col-md-<?=$col_md_soon?> col-xl-<?=$col_xl_soon?> pb-3">
                        <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative pb-5 h-100">
                            <div class="row">
                                <div class="col-12">
                                    <div class="massmedia-element">
                                        <div class="massmedia-element-header mb-2"><div style="color: darkgrey;"><?=$date_word?> | <i class="far fa-clock"></i> <?=$time_word?> </div><?=$today_element["content"]["PREV_TEXT"]?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="news-upper-link position-absolute"><a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $today_element[el_id]))?>"><i class="fas fa-link"></i></a></div>
                            <a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $today_element[el_id]))?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>