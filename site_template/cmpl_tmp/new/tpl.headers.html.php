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
if($_TPL_REPLACMENT["FNAME"] == "NEWSITE_NEWS_MAIN_ANONS") {
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

    if($_GET[debug]==20) {
        foreach($rows_anons_headers as $k => $v)
        {
            if($v[el_id]=="5570") {
                $rows_anons_headers[$k]["content"]["DATE2"] = "2019.12.28 16:02";
                $rows_anons_headers[$k]["content"]["DATE"] = "2019.12.28 16:02";
            }
        }
    }

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
$title_size = 2;
if(!empty($_TPL_REPLACMENT["TITLESIZE"])) {
    $title_size = $_TPL_REPLACMENT["TITLESIZE"];
}

if ($_SESSION[lang]=='/en' || !empty($_TPL_REPLACMENT["TEXT"]) || $_TPL_REPLACMENT["CTYPE"] =="Фильтр")
{
    $link = "";

	if ($_SESSION[lang]!='/en') {
	    $suff='';
	    if(!empty($_TPL_REPLACMENT["TITLE_LINK"])) {
            $link = $_TPL_REPLACMENT["TITLE_LINK"];
        }
	} else {
	    $suff='_EN';
        if(!empty($_TPL_REPLACMENT["TITLE_LINK_EN"])) {
            $link = $_TPL_REPLACMENT["TITLE_LINK_EN"];
        }
    }



    if (!empty($_TPL_REPLACMENT["TITLENEW".$suff])) $_TPL_REPLACMENT["TITLE".$suff]=$_TPL_REPLACMENT["TITLENEW".$suff];

    if(($_TPL_REPLACMENT["CTYPE"] == "Фильтр" && $show) || $_TPL_REPLACMENT["CTYPE"] != "Фильтр"):
    ?>
    <section id="S<?=$_TPL_REPLACMENT["SORT"]?>" class="mb-<?=$_TPL_REPLACMENT["MARGIN_BOTTOM"]?> mt-<?=$_TPL_REPLACMENT["MARGIN_TOP"]?> pt-<?=$_TPL_REPLACMENT["PADDING_TOP"]?> pb-<?=$_TPL_REPLACMENT["PADDING_BOTTOM"]?>"<?php if(!empty($_TPL_REPLACMENT["BACKGROUND_COLOR"])) echo ' style="background-color: '.$_TPL_REPLACMENT["BACKGROUND_COLOR"].'"';?>>
        <?php if($_TPL_REPLACMENT["IN_CONTAINER"]):?>
        <div class="container-fluid">
            <?php endif;
            if($_TPL_REPLACMENT["SHOWTITLE"]): ?>
            <div class="row mb-3">
                <div class="col-12">
                    <?php if(empty($link)):?>
                        <h<?=$title_size?> class="pl-2 pr-2 border-bottom text-center text-uppercase"><?=$_TPL_REPLACMENT["TITLE".$suff]?></h<?=$title_size?>>
                    <?php else:?>
                        <h<?=$title_size?> class="pl-2 pr-2 border-bottom text-center text-uppercase"><a href="<?=$link?>"><?=$_TPL_REPLACMENT["TITLE".$suff]?></a></h<?=$title_size?>>
                    <?php endif;?>
                </div>
            </div>
            <?endif;
    endif;
	if($_TPL_REPLACMENT["CTYPE"] == "Фильтр")
	{
        if($_GET[debug]==2) {
            echo $_TPL_REPLACMENT["FILTERCONTENT"];
        } else {
            include($_TPL_REPLACMENT["FILTERCONTENT"]);
        }
	}
	else if($_TPL_REPLACMENT["CTYPE"] == "Текст")
	{
	    ?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-xs-12">
						<?=$_TPL_REPLACMENT["TEXT".$suff]?>
					</div>
				</div>
		<?
	}
	else if($_TPL_REPLACMENT["CTYPE"] == "Jour")
	{

		$aa=explode('src="',$_TPL_REPLACMENT["TEXT".$suff]);
		$aa2=explode('"',$aa[1]);

		echo "<div style='height:236px;background: url(".$aa2[0].") no-repeat';>";
		echo "<div style='text-align:right;position:relative;right:10px;top:170px;color:white;'>";
		echo "".$_TPL_REPLACMENT[ISSN]."<br />";
		if (!empty($_TPL_REPLACMENT[IMPACT]))
		if ($_SESSION[lang]!='/en' )
			echo "Импакт-фактор РИНЦ: ".$_TPL_REPLACMENT[IMPACT]."<br />";
		else
			echo "Impact-factor RINC: ".$_TPL_REPLACMENT[IMPACT]."<br />";

		echo "".$_TPL_REPLACMENT['SERIES'.$suff]."<br />";
		echo "</div>";
		echo "</div>";
		echo "<h2>".$_TPL_REPLACMENT[PAGE_NAME_EN]."</h2>";
	//	echo $_TPL_REPLACMENT["TEXT".$suff];
	}
    if(($_TPL_REPLACMENT["CTYPE"] == "Фильтр" && !empty($_TPL_REPLACMENT["FILTERCONTENT"])) || $_TPL_REPLACMENT["CTYPE"] != "Фильтр"):
	            if($_TPL_REPLACMENT["IN_CONTAINER"]):?>
        </div>
        <?php endif;?>
    </section>
<?php endif;
}

if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_TPL_REPLACMENT['HEADER_ID_EDIT'])) {
    ?>
    </div>
    <?php
}

?>

