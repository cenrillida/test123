<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;

// Новости на главной
//print_r($page_content);

$ilines = new Ilines();
$ievent = new Events();
$pg = new Pages();
if ($_SESSION[lang]=='/en') $suff='_en';else $suff="";


$rows = $ilines->getLimitedElementsMultiSort("**", 15, 1,"DATE2", "DESC", "status");

$name0=$ilines->getTypeById($page_content["NEWS_BLOCK_LINE"]);

//echo "<a hidden=true href=aaa>".$page_content["NEWS_BLOCK_LINE"]."</a>";

$date = new DateTime();
$interval = new DateInterval('P1D');
$date->add($interval);
//echo "<h3>".$name0[itype_name]."</h3>";
//print_r($page_content);
//echo "<<<<<".$page_content["NEWS_BLOCK_PAGE"];
//print_r($rows);
if(!empty($rows) )
{
    $rows = $ilines->appendContent($rows);
//print_r($rows);
    foreach($rows as $k => $v)
    {
        //echo "<a hidden=true src=test>".$ilines->getNewsOutOfMain($v[el_id])."</a>";
        if($ilines->getNewsOutOfMain($v[el_id]))
            unset($rows[$k]);

    }

    $rows=array_values($rows);

    $rows = array_reverse($rows);


    $first_element=true;
    foreach($rows as $k => $v)
    {
        if($v[itype_id]==1 || $v[itype_id]==4)
        {
            //echo "<a hidden=true href=aaa>".$v[itype_id]."</a>";
//echo "<br />___";print_r($v);"<br />___";
            if (empty($v["content"]["DATE2"])) $v["content"]["DATE2"]=$v["content"]["DATE"];

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

            if(($v["content"]["DATE2"]> $date->format("Y.m.d")) || $today_flag)
            {
                if ($_SESSION[lang]=='/en')
                {
                    $v["content"]["PREV_TEXT"]=$v["content"]["PREV_TEXT_EN"];
                    $v["content"]["LAST_TEXT"]=$v["content"]["LAST_TEXT_EN"];
                    if($v["content"]["PREV_TEXT"]=="<p>&nbsp;</p>" || empty($v["content"]["PREV_TEXT"]))
                        continue;
                    //		if (empty($v["content"]["LAST_TEXT"])) $v["content"]["LAST_TEXT"]="@@".$v["content"]["PREV_TEXT"];
                }
                if(isset($v["content"]["DATE"]))
                {
                    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
                    $v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
                    $v["content"]["DATE"] = date("d.m.Y г.", $v["content"]["DATE"]);
                }

                $date_word = "";
                $time_word = "";
                if(isset($v["content"]["DATE2"]))
                {
                    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE2"], $matches);

                    $time_word = $matches[4].":".$matches[5];
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
                    $v["content"]["DATE2"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
                    $v["content"]["DATE2"] = date("d.m.Y г.", $v["content"]["DATE2"]);
                }
                $event_text = "Мероприятие";
                if($_SESSION[lang]=="/en")
                    $event_text = "Event";

                $count=1;
                if($first_element): $first_element=false;?>
<div class="container-fluid"><div class="row justify-content-center">
                <?php endif;?>
                                <div class="col-12 pb-3">
                                    <div class="mx-auto p-3 text-left container-fluid shadow bg-white massmedia-board mb-3 position-relative pb-5 h-100">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="massmedia-element">
                                                    <div class="massmedia-element-header mb-2"><div style="color: darkgrey;"><?=$date_word?> | <i class="far fa-clock"></i> <?=$time_word?> </div><?=$v["content"]["PREV_TEXT"]?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="news-upper-link position-absolute"><a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $v[el_id], "p" => @$_REQUEST["p"]))?>"><i class="fas fa-link"></i></a></div>
                                        <a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $v[el_id], "p" => @$_REQUEST["p"]))?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                                    </div>
                                </div>
                <?php
                $count++;
            }
        }
    }
                if(!$first_element) echo '</div></div>';

                /*
                    if(!$first_element): ?>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <div class="video-text mt-5 mb-3">
                                            <a class="btn btn-lg imemo-button text-uppercase" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=498" role="button"><?php if($_SESSION[lang]!='/en') echo 'Другие новости'; else echo 'Other News';?></a>
                                        </div>
                                    </div>
                                </div>
                    <?php endif;*/
}
?>
